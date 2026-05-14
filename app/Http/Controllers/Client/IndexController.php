<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Archive;
use App\Models\Page;
use App\Models\PageCategories;
use App\Models\News;
use App\Models\Publication;
use App\Models\Administration;
use App\Models\Employee;
use App\Models\Structure;
use App\Models\LawCategory;
use App\Models\PhotoGallery;
use App\Models\VideoGallery;
use App\Models\PublicationCategory;
use App\Models\Scholar;
use App\Models\ScholarWord;
use App\Models\Journal;
use App\Models\JournalArticle;
use App\Models\Offer;
use App\Models\Slider;
use App\Models\HashTag;
use Carbon\Carbon;
use Validator;

class IndexController extends Controller
{
    public function changeLocale($locale){
      $allowed = ['uz', 'ru', 'en'];
      if (!in_array($locale, $allowed, true)) {
        return back();
      }

      session(['locale' => $locale]);
      \App::setLocale($locale);
      return back();
    }



    public function index(){
      // $time = "SELECT UPDATE_TIME FROM   information_schema.tables WHERE  TABLE_SCHEMA = 'ifmruz' AND TABLE_NAME = 'tabname'";
      // $time = \DB::select("SELECT UPDATE_TIME as UPT FROM   information_schema.tables WHERE  TABLE_SCHEMA = 'ifmruz'");
      // $time = static::mysql_query($time);
      // echo $time[0];
      // $tim = \DB::select("SELECT MAX(updated_at) as last_update FROM information_schema.tables WHERE TABLE_SCHEMA='ifmruz' GROUP BY TABLE_SCHEMA");

      // dd($tim);
      $news   = News::orderBy('created_at', 'DESC')->join('news_archives', function ($join) {
        $join->on('news.id', '=', 'news_archives.news_id')
               ->where('news_archives.archive_id', '=', 1);
      })->limit(4)->get();
      $news_ca = News::orderBy('created_at', 'DESC')->join('news_archives', function ($join) {
        $join->on('news.id', '=', 'news_archives.news_id')
               ->where('news_archives.archive_id', '=', 5);
      })->limit(4)->get();
      $reviews = News::orderBy('created_at', 'DESC')->join('news_archives', function ($join) {
        $join->on('news.id', '=', 'news_archives.news_id')
               ->where('news_archives.archive_id', '=', 3);
      })->limit(4)->get();
      $publications = Publication::orderBy('created_at', 'DESC')->join('publications_category', function ($join) {
        $join->on('publications.id', '=', 'publications_category.publication_id')
               ->where('publications_category.publication_category_id', '=', 1);
      })->limit(4)->get();
      $article = PublicationCategory::find(1);
      $econom = array();
      $limit = 0;
      $economics    = Publication::orderBy('created_at', 'DESC')->get();
      foreach($economics as $economic){
        foreach($economic->categories as $categories){
          if($categories->parent_id == 2 && $limit<5){
              $limit++;
              $econom[]=$economic;
              break;
          }
        }
      }
      $category     = PublicationCategory::find(2);
      $journals     = Journal::orderBy('sort')->limit(6)->get();
      $sliders      = Slider::where('status', 'active')->get()->all();
      $infographics = PhotoGallery::where('status', 'infographics')->orderBy('sort')->limit(6)->get();
      return view('client.index', compact('category', 'news', 'reviews', 'publications', 'journals', 'sliders', 'infographics', 'econom', 'article', 'news_ca'));
    }


    public function archives($slug){
      $archive = Archive::where('slug', $slug)->get()->first();
      $items = $archive
                 ? News::orderBy('created_at', 'DESC')->whereHas('categories', function ($join) use ($archive) {
                     $join->where('id', '=', $archive->id);
                   })->paginate(10)
                 : new \Illuminate\Pagination\LengthAwarePaginator(collect(), 0, 10);
      $archives = Archive::orderBy('id', 'ASC')->get();

      return view('client.archives', compact('archive', 'items', 'archives'));
    }


    public function news($slug, $slug1){
      $archive = Archive::where('slug', $slug)->get()->first();
      $item = News::where('slug', $slug1)->get()->first();
      News::where('slug', $slug1)->update(['views'=>$item->views+1]);
      $item = News::where('slug', $slug1)->get()->first();
      $item1 = News::where('id', '<', $item->id)->whereHas('categories', function ($join) use ($archive) {
        $join->where('id', '=', $archive->id);
      })->get()->first();
      $item2 = News::where('id', '>', $item->id)->whereHas('categories', function ($join) use ($archive) {
        $join->where('id', '=', $archive->id);
      })->get()->first();

      return view('client.news', compact('item', 'item1', 'item2', 'archive'));
    }


    public function page($slug){
      $item = Page::where('slug', $slug)->get()->first();
      Page::where('slug', $slug)->update(['views'=>$item->views+1]);
      $item = Page::where('slug', $slug)->get()->first();
      $item1 = Page::where('id', '<', $item->id)->get()->first();
      $item2 = Page::where('id', '>', $item->id)->get()->first();

      return view('client.page', compact('item', 'item1', 'item2'));
    }


    public function pages($slug){
      $item = PageCategories::where('slug', $slug)->get()->first();

      return view('client.pages', compact('item'));
    }


    public function administrations(){
      $items    = Administration::orderBy('id', 'ASC')->get();
      $director = $items->first();
      $deputies = $items->slice(1)->values();

      return view('client.administrations', compact('items', 'director', 'deputies'));
    }


    public function employees(){
      // Heads (no head_id) — shown on main listing. Each carries its team via the relation.
      $heads = Employee::whereNull('head_id')
                        ->with(['team' => function($q){ $q->orderBy('sort')->orderBy('id'); }])
                        ->orderBy('sort')
                        ->orderBy('id')
                        ->get();

      return view('client.employees', compact('heads'));
    }


    public function structure(){
      $items = Structure::orderBy('sort', 'ASC')->get();
      $byColumn = $items->groupBy('column');

      // Department groups (columns 1..3) — each has 1 parent + N children
      $deptGroups = collect();
      foreach (['1', '2', '3'] as $col) {
        $colItems = $byColumn->get($col, collect());
        $parent   = $colItems->firstWhere('is_parent', 'yes');
        $children = $colItems->where('is_parent', '!=', 'yes')->values();
        if ($parent || $children->isNotEmpty()) {
          $deptGroups->push([
            'parent'   => $parent,
            'children' => $children,
          ]);
        }
      }

      // Support services (column 4) — flat list, parents skipped
      $supportItems = $byColumn->get('4', collect())
                               ->where('is_parent', '!=', 'yes')
                               ->values();

      $countGroups   = $deptGroups->count();
      $countProjects = $deptGroups->sum(fn($g) => $g['children']->count());
      $countSupport  = $supportItems->count();

      return view('client.structure', compact(
        'items', 'deptGroups', 'supportItems',
        'countGroups', 'countProjects', 'countSupport'
      ));
    }


    public function laws($slug){
      $category = LawCategory::where('slug', $slug)->first();
      $laws     = $category
                    ? $category->laws()->orderBy('created_at', 'DESC')->get()
                    : collect();

      return view('client.laws', compact('category', 'slug', 'laws'));
    }


    public function photos(){
      $items = PhotoGallery::where('status', 'gallery')->orderBy('sort')->get()->all();

      return view('client.photos', compact('items'));
    }


    public function science(){
      // For doctoral students
      $doctoralCat = PageCategories::where('slug', 'for-doctoral-students')->first();
      $doctoral    = $doctoralCat
                       ? $doctoralCat->pages()->limit(6)->get()
                       : collect();
      $doctoralCount = $doctoralCat ? $doctoralCat->pages()->count() : 0;

      // Scientific council info
      $councilCat = PageCategories::where('slug', 'naucnyi-sovet')->first();
      $council    = $councilCat
                      ? $councilCat->pages()->limit(4)->get()
                      : collect();

      // Council meetings
      $meetingsCat = PageCategories::where('slug', 'scientific-council-meeting')->first();
      $meetings    = $meetingsCat
                       ? $meetingsCat->pages()->limit(4)->get()
                       : collect();

      // Dissertation protection (scholars)
      $scholars      = Scholar::orderBy('created_at', 'DESC')->limit(6)->get();
      $scholarsCount = Scholar::count();

      return view('client.science', compact(
        'doctoralCat', 'doctoral', 'doctoralCount',
        'councilCat',  'council',
        'meetingsCat', 'meetings',
        'scholars',    'scholarsCount'
      ));
    }


    public function press(){
      // News archive (id=1 is the main "news" archive)
      $newsArchive = Archive::where('slug', 'news')->first();
      $news = $newsArchive
                ? News::orderBy('created_at', 'DESC')->whereHas('categories', function ($q) use ($newsArchive) {
                    $q->where('id', $newsArchive->id);
                  })->limit(7)->get()
                : collect();

      // Conferences page category
      $conferencesCat = PageCategories::where('slug', 'informaciya-o-predstoyashhix-konferenciyax-1')->first();
      $conferences    = $conferencesCat
                          ? $conferencesCat->pages()->limit(4)->get()
                          : collect();

      // Materials collection page category
      $materialsCat = PageCategories::where('slug', 'sbornik-materialov')->first();
      $materials    = $materialsCat
                        ? $materialsCat->pages()->limit(4)->get()
                        : collect();

      // Photo gallery (only with non-empty image)
      $photos = PhotoGallery::where('status', 'gallery')
                              ->whereNotNull('image')
                              ->where('image', '!=', '')
                              ->orderBy('sort')
                              ->limit(16)
                              ->get();

      // Video gallery
      $videos = VideoGallery::orderBy('id', 'DESC')->limit(6)->get();

      // All archive categories (chips)
      $archives = Archive::orderBy('id', 'ASC')->get();

      return view('client.press', compact(
        'news', 'newsArchive', 'archives',
        'conferences', 'conferencesCat',
        'materials', 'materialsCat',
        'photos', 'videos'
      ));
    }


    public function videos(){
      $items = VideoGallery::get()->all();

      return view('client.videos', compact('items'));
    }


    public function publications($slug){
      $item = PublicationCategory::where('slug', $slug)->get()->first();
      if($item->child()->exists()){
        return view('client.publication_categories', compact('item'));
      }else{
        $archive =  PublicationCategory::where('slug', $slug)->get()->first();
        $items = Publication::orderBy('created_at', 'DESC')->whereHas('categories', function ($join) use ($archive) {
          $join->where('id', '=', $archive->id);
        })->paginate(10);

        return view('client.publications', compact('archive', 'items'));
      }

    }


    public function publicationsAll(){

        $items = Publication::orderBy('created_at', 'DESC')->with('categories')->paginate(10);

        return view('client.publications_all', compact('items'));


    }


    public function publicationItem($slug, $slug1){
      $archive = PublicationCategory::where('slug', $slug)->get()->first();
      $item = Publication::where('slug', $slug1)->get()->first();
      Publication::where('slug', $slug1)->update(['views'=>$item->views+1]);
      $item = Publication::where('slug', $slug1)->get()->first();
      $item1 = Publication::where('id', '<', $item->id)->whereHas('categories', function ($join) use ($archive) {
        $join->where('id', '=', $archive->id);
      })->get()->first();
      $item2 = Publication::where('id', '>', $item->id)->whereHas('categories', function ($join) use ($archive) {
        $join->where('id', '=', $archive->id);
      })->get()->first();

      return view('client.publication', compact('item', 'item1', 'item2', 'archive'));
    }


    public function protection(){
      $scholars = Scholar::orderBy('created_at', 'DESC')->get()->all();
      $scholarword = ScholarWord::get()->first();
      // dd('protection');
      return view('client.protection', compact('scholars', 'scholarword'));
    }


    public function journals(\Illuminate\Http\Request $request){
      // Doim hamma published maqolalarni yuboramiz — filtrlash JS tomonida (URL bilan sinxronlanadi)
      $articles = JournalArticle::with('author')
        ->where('status', JournalArticle::ST_PUBLISHED)
        ->orderByDesc('publish_date')->orderByDesc('id')
        ->get();

      // Sidebar — yillar (published bo'yicha)
      $yearsRaw = JournalArticle::where('status', JournalArticle::ST_PUBLISHED)
        ->selectRaw('YEAR(publish_date) as y, COUNT(*) as n')
        ->whereNotNull('publish_date')
        ->groupBy('y')
        ->orderByDesc('y')
        ->get();
      $years = $yearsRaw->map(fn ($r) => [
        'y'   => (string) $r->y,
        'n'   => (int) $r->n,
        'act' => (string) $r->y === (string) $request->input('year'),
      ])->all();

      // Sidebar — taglar (published bo'yicha eng ko'p)
      $tagCounts = [];
      JournalArticle::where('status', JournalArticle::ST_PUBLISHED)
        ->whereNotNull('tags')
        ->pluck('tags')->each(function ($tags) use (&$tagCounts) {
          if (!is_array($tags)) return;
          foreach ($tags as $t) {
            $tagCounts[$t] = ($tagCounts[$t] ?? 0) + 1;
          }
        });
      arsort($tagCounts);
      $tags = array_slice(array_keys($tagCounts), 0, 24);

      // Kategoriyalar (header nav uchun)
      $categories = \App\Http\Controllers\JournalSite\ModeratorController::CATEGORIES;
      $categoryCounts = JournalArticle::where('status', JournalArticle::ST_PUBLISHED)
        ->selectRaw('category, COUNT(*) as n')
        ->whereNotNull('category')
        ->groupBy('category')
        ->pluck('n', 'category');

      $totalCount   = $articles->count();
      $latestIssue  = $articles->first();

      return view('client.journal_site.index', compact(
        'articles', 'years', 'tags', 'categories', 'categoryCounts',
        'totalCount', 'latestIssue'
      ));
    }


    public function infographics(){
      $infographics = PhotoGallery::where('status', 'infographics')->orderBy('sort')->get()->all();

      return view('client.infographics', compact('infographics'));
    }


    public function infographicsItem($id){
      $infographics = PhotoGallery::findOrFail($id);
      
      return view('client.infographicsitem', compact('infographics'));
    }


    public function infographicsByHashtag($id){
      $hashtag = HashTag::findOrFail($id);
      $infographics = $hashtag->infographics;

      return view('client.infographicsbyshashtag', compact('hashtag', 'infographics'));
    }


    public function journal($id){
      // Faqat published statusidagi maqolaga ruxsat
      $article = JournalArticle::with('author')
        ->where('status', JournalArticle::ST_PUBLISHED)
        ->findOrFail($id);

      // Views increment
      $article->increment('views');

      // Oldingi/keyingi maqolalar (published bo'yicha, publish_date tartibida)
      $prev = JournalArticle::where('status', JournalArticle::ST_PUBLISHED)
        ->where('publish_date', '<=', $article->publish_date)
        ->where('id', '<>', $article->id)
        ->orderByDesc('publish_date')->orderByDesc('id')
        ->first();
      $next = JournalArticle::where('status', JournalArticle::ST_PUBLISHED)
        ->where('publish_date', '>=', $article->publish_date)
        ->where('id', '<>', $article->id)
        ->orderBy('publish_date')->orderBy('id')
        ->first();

      // Aloqador maqolalar (shu kategoriyadan, eng so'nggi 3 ta)
      $related = JournalArticle::with('author')
        ->where('status', JournalArticle::ST_PUBLISHED)
        ->where('id', '<>', $article->id)
        ->when($article->category, fn ($q) => $q->where('category', $article->category))
        ->orderByDesc('publish_date')
        ->limit(3)
        ->get();

      return view('client.journal_site.show', compact('article', 'prev', 'next', 'related'));
    }


    /**
     * Public list of journal issues (PDF nashrlar) — uploaded by moderator.
     */
    public function journalIssues()
    {
      $issues = Journal::orderBy('sort')->orderByDesc('id')->get();
      return view('client.journal_site.issues.index', compact('issues'));
    }


    /**
     * Journal archive (old client.journals view) — list of all Journal model items.
     */
    public function journalArchive()
    {
      $journals = Journal::orderBy('sort')->get()->all();
      return view('client.journals', compact('journals'));
    }


    /**
     * Journal archive item (old client.journal view) — single Journal item detail.
     */
    public function journalArchiveItem($id)
    {
      $item = Journal::findOrFail($id);
      $item->increment('views');
      $item = Journal::findOrFail($id);

      $item1 = Journal::where('id', '<', $item->id)->orderByDesc('id')->first();
      $item2 = Journal::where('id', '>', $item->id)->orderBy('id')->first();

      return view('client.journal', compact('item', 'item1', 'item2'));
    }


    /**
     * Public detail page for a journal issue — embedded PDF reader.
     */
    public function journalIssue($id)
    {
      $issue = Journal::findOrFail($id);
      $issue->increment('views');
      $issue = Journal::findOrFail($id);

      $prev = Journal::where('id', '<', $issue->id)->orderByDesc('id')->first();
      $next = Journal::where('id', '>', $issue->id)->orderBy('id')->first();

      return view('client.journal_site.issues.show', compact('issue', 'prev', 'next'));
    }


    public function contacts(){
      return view('client.contacts');
    }


    public function contactsPost(Request $request){
        if($request->isMethod('post')){
          $data = $request->all();
          $validator = Validator::make($request->all(), [
            'name'            =>  'required',
            'address'         =>  'required',
            'phone'           =>  'required',
            'email'           =>  'required',
            'content'         =>  'required',
          ]);
          if ($validator->fails()) {
              return redirect()
                          ->back()
                          ->withErrors($validator)
                          ->withInput();
          }

          Offer::create($request->all());

          return redirect('/contacts')->with(['success' => 'Ваше предложение успешно отправлено']);
        }
    }


    public function search(Request $request){
      $query = trim((string) $request->query('query', ''));

      if ($query === '') {
        $news = collect();
        $publications = collect();
        $laws = collect();
        return view('client.search', compact('news', 'publications', 'laws', 'query'));
      }

      $news = News::where('title_uz', 'LIKE', '%'.$query.'%')
              ->orWhere('title_ru', 'LIKE', '%'.$query.'%')
              ->orWhere('title_en', 'LIKE', '%'.$query.'%')
              ->orWhere('description_uz', 'LIKE', '%'.$query.'%')
              ->orWhere('description_ru', 'LIKE', '%'.$query.'%')
              ->orWhere('description_en', 'LIKE', '%'.$query.'%')
              ->get();

      $publications = Publication::where('title_uz', 'LIKE', '%'.$query.'%')
              ->orWhere('title_ru', 'LIKE', '%'.$query.'%')
              ->orWhere('title_en', 'LIKE', '%'.$query.'%')
              ->orWhere('description_uz', 'LIKE', '%'.$query.'%')
              ->orWhere('description_ru', 'LIKE', '%'.$query.'%')
              ->orWhere('description_en', 'LIKE', '%'.$query.'%')
              ->get();

      $laws = LawCategory::where('title_uz', 'LIKE', '%'.$query.'%')
              ->orWhere('title_ru', 'LIKE', '%'.$query.'%')
              ->orWhere('title_en', 'LIKE', '%'.$query.'%')
              ->get();


      return view('client.search', compact('news', 'publications', 'laws', 'query'));
    }


    public function autocomplete(Request $request){
      $query = $request->query('query', '');

      if (!is_string($query) || trim($query) === '') {
        return response()->json([]);
      }

      $like = '%' . $query . '%';

      $news_uz = News::select('title_uz')->where('title_uz', 'LIKE', $like)->get();
      $news_ru = News::select('title_ru')->where('title_ru', 'LIKE', $like)->get();
      $news_en = News::select('title_en')->where('title_en', 'LIKE', $like)->get();

      $publications_uz = Publication::select('title_uz')->where('title_uz', 'LIKE', $like)->get();
      $publications_ru = Publication::select('title_ru')->where('title_ru', 'LIKE', $like)->get();
      $publications_en = Publication::select('title_en')->where('title_en', 'LIKE', $like)->get();

      $laws_uz = LawCategory::select('title_uz')->where('title_uz', 'LIKE', $like)->get();
      $laws_ru = LawCategory::select('title_ru')->where('title_ru', 'LIKE', $like)->get();
      $laws_en = LawCategory::select('title_en')->where('title_en', 'LIKE', $like)->get();

      $dataModified = array();
      foreach ($news_uz as $datas)
      {
        $dataModified[] = $datas->title_uz;
      }
      foreach ($news_ru as $datas)
      {
        $dataModified[] = $datas->title_ru;
      }
      foreach ($news_en as $datas)
      {
        $dataModified[] = $datas->title_en;
      }
      foreach ($publications_uz as $datas)
      {
        $dataModified[] = $datas->title_uz;
      }
      foreach ($publications_ru as $datas)
      {
        $dataModified[] = $datas->title_ru;
      }
      foreach ($publications_en as $datas)
      {
        $dataModified[] = $datas->title_en;
      }
      foreach ($laws_uz as $datas)
      {
        $dataModified[] = $datas->title_uz;
      }
      foreach ($laws_ru as $datas)
      {
        $dataModified[] = $datas->title_ru;
      }
      foreach ($laws_en as $datas)
      {
        $dataModified[] = $datas->title_en;
      }

      return response()->json($dataModified);
    }


    public function localization(Request $request){
      $allowed = ['uz', 'ru', 'en'];
      $lang = $request->query('lang');
      $url  = $request->query('url', '/');

      if (is_string($lang) && in_array($lang, $allowed, true)) {
        session(['locale' => $lang]);
        \App::setLocale($lang);
      }

      // Faqat lokal URL'ga ruxsat — ochiq redirect oldini olish
      if (!is_string($url) || !preg_match('#^/[^/\\\\]#', $url)) {
        $url = '/';
      }

      return redirect($url);
    }
    public function history(){
      return view('client.history');
    }
}
