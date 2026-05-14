<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Client\IndexController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\LawController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PublicationController;
use App\Http\Controllers\Admin\ScolarController;
use App\Http\Controllers\Admin\AdministrationController;
use App\Http\Controllers\Admin\StructureController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\WeatherUSDController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\FilesController;
use App\Http\Controllers\JournalSite\AuthController as JournalAuthController;
use App\Http\Controllers\JournalSite\AdminController as JournalAdminController;
use App\Http\Controllers\JournalSite\CabinetController as JournalCabinetController;
use App\Http\Controllers\JournalSite\TechnicController as JournalTechnicController;
use App\Http\Controllers\JournalSite\ModeratorController as JournalModeratorController;
use App\Http\Controllers\JournalSite\ReviewerController as JournalReviewerController;

Route::middleware(['set_locale', 'lang_define'])->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/archives/{slug}', [IndexController::class, 'archives'])->name('archives');
    Route::get('/archives/{slug}/{slug1}', [IndexController::class, 'news'])->name('news');
    Route::get('/p/history', [IndexController::class, 'history'])->name('history');
    Route::get('/pages/{slug}', [IndexController::class, 'pages'])->name('pages');
    Route::get('/page/{slug}', [IndexController::class, 'page'])->name('page');
    Route::get('/administrations', [IndexController::class, 'administrations'])->name('administrations');
    Route::get('/employees', [IndexController::class, 'employees'])->name('employees');
    Route::get('/structure', [IndexController::class, 'structure'])->name('structure');
    Route::get('/laws/{slug}', [IndexController::class, 'laws'])->name('laws');
    Route::get('/press', [IndexController::class, 'press'])->name('press');
    Route::get('/science', [IndexController::class, 'science'])->name('science');
    Route::get('/photos', [IndexController::class, 'photos'])->name('photos');
    Route::get('/videos', [IndexController::class, 'videos'])->name('videos');
    Route::get('/publications', [IndexController::class, 'publicationsAll'])->name('publications.all');
    Route::get('/publications/{slug}', [IndexController::class, 'publications'])->name('publications');
    Route::get('/publications/{slug}/{slug1}', [IndexController::class, 'publicationItem'])->name('publicationItem');
    Route::get('/declaration-of-protection', [IndexController::class, 'protection'])->name('protection');
    Route::get('/journals', [IndexController::class, 'journals'])->name('journals');
    Route::get('/journal-archive', [IndexController::class, 'journalArchive'])->name('journals.archive');
    Route::get('/journal-archive/{id}', [IndexController::class, 'journalArchiveItem'])->whereNumber('id')->name('journal.archive');
    Route::get('/journal-issues', [IndexController::class, 'journalIssues'])->name('journal.issues');
    Route::get('/journal-issues/{id}', [IndexController::class, 'journalIssue'])->whereNumber('id')->name('journal.issue');
    Route::get('/infographics', [IndexController::class, 'infographics'])->name('infographics');
    Route::get('/infographics/{id}', [IndexController::class, 'infographicsItem'])->name('infographics.item');
    Route::get('/infographics/hashtag/{id}', [IndexController::class, 'infographicsByHashtag'])->name('infographics.by.hashtag');
    Route::get('/journals/{id}', [IndexController::class, 'journal'])->whereNumber('id')->name('journal');
    Route::get('/contacts', [IndexController::class, 'contacts'])->name('contacts');
    Route::post('/post/contacts', [IndexController::class, 'contactsPost'])->name('contacts.post');
    Route::get('/search', [IndexController::class, 'search'])->name('search');
    Route::get('/changelocale/{locale}', [IndexController::class, 'changeLocale'])->name('changelocale');
    Route::get('/autocomplete', [IndexController::class, 'autocomplete'])->name('autocomplete');
    Route::get('/localization', [IndexController::class, 'localization'])->name('localization');

    /* ───── JOURNAL SITE — Auth ─────────────────────────────────────── */
    Route::prefix('journals')->name('journal.')->group(function () {

        // Guest only (login bo'lganlarni kabinetga yo'naltiramiz)
        Route::middleware('journal.guest')->group(function () {
            Route::get('/login',  [JournalAuthController::class, 'showLogin'])->name('auth.login');
            Route::post('/login', [JournalAuthController::class, 'login'])->name('auth.login.post');

            Route::get('/register',  [JournalAuthController::class, 'showRegister'])->name('auth.register');
            Route::post('/register', [JournalAuthController::class, 'register'])->name('auth.register.post');
        });

        // Auth required
        Route::middleware('journal.auth')->group(function () {
            Route::post('/logout', [JournalAuthController::class, 'logout'])->name('auth.logout');

            // ── Cabinet (User uchun) ──
            Route::get('/cabinet',                       [JournalCabinetController::class, 'dashboard'])->name('cabinet');
            Route::get('/cabinet/articles',              [JournalCabinetController::class, 'articles'])->name('cabinet.articles');
            Route::get('/cabinet/submit',                [JournalCabinetController::class, 'showSubmit'])->name('cabinet.submit');
            Route::post('/cabinet/submit',               [JournalCabinetController::class, 'submit'])->name('cabinet.submit.post');
            Route::get('/cabinet/articles/{id}',         [JournalCabinetController::class, 'articleDetail'])->whereNumber('id')->name('cabinet.article');
            Route::get('/cabinet/articles/{id}/download',[JournalCabinetController::class, 'downloadFile'])->whereNumber('id')->name('cabinet.article.download');
            Route::get('/cabinet/articles/{id}/resubmit',[JournalCabinetController::class, 'showResubmit'])->whereNumber('id')->name('cabinet.article.resubmit');
            Route::post('/cabinet/articles/{id}/resubmit',[JournalCabinetController::class, 'resubmit'])->whereNumber('id')->name('cabinet.article.resubmit.post');
        });

        // ── Texnik paneli ──
        Route::middleware('journal.auth:technic')->prefix('technic')->name('technic.')->group(function () {
            Route::get('/',                            [JournalTechnicController::class, 'dashboard'])->name('dashboard');
            Route::get('/inbox',                       [JournalTechnicController::class, 'inbox'])->name('inbox');
            Route::get('/publish-queue',               [JournalTechnicController::class, 'publishQueue'])->name('publish_queue');
            Route::get('/all',                         [JournalTechnicController::class, 'all'])->name('all');
            Route::get('/articles/{id}',               [JournalTechnicController::class, 'article'])->whereNumber('id')->name('article');
            Route::get('/articles/{id}/download',      [JournalTechnicController::class, 'downloadFile'])->whereNumber('id')->name('article.download');
            Route::post('/articles/{id}/approve',      [JournalTechnicController::class, 'approve'])->whereNumber('id')->name('article.approve');
            Route::post('/articles/{id}/reject',       [JournalTechnicController::class, 'reject'])->whereNumber('id')->name('article.reject');
            Route::post('/articles/{id}/revision',     [JournalTechnicController::class, 'requestRevision'])->whereNumber('id')->name('article.revision');
            Route::post('/articles/{id}/publish',      [JournalTechnicController::class, 'publish'])->whereNumber('id')->name('article.publish');
        });

        // ── Taqrizchi paneli ──
        Route::middleware('journal.auth:reviewer')->prefix('reviewer')->name('reviewer.')->group(function () {
            Route::get('/',                            [JournalReviewerController::class, 'dashboard'])->name('dashboard');
            Route::get('/inbox',                       [JournalReviewerController::class, 'inbox'])->name('inbox');
            Route::get('/completed',                   [JournalReviewerController::class, 'completed'])->name('completed');
            Route::get('/all',                         [JournalReviewerController::class, 'all'])->name('all');
            Route::get('/articles/{id}',               [JournalReviewerController::class, 'article'])->whereNumber('id')->name('article');
            Route::get('/articles/{id}/download',      [JournalReviewerController::class, 'downloadFile'])->whereNumber('id')->name('article.download');
            Route::post('/articles/{id}/submit',       [JournalReviewerController::class, 'submit'])->whereNumber('id')->name('article.submit');
        });

        // ── Moderator paneli ──
        Route::middleware('journal.auth:moderator')->prefix('moderator')->name('moderator.')->group(function () {
            Route::get('/',                            [JournalModeratorController::class, 'dashboard'])->name('dashboard');
            Route::get('/inbox',                       [JournalModeratorController::class, 'inbox'])->name('inbox');
            Route::get('/in-review',                   [JournalModeratorController::class, 'inReview'])->name('in_review');
            Route::get('/final-queue',                 [JournalModeratorController::class, 'finalQueue'])->name('final_queue');
            Route::get('/all',                         [JournalModeratorController::class, 'all'])->name('all');
            Route::get('/articles/{id}',               [JournalModeratorController::class, 'article'])->whereNumber('id')->name('article');
            Route::get('/articles/{id}/download',      [JournalModeratorController::class, 'downloadFile'])->whereNumber('id')->name('article.download');
            Route::post('/articles/{id}/assign',       [JournalModeratorController::class, 'assignReviewers'])->whereNumber('id')->name('article.assign');
            Route::post('/articles/{id}/reassign',     [JournalModeratorController::class, 'reassignReviewers'])->whereNumber('id')->name('article.reassign');
            Route::post('/articles/{id}/final-approve',[JournalModeratorController::class, 'finalApprove'])->whereNumber('id')->name('article.final_approve');
            Route::post('/articles/{id}/final-reject', [JournalModeratorController::class, 'finalReject'])->whereNumber('id')->name('article.final_reject');

            // ── Jurnal sonlari (PDF nashrlar) ──
            Route::get('/issues',                       [JournalModeratorController::class, 'issuesIndex'])->name('issues.index');
            Route::post('/issues',                      [JournalModeratorController::class, 'issuesStore'])->name('issues.store');
            Route::delete('/issues/{id}',               [JournalModeratorController::class, 'issuesDestroy'])->whereNumber('id')->name('issues.destroy');
        });

        // SuperAdmin only — userlar va rollarni boshqarish
        Route::middleware('journal.auth:superadmin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/users',                [JournalAdminController::class, 'users'])->name('users');
            Route::patch('/users/{user}/role',  [JournalAdminController::class, 'updateRole'])->name('users.role');
        });
    });
});

Auth::routes([
    'register' => false,
    'reset'    => false,
    'verify'   => false,
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/milliy-qadriyatlar', function () {
    return response()->download(public_path('files/news/ru/26.12.2023 12.14.pdf'));
});

Route::get('/calculator-new', function () {
    return response()->download(public_path('files/calculator/calculator_new.xlsx'));
});

Route::get('/ipoteka', function () {
    return response()->download(public_path('ckfinder/userfiles/files/link/Ipoteka.pdf'));
});

Route::match(['get', 'post'], '/admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::middleware(['checkstatus'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Menu
    Route::get('/menus', [MenuController::class, 'index']);
    Route::match(['get', 'post'], '/menus/create', [MenuController::class, 'create']);
    Route::match(['get', 'post'], '/menus/edit/{id}', [MenuController::class, 'edit']);
    Route::get('/menus/delete/{id}', [MenuController::class, 'delete']);

    // News with Categories
    Route::get('/archives', [NewsController::class, 'indexArchive']);
    Route::match(['get', 'post'], '/archives/create', [NewsController::class, 'createArchive']);
    Route::match(['get', 'post'], '/archives/edit/{id}', [NewsController::class, 'editArchive']);
    Route::get('/archives/delete/{id}', [NewsController::class, 'deleteArchive']);

    Route::get('/news', [NewsController::class, 'index']);
    Route::match(['get', 'post'], '/news/create', [NewsController::class, 'create']);
    Route::match(['get', 'post'], '/news/edit/{id}', [NewsController::class, 'edit']);
    Route::get('/news/delete/{id}', [NewsController::class, 'delete']);

    // Laws
    Route::get('/laws-categories', [LawController::class, 'indexCategory']);
    Route::match(['get', 'post'], '/laws-categories/create', [LawController::class, 'createCategory']);
    Route::match(['get', 'post'], '/laws-categories/edit/{id}', [LawController::class, 'editCategory']);
    Route::get('/laws-categories/delete/{id}', [LawController::class, 'deleteCategory']);

    Route::get('/laws', [LawController::class, 'index']);
    Route::match(['get', 'post'], '/laws/create', [LawController::class, 'create']);
    Route::match(['get', 'post'], '/laws/edit/{id}', [LawController::class, 'edit']);
    Route::get('/laws/delete/{id}', [LawController::class, 'delete']);

    // Gallery
    Route::get('/photo-gallery', [GalleryController::class, 'indexPhoto']);
    Route::match(['get', 'post'], '/photo-gallery/create', [GalleryController::class, 'createPhoto']);
    Route::match(['get', 'post'], '/photo-gallery/edit/{id}', [GalleryController::class, 'editPhoto']);
    Route::get('/photo-gallery/delete/{id}', [GalleryController::class, 'deletePhoto']);

    Route::get('/infographics', [GalleryController::class, 'indexInfographics']);
    Route::match(['get', 'post'], '/infographics/create', [GalleryController::class, 'createInfographics']);
    Route::match(['get', 'post'], '/infographics/edit/{id}', [GalleryController::class, 'editInfographics']);
    Route::get('/infographics/delete/{id}', [GalleryController::class, 'deleteInfographics']);

    Route::get('/video-gallery', [GalleryController::class, 'indexVideo']);
    Route::match(['get', 'post'], '/video-gallery/create', [GalleryController::class, 'createVideo']);
    Route::get('/video-gallery/delete/{id}', [GalleryController::class, 'deleteVideo']);

    // Publication with Categories
    Route::get('/publications/categories', [PublicationController::class, 'indexCategories']);
    Route::match(['get', 'post'], '/publications/categories/create', [PublicationController::class, 'createCategories']);
    Route::match(['get', 'post'], '/publications/categories/edit/{id}', [PublicationController::class, 'editCategories']);
    Route::get('/publications/categories/delete/{id}', [PublicationController::class, 'deleteCategories']);

    Route::get('/publications', [PublicationController::class, 'index']);
    Route::match(['get', 'post'], '/publications/create', [PublicationController::class, 'create']);
    Route::match(['get', 'post'], '/publications/edit/{id}', [PublicationController::class, 'edit']);
    Route::get('/publications/delete/{id}', [PublicationController::class, 'delete']);

    // Scholars
    Route::get('/scolarwords', [ScolarController::class, 'indexWord']);
    Route::match(['get', 'post'], '/scolarwords/create', [ScolarController::class, 'createWord']);
    Route::get('/scolarwords/delete/{id}', [ScolarController::class, 'deleteWord']);

    Route::get('/scolars', [ScolarController::class, 'index']);
    Route::match(['get', 'post'], '/scolars/create', [ScolarController::class, 'create']);
    Route::match(['get', 'post'], '/scolars/edit/{id}', [ScolarController::class, 'edit']);
    Route::get('/scolars/delete/{id}', [ScolarController::class, 'delete']);

    // Administrations
    Route::get('/administrations', [AdministrationController::class, 'index']);
    Route::match(['get', 'post'], '/administrations/create', [AdministrationController::class, 'create']);
    Route::match(['get', 'post'], '/administrations/edit/{id}', [AdministrationController::class, 'edit']);
    Route::get('/administrations/delete/{id}', [AdministrationController::class, 'delete']);

    Route::get('/employees', [\App\Http\Controllers\Admin\EmployeeController::class, 'index']);
    Route::match(['get', 'post'], '/employees/create', [\App\Http\Controllers\Admin\EmployeeController::class, 'create']);
    Route::match(['get', 'post'], '/employees/edit/{id}', [\App\Http\Controllers\Admin\EmployeeController::class, 'edit']);
    Route::get('/employees/delete/{id}', [\App\Http\Controllers\Admin\EmployeeController::class, 'delete']);

    // Structure
    Route::get('/structure', [StructureController::class, 'index']);
    Route::match(['get', 'post'], '/structure/create', [StructureController::class, 'create']);
    Route::match(['get', 'post'], '/structure/edit/{id}', [StructureController::class, 'edit']);
    Route::get('/structure/delete/{id}', [StructureController::class, 'delete']);

    // Journals
    Route::get('/journals', [JournalController::class, 'index']);
    Route::match(['get', 'post'], '/journals/create', [JournalController::class, 'create']);
    Route::match(['get', 'post'], '/journals/edit/{id}', [JournalController::class, 'edit']);
    Route::get('/journals/delete/{id}', [JournalController::class, 'delete']);

    // Pages
    Route::get('/pages-categories', [PagesController::class, 'indexCategory']);
    Route::match(['get', 'post'], '/pages-categories/create', [PagesController::class, 'createCategory']);
    Route::match(['get', 'post'], '/pages-categories/edit/{id}', [PagesController::class, 'editCategory']);
    Route::get('/pages-categories/delete/{id}', [PagesController::class, 'deleteCategory']);

    Route::get('/pages', [PagesController::class, 'index']);
    Route::match(['get', 'post'], '/pages/create', [PagesController::class, 'create']);
    Route::match(['get', 'post'], '/pages/edit/{id}', [PagesController::class, 'edit']);
    Route::get('/pages/delete/{id}', [PagesController::class, 'delete']);

    // Weather
    Route::get('/weather', [WeatherUSDController::class, 'indexWeather']);
    Route::match(['get', 'post'], '/weather/create', [WeatherUSDController::class, 'createWeather']);
    Route::match(['get', 'post'], '/weather/edit/{id}', [WeatherUSDController::class, 'editWeather']);
    Route::get('/weather/delete/{id}', [WeatherUSDController::class, 'deleteWeather']);

    // Weather and USD
    Route::get('/weathers', [WeatherUSDController::class, 'index']);
    Route::match(['get', 'post'], '/weathers/create', [WeatherUSDController::class, 'create']);
    Route::match(['get', 'post'], '/weathers/edit/{id}', [WeatherUSDController::class, 'edit']);
    Route::get('/weathers/delete/{id}', [WeatherUSDController::class, 'delete']);

    // Sliders
    Route::get('/sliders', [SliderController::class, 'index']);
    Route::match(['get', 'post'], '/sliders/create', [SliderController::class, 'create']);
    Route::match(['get', 'post'], '/sliders/edit/{id}', [SliderController::class, 'edit']);
    Route::get('/sliders/delete/{id}', [SliderController::class, 'delete']);

    // Offers
    Route::get('/offers', [OfferController::class, 'index']);
    Route::get('/offers/{id}', [OfferController::class, 'item']);

    // Files
    Route::get('delete/files/{type}/{id}/{id1}', [FilesController::class, 'delete'])->name('file.delete');
});
