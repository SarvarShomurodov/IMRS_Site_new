@extends('client.layouts.app')

@section('metadata')
  <title>{{$item->getTitleAttribute()}} | @lang('index.index')</title>
  <meta name="description" content="{{$item->getMetaDescription()}}  @lang('index.index_des')">
  <meta name="keywords" content="{{$item->getMetaKeyword()}}">
  <meta property="og:title" content=" {{$item->getTitleAttribute()}} | @lang('index.index')">
  <meta property="og:description" content="{{$item->getMetaDescription()}}  @lang('index.index_des')">
@endsection

@section('content')
    <div id="breadcrumb">
      <div class="container">
        <div role="navigation" aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs" itemprop="breadcrumb">
          <ul class="trail-items" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <meta name="numberOfItems" content="2">
            <meta name="itemListOrder" content="Ascending">
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="trail-item trail-begin">
              <a href="/" rel="home" itemprop="item">
                <span itemprop="name">@lang('index.home')</span>
              </a>
              <meta itemprop="position" content="1">
            </li>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="trail-item trail-end">
              <span itemprop="item">
                <span itemprop="name">{{$item->getTitleAttribute()}}</span>
              </span>
              <meta itemprop="position" content="2">
            </li>
          </ul>
        </div>
      </div>
    </div>
    
    <div id="content" class="site-content">
      <div class="container">
        <div class="inner-wrapper">
          <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
              <article id="post-4823" class="post-4823 post type-post status-publish format-standard has-post-thumbnail hentry category-news">
                <header class="entry-header">
                  <h1 class="entry-title">{{$item->getTitleAttribute()}}</h1>
                </header>
                <footer class="entry-footer">
                  <span class="posted-on">
                    <a href="https://ifmr.uz/ru/4823/" rel="bookmark">
                      <time class="entry-date published" datetime="2020-11-25T21:34:42+05:00">{{$item->getCreatedData()}}</time>
                      <time class="updated" datetime="2020-11-26T06:10:53+05:00">{{$item->getCreatedData()}}</time>
                    </a>
                  </span>
                </footer>
                @if($item->issetPdf())
      			      <h4>
      			        <strong>
      			          <a href="{{$item->getPdfAttribute()}}" target="_blank" download  style="display: flex; align-items: center; justify-content: flex-end;"> <img src="/images/noupload/pdf.png"> @lang('index.download') </a>
      			        </strong>
      				   </h4>
      				 @endif
               @php $f = 0; @endphp
                    @foreach($item->files as $file)
                      @php $f++; @endphp
                      <h4>
                        <strong>
                          <a href="/files/files/{{$file->file}}" target="_blank" download style="display: flex; align-items: center; justify-content: flex-end;"><img src="/images/noupload/pdf.png">@lang('index.download') {{$f}}</a>
                        </strong>
                      </h4>
                    @endforeach
                @if($item->issetImage())
                  <img width="400" height="267" src="{{$item->getImageAttribute()}}" class="aligncenter wp-post-image" alt="" >
                @endif

                <div class="entry-content-wrapper">
                  <div class="entry-content">
                  	<br><br><br>
                  </div>
                </div>


                @if($item->issetVideo())
                      <section class="elementor-element elementor-element-57c1976 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="57c1976" data-element_type="section">
                        <div class="elementor-container elementor-column-gap-default">
                          <div class="elementor-row">
                            <div class="elementor-element elementor-element-9ac0248 elementor-column elementor-col-33 elementor-top-column" data-id="9ac0248" data-element_type="column">
                              <div class="elementor-column-wrap">
                                <div class="elementor-widget-wrap"></div>
                              </div>
                            </div>
                            <div class="elementor-element elementor-element-bfb2c0e elementor-column elementor-col-33 elementor-top-column" data-id="bfb2c0e" data-element_type="column">
                              <div class="elementor-column-wrap  elementor-element-populated">
                                <div class="elementor-widget-wrap">
                                  <div class="elementor-element elementor-element-7592542 elementor-aspect-ratio-169 elementor-widget elementor-widget-video" data-id="7592542" data-element_type="widget" data-settings="{&quot;aspect_ratio&quot;:&quot;169&quot;}" data-widget_type="video.default">
                                    <div class="elementor-widget-container">
                                      <div class="elementor-wrapper elementor-fit-aspect-ratio elementor-open-inline">
                                        <iframe class="elementor-video-iframe" allowfullscreen="" title="youtube Видеоплеер" src="{{$item->getVideo()}}?feature=oembed&amp;start&amp;end&amp;wmode=opaque&amp;loop=0&amp;controls=1&amp;mute=0&amp;rel=0&amp;modestbranding=0"></iframe>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="elementor-element elementor-element-dfd415f elementor-column elementor-col-33 elementor-top-column" data-id="dfd415f" data-element_type="column">
                              <div class="elementor-column-wrap">
                                <div class="elementor-widget-wrap"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                    @endif


                <div class="entry-content-wrapper">
                  <div class="entry-content">
                    @if($item->issetDescription())
                      <div data-elementor-type="wp-post" data-elementor-id="4823" class="elementor elementor-4823" data-elementor-settings="[]">
                        <div class="elementor-inner">
                          <div class="elementor-section-wrap">
                            <section class="elementor-element elementor-element-3a4a538 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="3a4a538" data-element_type="section">
                              <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-row">
                                  <div class="elementor-element elementor-element-b12e115 elementor-column elementor-col-100 elementor-top-column" data-id="b12e115" data-element_type="column">
                                    <div class="elementor-column-wrap  elementor-element-populated">
                                      <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-7c752be elementor-widget elementor-widget-text-editor" data-id="7c752be" data-element_type="widget" data-widget_type="text-editor.default">
                                          <div class="elementor-widget-container">
                                            <div class="elementor-text-editor elementor-clearfix">
                                              {!!$item->getDescriptionAttribute()!!}
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
                      
                    @elseif($item->issetPdf())
                      <h2>
                        <div id="buttons" style="margin-bottom:10px;">
                          <a href="{{$item->getPdfAttribute()}}?file={{$item->getPdfAttribute()}}">
                            <button>@lang('index.fullscreen')</button>
                          </a>
                          <br>
                          <iframe width="100%" height="1122" src="{{$item->getPdfAttribute()}}"></iframe>
                        </div>
                      </h2>
                    @endif
                    
                    
                    <div class="epvc-post-count">
                      <span class="epvc-eye"></span>
                      <span class="epvc-count"> {{$item->views}}</span>
                    </div>
                    <div style="float: right">
                      <script src="https://yastatic.net/share2/share.js"></script>
<div class="ya-share2" data-curtain data-shape="round" data-services="vkontakte,facebook,odnoklassniki,telegram,twitter"></div>
                    </div>
                  </div>
                </div>
              </article>


              <nav class="navigation post-navigation" role="navigation" aria-label="Записи">
                <h2 class="screen-reader-text">@lang('index.navigation')</h2>
                @if($item1)
                  <div class="nav-links"><div class="nav-previous">
                    <a href="{{route('news', [$archive->slug, $item1->slug])}}" rel="prev">
                      <span class="meta-nav" aria-hidden="true">@lang('index.back')</span>
                      <span class="screen-reader-text">Previous post:</span>
                      <span class="post-title">{{$item1->getTitleAttribute()}}</span>
                    </a>
                  </div>
                @endif
                @if($item2)
                <br>
                  <div class="nav-next">
                    <a href="{{route('news', [$archive->slug, $item2->slug])}}" rel="next">
                      <span class="meta-nav" aria-hidden="true">@lang('index.forward')</span>
                      <span class="screen-reader-text">Next post:</span>
                      <span class="post-title">{{$item2->getTitleAttribute()}}</span>
                    </a>
                  </div>
                @endif
              </div>
            </nav>
          </main>
        </div>
      </div>
    </div>
  </div>
@endsection
