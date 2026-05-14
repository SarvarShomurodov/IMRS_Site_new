@extends('client.layouts.app')

@section('metadata')
  <title> @lang('index.index')</title>
  <meta name="description" content="@lang('index.index_des')">
  <meta name="keywords" content="">
  <meta property="og:title" content="| @lang('index.index')">
  <meta property="og:description" content="@lang('index.index_des')">
@endsection

@section('css')

  <link rel="stylesheet" href="/owlcarousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="/owlcarousel/owl.carousel.min.css">
  <link rel="stylesheet" href="/owlcarousel/animate.css">

  <link rel="stylesheet" href="/carousel/slick.css">
	<link rel="stylesheet" href="/carousel/carousels.css">
	<link rel="stylesheet" href="/carousel/style.css">

  <!-- <link href="/imageview/baguette.css" type="text/css" rel="stylesheet"> -->
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
  <!-- <script src="/imageview/baguette.js"></script>

  <script>
    jQuery(function($){
    baguetteBox.run('.gallery',{
    animation: 'fadeIn',
    });
    });
  </script> -->

@endsection

@section('content')



  <div id="featured-slider">
    <!-- @foreach($sliders as $slider)
      <div class="cycle-slideshow" id="main-slider" data-cycle-fx="fade" data-cycle-speed="1000" data-cycle-pause-on-hover="true" data-cycle-loader="true" data-cycle-log="false" data-cycle-swipe="true" data-cycle-auto-height="container" data-cycle-pager-template="&lt;span class=&quot;pager-box&quot;&gt;1111&lt;/span&gt;" data-cycle-timeout="3000" data-cycle-slides="article">
        <div class="cycle-pager"></div>
        <div class="owl-carousel header-img-slide owl-theme">
          <div  class="headimg"> <img src="{{$slider->getImageAttribute()}}" alt=""> </div>
        </div>
      </div>
    @endforeach -->
  </div>

  <div id="front-page-home-sections" class="widget-area">
    <div id="university-hub-news-and-events" class="home-section-news-and-events">
      <div class="container">
        <div class="inner-wrapper" style="width: 100%;display: flex; justify-content: space-around;; flex-wrap: wrap; background: #f7fcfe;">

          <div class="recent-news news-head-block">
            <!-- <a href="{{route('archives', 'news')}}"><h2>@lang('index.news')</h2></a> -->
            <a href="{{route('archives', 'news')}}"><h1 class="header-title">@lang('index.news')</h1></a>
            <div class="inner-wrapper">
              @foreach($news as $item)
                <div class="news-post" style="margin-bottom: 10px; box-shadow: 0 2px 3px #ddd;">
                  <a href="{{route('news', [$item->categories()->first()->slug, $item->slug])}}">
                    <img src="{{$item->getImageAttribute()}}" class="aligncenter wp-post-image" alt="">
                  </a>
                  <div class="news-content">
                    <h3>
                      <a href="{{route('news', [$item->categories()->first()->slug, $item->slug])}}">{{$item->getShortTitleAttribute()}}</a>
                    </h3>
                    <div class="block-meta">
                      <span class="posted-on">
                        <a href="{{route('news', [$item->categories()->first()->slug, $item->slug])}}">{{date_format($item->created_at, 'Y-m-d')}}</a>
                      </span>
                      <span class="for-reviews-view"></span>
                      <span>
                        @if($item->views)
                          {{$item->views}}
                        @else
                          0
                        @endif
                      </span>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div id="latest-news" class="home-section-latest-news publications-head-block">
            <div class="ss">
              <!-- <a href="{{route('publications.all')}}"><h2>@lang('index.publications')</h2></a> -->
              <a href="{{route('publications', $article->slug)}}"><h1 class="header-title">{{$article->getTitleAttribute()}}</h1></a>
              <div class="inner-wrapper latest-news-wrapper latest-news-col-1 latest-news-layout-1 " >
                @foreach($publications as $item)
                  <div class="latest-news-item">
                    <div class="latest-news-inner-wrapper latest-publications">
                      @if($item->image_uz)
                        <div class="latest-news-thumb">
                          <a href="{{route('publicationItem', [$item->categories()->first()->slug, $item->slug])}}">
                            <img  src="{{$item->getImageAttribute()}}" class="aligncenter wp-post-image" alt="" >
                          </a>
                          <!-- <div class="read-more-button">
                            <a class="more" href="{{route('publicationItem', [$item->categories()->first()->slug, $item->slug])}}">Learn More</a>
                          </div> -->
                        </div>
                      @endif
                      <div class="latest-news-text-wrap">
                        <h3 class="latest-news-title">
                          <a href="{{route('publicationItem', [$item->categories()->first()->slug, $item->slug])}}">{{$item->getShortTitleAttribute()}}</a>
                        </h3>
                        <div class="latest-news-meta">
                          <span class="posted-on">
                            <a href="{{route('publicationItem', [$item->categories()->first()->slug, $item->slug])}}">{{date_format($item->created_at, 'Y-m-d')}}</a>
                          </span>
                          <span class="for-reviews-view"></span>
                          <span>
                                @if($item->views)
                                  {{$item->views}}
                                @else
                                  0
                                @endif
                          </span>
                          <!-- <span class="cat-links">
                            <a href="{{route('publications', $item->categories()->first()->slug)}}">
                              @if($item->categories()->exists())

                                {{$item->categories()->first()->getTitleAttribute()}}
                              @endif
                            </a>
                          </span> -->
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

{{--          <div class="recent-events reviews-head-block">--}}
{{--            <!-- <a href="{{route('archives', 'reviews')}}"><h2>@lang('index.reviews')</h2></a> -->--}}
{{--            <a href="{{route('archives', 'central-asian-news')}}"><h1 class="header-title header-title-news_ca">@lang('index.news_ca')</h1></a>--}}
{{--            <div class="reviews-head-block-flex">--}}
{{--              @foreach($news_ca as $item)--}}
{{--                <div class="event-post">--}}
{{--                  <!-- <div class="custom-entry-date">--}}
{{--                    <span class="entry-month">{{$item->getMonthData()}}</span>--}}
{{--                    <span class="entry-day">{{$item->getDayData()}}</span>--}}
{{--                  </div> -->--}}
{{--                  <a href="{{route('news', [$item->categories()->first()->slug, $item->slug])}}">--}}
{{--                    <img class="aligncenter wp-image-4842 " src="{{$item->getImageAttribute()}}" width="200">--}}
{{--                  </a>--}}
{{--                  <div>--}}
{{--                    <h3 style="padding: 0 10px; font-size: 12px !important">--}}
{{--                      <a href="{{route('news', [$item->categories()->first()->slug, $item->slug])}}">{{$item->getShortTitleAttribute()}}</a>--}}
{{--                    </h3>--}}
{{--                    <span class="for-reviews"> &nbsp;{{date_format($item->created_at, 'Y-m-d')}}</span>--}}
{{--                    <span>--}}
{{--                      <span class="for-reviews-view"></span>--}}
{{--                      @if($item->views)--}}
{{--                        {{$item->views}}--}}
{{--                      @else--}}
{{--                        0--}}
{{--                      @endif--}}
{{--                    </span>--}}
{{--                  </div>--}}
{{--                  
{{--                </div>--}}
{{--              @endforeach--}}
{{--            </div>--}}
{{--          </div>--}}

          <!-- <article id="post-our" class="post-4221 page type-page status-publish hentry journals-head-block" >
            <div class="dd">
              <a href="{{route('journals')}}"><h2>@lang('index.journals')</h2></a>
            </div>
            <div class="entry-content-wrapper">
              <div class="entry-content">
                <div data-elementor-type="wp-page" data-elementor-id="4221" class="elementor elementor-4221" data-elementor-settings="[]">
                  <div class="elementor-inner">
                    <div class="elementor-section-wrap">

                      <section class="elementor-element elementor-element-d2d5d0a elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="d2d5d0a" data-element_type="section">
                        <div class="elementor-container elementor-column-gap-default">
                          <div class="elementor-row" style=" display: flex; flex-wrap:wrap">

                            @foreach($journals as $journal)
                              <div class="elementor-element elementor-element-7835b5b elementor-column elementor-col-25 elementor-top-column" data-id="7835b5b" data-element_type="column" style="width: 100%;">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-62b6fb9 elementor-widget elementor-widget-text-editor" data-id="62b6fb9" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <a href="{{route('journal', $journal->id)}}">
                                              <img class="aligncenter wp-image-4842 size-medium" src="/images/journals/{{$journal->image}}" >
                                            </a>
                                          </p>
                                          <h6 style="text-align: center;">
                                            <a href="{{route('journal', $journal->id)}}">
                                              <strong>{{$journal->getTimeAttribute()}}</strong>
                                            </a>
                                          </h6>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="elementor-element elementor-element-5f224d4 elementor-widget elementor-widget-text-editor" data-id="5f224d4" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </section>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <footer class="entry-footer"></footer>
          </article> -->

          <!-- <div id="sidebar-primary" class="widget-area sidebar advertising-head-block" role="complementary">
            <aside id="media_image-2" class="widget widget_media_image">
              <a href="https://it-park.uz">
                <img width="500" height="1000" src="/images/noupload/site/itpark.jpg" class="image wp-image-3172  attachment-full size-full" alt="it-park" style="max-width: 100%; height: auto;" >
              </a>
            </aside>
          </div> -->
        </div>
      </div>
    </div>
  </div>


  <div class="container container-econom" style="display: flex; justify-content: center;">
    <!-- <div id="latest-news-econom" class="home-section-latest-news econom-head-block">
      <div class="ss">
        <a href="/publications/reviews-by-industry-sector"><h1 class="header-title header-title-econom">{{$category->title}}</h1></a>
        <div class="inner-wrapper latest-news-wrapper latest-news-col-1 latest-news-layout-1 " >
          @foreach($econom as $item)
            <div class="latest-news-item">
              <div class="latest-news-inner-wrapper latest-publications">
                <div class="latest-news-text-wrap">
                  <h3 class="latest-news-title">
                    <a href="{{route('publicationItem', [$item->categories()->first()->slug, $item->slug])}}">{{$item->getTitleAttribute()}}</a>
                  </h3>
                  <div class="latest-news-meta">
                    <span class="posted-on">
                      <a href="{{route('publicationItem', [$item->categories()->first()->slug, $item->slug])}}">{{date_format($item->created_at, 'Y-m-d')}}</a>
                    </span>
                    <span class="for-reviews-view"></span>
                    <span>
                          @if($item->views)
                            {{$item->views}}
                          @else
                            0
                          @endif
                    </span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div> -->
    <article class="post-4221 page type-page status-publish hentry infographics-head-block" >
        <!-- <div class="dd">
          <a href="{{route('journals')}}"><h2>@lang('index.journals')</h2></a>
        </div> -->
        <a href="{{route('journals')}}"><h1 class="header-title width-30">@lang('index.journals')</h1></a>
        <div class="entry-content-wrapper">
          <div class="entry-content">
            <div data-elementor-type="wp-page" data-elementor-id="4221" class="elementor elementor-4221" data-elementor-settings="[]">
              <div class="elementor-inner">
                <div class="elementor-section-wrap">

                  <section class="elementor-element elementor-element-d2d5d0a elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="d2d5d0a" data-element_type="section">
                    <div class="elementor-container elementor-column-gap-default">
                      <div class="elementor-row gallery itemsinfogrf infographicscolumnrow" style="display: flex; flex-wrap:wrap; background: #F7FCFE;">
                        @foreach($journals as $journal)
                          <div class="elementor-element elementor-element-7835b5b elementor-column elementor-top-column infographicscolumn  card" data-element_type="column">
                            <div class="elementor-column-wrap  elementor-element-populated">
                              <div class="elementor-widget-wrap element-inforgaphics">
                                <div class="elementor-element elementor-element-62b6fb9 elementor-widget elementor-widget-text-editor"  data-element_type="widget" data-widget_type="text-editor.default">
                                  <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                      <p>
                                        <a href="{{route('journal', $journal->id)}}">
                                          <img class="aligncenter wp-image-4842 size-medium" src="/images/journals/{{$journal->image}}" width="200">
                                        </a>
                                      </p>
                                      <h6 style="text-align: center;">
                                          <a href="{{route('journal', $journal->id)}}">
                                            <strong>{{$journal->getTimeAttribute()}}</strong>
                                          </a>
                                      </h6>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </section>

                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="entry-footer"></footer>
      </article>
    @if(count($infographics)>0)
      <article class="post-4221 page type-page status-publish hentry infographics-head-block" >
        <a href="{{route('infographics')}}"><h1 class="header-title width-30">@lang('index.infographics')</h1></a>
        <div class="entry-content-wrapper">
          <div class="entry-content">
            <div data-elementor-type="wp-page" data-elementor-id="4221" class="elementor elementor-4221" data-elementor-settings="[]">
              <div class="elementor-inner">
                <div class="elementor-section-wrap">

                  <section class="elementor-element elementor-element-d2d5d0a elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="d2d5d0a" data-element_type="section">
                    <div class="elementor-container elementor-column-gap-default">
                      <div class="elementor-row gallery itemsinfogrf infographicscolumnrow" style="display: flex; flex-wrap:wrap; background: #F7FCFE;">
                        @foreach($infographics as $infographic)
                          <div class="elementor-element elementor-element-7835b5b elementor-column elementor-top-column infographicscolumn  card" data-element_type="column">
                            <div class="elementor-column-wrap  elementor-element-populated">
                              <div class="elementor-widget-wrap element-inforgaphics">
                                <div class="elementor-element elementor-element-62b6fb9 elementor-widget elementor-widget-text-editor"  data-element_type="widget" data-widget_type="text-editor.default">
                                  <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                      <p>
                                        <a href="/images/galleries/{{$infographic->image}}">
                                          <img class="aligncenter wp-image-4842 size-medium" src="/images/galleries/{{$infographic->image}}" width="300">
                                        </a>
                                      </p>
                                      <h6 style="text-align: center;">
                                          <strong>{{$infographic->getTitleAttribute()}}</strong>
                                      </h6>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </section>

                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="entry-footer"></footer>
      </article>
    @endif
  </div>


<!-- 
  <div class="widget-area">
    <div class="home-section-news-and-events">
      <div class="container">
        <div class="inner-wrapper">
          <article class="post-4221 page type-page status-publish hentry journals-head-block" >
            <div class="entry-content-wrapper">
            <a href="{{route('journals')}}"><h1 class="header-title width-30">@lang('index.journals')</h1></a>
              <div class="entry-content">
                <div data-elementor-type="wp-page" data-elementor-id="4221" class="elementor elementor-4221" data-elementor-settings="[]">
                  <div class="elementor-inner">
                    <div class="elementor-section-wrap">

                      <section class="elementor-element elementor-element-d2d5d0a elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="d2d5d0a" data-element_type="section">
                        <div class="elementor-container elementor-column-gap-default">
                          <div class="elementor-row items journals-items" style="display: flex; flex-wrap:wrap; background: #F7FCFE; padding: 50px 0 50px 0">
                            @foreach($journals as $journal)
                              <div class="elementor-element elementor-element-7835b5b elementor-column elementor-col-25 elementor-top-column card" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-62b6fb9 elementor-widget elementor-widget-text-editor"  data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <a href="{{route('journal', $journal->id)}}">
                                              <img class="aligncenter wp-image-4842 size-medium" src="/images/journals/{{$journal->image}}" width="200">
                                            </a>
                                          </p>
                                          <h6 style="text-align: center;">
                                            <a href="{{route('journal', $journal->id)}}">
                                              <strong>{{$journal->getTimeAttribute()}}</strong>
                                            </a>
                                          </h6>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </section>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <footer class="entry-footer"></footer>
          </article>
        </div>
      </div>
    </div>
  </div> -->



  <div id="content" class="site-content">
    <div class="container">
      <div class="inner-wrapper">
        <div id="primary" class="content-area">
          <main id="main" class="site-main" role="main">
            <article id="post-2" class="post-2 page type-page status-publish has-post-thumbnail hentry">
              <header class="entry-header"></header>
              <div class="entry-content-wrapper">
                <div class="entry-content">
                  <div data-elementor-type="wp-page" data-elementor-id="2" class="elementor elementor-2" data-elementor-settings="[]">
                    <div class="elementor-inner">
                      <div class="elementor-section-wrap">
                        <section class="elementor-element elementor-element-4d8a2afe elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="4d8a2afe" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                          <div class="elementor-container elementor-column-gap-no">
                            <div class="elementor-row">
                              <div class="elementor-element elementor-element-b2a53b7 elementor-column elementor-col-100 elementor-top-column" data-id="b2a53b7" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-2459231d elementor-widget elementor-widget-heading" data-id="2459231d" data-element_type="widget" data-widget_type="heading.default">
                                      <div class="elementor-widget-container">
                                        <h4 class="elementor-heading-title elementor-size-default">@lang('index.our_partners')</h4>
                                      </div>
                                    </div>
                                    <div class="elementor-element elementor-element-64c352e5 elementor-widget elementor-widget-heading" data-id="64c352e5" data-element_type="widget" data-widget_type="heading.default">
                                      <div class="elementor-widget-container">
                                        <h3 class="elementor-heading-title elementor-size-default">@lang('index.international_organizations')</h3>
                                      </div>
                                    </div>
                                    <section class="elementor-element elementor-element-7944ee6 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-inner-section" data-id="7944ee6" data-element_type="section">
                                      <div class="elementor-container elementor-column-gap-no">
                                        <div class="elementor-row partners-items partners-now items">

                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/undp.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/koika.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/undesa.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/jica.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/adb.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/ebrd.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/giz.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/isdb.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/jetro.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/jica.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/kotra.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/mot.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/nagoya.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/oon.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/tika.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/twb.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/undesa.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/undp.png" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="elementor-element elementor-element-95fb1b8 elementor-column elementor-col-25 elementor-inner-column card" data-id="95fb1b8" data-element_type="column">
                                            <div class="elementor-column-wrap  elementor-element-populated">
                                              <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-79f7e3a4 elementor-widget elementor-widget-image" data-id="79f7e3a4" data-element_type="widget" data-widget_type="image.default">
                                                  <div class="elementor-widget-container">
                                                    <div class="elementor-image partner-logo">
                                                      <img width="895" height="443" src="/images/noupload/partners/unicef.jpg" class="attachment-large size-large" alt="" >
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </section>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>


                        <!-- <section class="elementor-element elementor-element-05d21f5 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="05d21f5" data-element_type="section">
                          <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-row">
                              <div class="elementor-element elementor-element-7bb2533 elementor-column elementor-col-100 elementor-top-column" data-id="7bb2533" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-431a5c7 elementor-widget elementor-widget-heading" data-id="431a5c7" data-element_type="widget" data-widget_type="heading.default">
                                      <div class="elementor-widget-container">
                                        <h2 class="elementor-heading-title elementor-size-default">@lang('index.useful_link')</h2>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>

                        <section class="elementor-element elementor-element-04c7be3 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="04c7be3" data-element_type="section">
                          <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-row">

                              <div class="elementor-element elementor-element-de442d8 elementor-column elementor-col-25 elementor-top-column" data-id="de442d8" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-af93e90 elementor-widget elementor-widget-text-editor" data-id="af93e90" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <a href="https://president.uz/ru">
                                              <img class="aligncenter wp-image-274" src="/images/noupload/useful_link/gerb.png" alt="" width="94" height="95">
                                            </a>
                                          </p>
                                          <h4 style="text-align: center;">
                                            <strong>
                                              <span style="font-size: 12pt;">
                                                <a href="https://president.uz/ru">@lang('index.useful_link_1')</a>
                                              </span>
                                            </strong>
                                          </h4>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="elementor-element elementor-element-de442d8 elementor-column elementor-col-25 elementor-top-column" data-id="de442d8" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-af93e90 elementor-widget elementor-widget-text-editor" data-id="af93e90" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <a href="http://parliament.gov.uz/ru/">
                                              <img class="aligncenter wp-image-274" src="/images/noupload/useful_link/logo_small.png" alt="" width="165" height="95">
                                            </a>
                                          </p>
                                          <h4 style="text-align: center;">
                                            <strong>
                                              <span style="font-size: 12pt;">
                                                <a href="http://parliament.gov.uz/ru/">@lang('index.useful_link_2')</a>
                                              </span>
                                            </strong>
                                          </h4>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="elementor-element elementor-element-de442d8 elementor-column elementor-col-25 elementor-top-column" data-id="de442d8" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-af93e90 elementor-widget elementor-widget-text-editor" data-id="af93e90" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <a href="http://www.senat.gov.uz/ru">
                                              <img class="aligncenter wp-image-274" src="/images/noupload/useful_link/senate.jpg" alt="" width="150" height="95">
                                            </a>
                                          </p>
                                          <h4 style="text-align: center;">
                                            <strong>
                                              <span style="font-size: 12pt;">
                                                <a href="http://www.senat.gov.uz/ru">@lang('index.useful_link_3')</a>
                                              </span>
                                            </strong>
                                          </h4>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="elementor-element elementor-element-de442d8 elementor-column elementor-col-25 elementor-top-column" data-id="de442d8" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-af93e90 elementor-widget elementor-widget-text-editor" data-id="af93e90" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <a href="https://www.gov.uz/ru">
                                              <img class="aligncenter wp-image-274" src="/images/noupload/useful_link/gerb.png" alt="" width="94" height="95">
                                            </a>
                                          </p>
                                          <h4 style="text-align: center;">
                                            <strong>
                                              <span style="font-size: 12pt;">
                                                <a href="https://www.gov.uz/ru">@lang('index.useful_link_4')</a>
                                              </span>
                                            </strong>
                                          </h4>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>


                            </div>
                          </div>
                        </section>
                        <section class="elementor-element elementor-element-4e0a657 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="4e0a657" data-element_type="section">
                          <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-row">

                              <div class="elementor-element elementor-element-fb8cd8e elementor-column elementor-col-25 elementor-top-column" data-id="fb8cd8e" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-5cb995f elementor-widget elementor-widget-text-editor" data-id="5cb995f" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <span style="font-size: 12pt;">
                                              <a href="https://mineconomy.uz/ru">
                                                <img class="aligncenter wp-image-274" src="/images/noupload/useful_link/gerb.png" alt="" width="94" height="95" >
                                              </a>
                                            </span>
                                          </p>
                                          <h4 style="text-align: center;">
                                            <span style="font-size: 12pt;">
                                              <strong>
                                                <a href="https://mineconomy.uz/ru">@lang('index.useful_link_5')</a>
                                              </strong>
                                            </span>
                                          </h4>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="elementor-element elementor-element-fb8cd8e elementor-column elementor-col-25 elementor-top-column" data-id="fb8cd8e" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-5cb995f elementor-widget elementor-widget-text-editor" data-id="5cb995f" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <span style="font-size: 12pt;">
                                              <a href="https://lex.uz/ru/">
                                                <img class="aligncenter wp-image-274" src="/images/noupload/useful_link/lexuz.png" alt="" width="165" height="95" >
                                              </a>
                                            </span>
                                          </p>
                                          <h4 style="text-align: center;">
                                            <span style="font-size: 12pt;">
                                              <strong>
                                                <a href="https://lex.uz/ru/">@lang('index.useful_link_6')</a>
                                              </strong>
                                            </span>
                                          </h4>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="elementor-element elementor-element-fb8cd8e elementor-column elementor-col-25 elementor-top-column" data-id="fb8cd8e" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-5cb995f elementor-widget elementor-widget-text-editor" data-id="5cb995f" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <span style="font-size: 12pt;">
                                              <a href="https://stat.uz/ru/">
                                                <img class="aligncenter wp-image-274" src="/images/noupload/useful_link/logo_stat.png" alt="" width="140" height="95" >
                                              </a>
                                            </span>
                                          </p>
                                          <h4 style="text-align: center;">
                                            <span style="font-size: 12pt;">
                                              <strong>
                                                <a href="https://stat.uz/ru/">@lang('index.useful_link_7')</a>
                                              </strong>
                                            </span>
                                          </h4>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="elementor-element elementor-element-fb8cd8e elementor-column elementor-col-25 elementor-top-column" data-id="fb8cd8e" data-element_type="column">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                  <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-5cb995f elementor-widget elementor-widget-text-editor" data-id="5cb995f" data-element_type="widget" data-widget_type="text-editor.default">
                                      <div class="elementor-widget-container">
                                        <div class="elementor-text-editor elementor-clearfix">
                                          <p>
                                            <span style="font-size: 12pt;">
                                              <a href="https://regulation.gov.uz/ru">
                                                <img class="aligncenter wp-image-274" src="/images/noupload/useful_link/gerb.png" alt="" width="94" height="95" >
                                              </a>
                                            </span>
                                          </p>
                                          <h4 style="text-align: center;">
                                            <span style="font-size: 12pt;">
                                              <strong>
                                                <a href="https://regulation.gov.uz/ru">@lang('index.useful_link_8')</a>
                                              </strong>
                                            </span>
                                          </h4>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </section> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <footer class="entry-footer"></footer>
            </article>
          </main>
        </div>

      </div>
    </div>
  </div>

  <div class="content">
    <div class="container">
      <div class="store_section">
        <div class="title-carousel">
  				<h3>@lang('index.useful_link')</h3>
          <div class="row">
    				<div class="items">

    					<div class="card">

    						<a href="https://president.uz/ru">
                  <div class="card-img">
      							<img src="/images/noupload/useful_link/gerb.png">
      						</div>
                </a>

    						<div class="profile">
    							<a href="https://president.uz/ru">
                    <h3>@lang('index.useful_link_1')</h3>
                  </a>
    						</div>

    					</div>
    					<div class="card">

    						<div class="card-img">
                  <a href="http://parliament.gov.uz/ru">
      							<img src="/images/noupload/useful_link/logo_small.png">
                  </a>
    						</div>

    						<div class="profile">
                  <a href="http://parliament.gov.uz/ru">
      							<h3>@lang('index.useful_link_2')</h3>
                  </a>
    						</div>

    					</div>
    					<div class="card">

    						<div class="card-img">
    							<a href="http://www.senat.gov.uz/ru">
                    <img src="/images/noupload/useful_link/senate.jpg">
                  </a>
    						</div>

    						<div class="profile">
    							<a href="http://www.senat.gov.uz/ru">
                    <h3>@lang('index.useful_link_3')</h3>
                  </a>
    						</div>

    					</div>
    					<div class="card">

    						<div class="card-img">
    							<a href="https://www.gov.uz/ru">
                    <img src="/images/noupload/useful_link/gerb.png">
                  </a>
    						</div>

    						<div class="profile">
    							<a href="https://www.gov.uz/ru">
                    <h3>@lang('index.useful_link_4')</h3>
                  </a>
    						</div>

    					</div>
    					<div class="card">

    						<div class="card-img">
    							<a href="https://mineconomy.uz/ru">
                    <img src="/images/noupload/useful_link/gerb.png">
                  </a>
    						</div>

    						<div class="profile">
    							<a href="https://mineconomy.uz/ru">
                    <h3>@lang('index.useful_link_5')</h3>
                  </a>
    						</div>

    					</div>
    					<div class="card">

    						<div class="card-img">
    							<a href="https://lex.uz/ru">
                    <img src="/images/noupload/useful_link/lexuz.png">
                  </a>
    						</div>

    						<div class="profile">
    							<a href="https://lex.uz/ru">
                    <h3>@lang('index.useful_link_6')</h3>
                  </a>
    						</div>

    					</div>
    					<div class="card">

    						<div class="card-img">
    							<a href="https://stat.uz/ru">
                    <img src="/images/noupload/useful_link/logo_stat.png">
                  </a>
    						</div>

    						<div class="profile">
    							<a href="https://stat.uz/ru">
                    <h3>@lang('index.useful_link_7')</h3>
                  </a>
    						</div>

    					</div>
    					<div class="card">

    						<div class="card-img">
    							<a href="https://regulation.gov.uz/ru">
                    <img src="/images/noupload/useful_link/gerb.png">
                  </a>
    						</div>

    						<div class="profile">
    							<a href="https://regulation.gov.uz/ru">
                    <h3>@lang('index.useful_link_8')</h3>
                  </a>
    						</div>

    					</div>

    				</div>
    			</div>
  			</div>
      </div>

    </div>
  </div>

@endsection

@section('script')

<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
  <script src="/owlcarousel/jquery.js"></script>
  <script src="/owlcarousel/owl.carousel.min.js"></script>
  <script src="/carousel/slick.min.js"></script>
  <script src="/carousel/carousels.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    $(".header-img-slide").owlCarousel({
      items: 1,
      animateOut:  'fadeOut' ,
      autoplay: true,
      loop: true,
      dots: true
    });
  });
  </script>
@endsection
