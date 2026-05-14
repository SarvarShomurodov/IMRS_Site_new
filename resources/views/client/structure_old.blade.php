@extends('client.layouts.app')

@section('metadata')
  <title>@lang('index.structure_of_inst') | @lang('index.index')</title>
  <meta name="description" content="@lang('index.structure_of_inst') |  @lang('index.index_des')">
  <meta name="keywords" content="@lang('index.structure_of_inst')">
  <meta property="og:title" content=" @lang('index.structure_of_inst') | @lang('index.index')">
  <meta property="og:description" content="@lang('index.structure_of_inst') |  @lang('index.index_des')">
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
                <span itemprop="name">@lang('index.structure')</span>
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
              <article id="post-30" class="post-30 page type-page status-publish hentry">
                <header class="entry-header">
                  <h1 class="entry-title">@lang('index.organization_structure')</h1>
                </header>
                <div class="entry-content-wrapper">
                  <div class="entry-content">
                    <div data-elementor-type="wp-page" data-elementor-id="30" class="elementor elementor-30" data-elementor-settings="[]">
                      <div class="elementor-inner">
                        <div class="elementor-section-wrap">


                              <section class="elementor-element elementor-element-184e955 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="184e955" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                  <div class="elementor-row">
                                    <div class="elementor-element elementor-element-86ba929 elementor-column elementor-col-33 elementor-top-column" data-id="86ba929" data-element_type="column">
                                      <div class="elementor-column-wrap">
                                        <div class="elementor-widget-wrap"></div>
                                      </div>
                                    </div>
                                    @foreach(\App\Models\Structure::where('is_parent', 'yes')->where('sort', 1)->get() as $item)
                                      <div class="elementor-element elementor-element-405259a elementor-column elementor-col-33 elementor-top-column" data-id="405259a" data-element_type="column">
                                        <div class="elementor-column-wrap  elementor-element-populated">
                                          <div class="elementor-widget-wrap">
                                            <div class="elementor-element elementor-element-2199cbc elementor-button-info elementor-align-justify elementor-widget elementor-widget-button" data-id="2199cbc" data-element_type="widget" data-widget_type="button.default">
                                              <div class="elementor-widget-container">
                                                <div class="elementor-button-wrapper">
                                                  <a href="{{$item->slug}}" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button" @if($item->type==1) style="border-radius: 30px" @endif>
                                                    <span class="elementor-button-content-wrapper">
                                                      <span class="elementor-button-text">{{$item->getTitleAttribute()}}</span>
                                                    </span>
                                                  </a>
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

                              <section class="elementor-element elementor-element-184e955 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="184e955" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                  <div class="elementor-row">
                                    <div class="elementor-element elementor-element-86ba929 elementor-column elementor-col-33 elementor-top-column" data-id="86ba929" data-element_type="column">
                                      <div class="elementor-column-wrap">
                                        <div class="elementor-widget-wrap"></div>
                                      </div>
                                    </div>
                                    @foreach(\App\Models\Structure::where('is_parent', 'yes')->where('sort', '!=', 1)->get() as $item)
                                      <div class="elementor-element elementor-element-405259a elementor-column elementor-col-33 elementor-top-column" data-id="405259a" data-element_type="column">
                                        <div class="elementor-column-wrap  elementor-element-populated">
                                          <div class="elementor-widget-wrap">
                                            <div class="elementor-element elementor-element-2199cbc elementor-button-info elementor-align-justify elementor-widget elementor-widget-button" data-id="2199cbc" data-element_type="widget" data-widget_type="button.default">
                                              <div class="elementor-widget-container">
                                                <div class="elementor-button-wrapper">
                                                  <a href="{{$item->slug}}" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button" @if($item->type==1) style="border-radius: 30px" @endif>
                                                    <span class="elementor-button-content-wrapper">
                                                      <span class="elementor-button-text">{{$item->getTitleAttribute()}}</span>
                                                    </span>
                                                  </a>
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

                <div class="structure-our-form" style="">
                  <div class="structure-block">
                    <div class="elementor-element elementor-element-86ba929 elementor-column elementor-col-25 elementor-top-column" data-id="86ba929" data-element_type="column">
                      <div class="elementor-column-wrap">
                        <div class="elementor-widget-wrap"></div>
                      </div>
                    </div>
                    @foreach(\App\Models\Structure::where('is_parent', 'no')->where('column', 1)->orderBy('sort')->get() as $item)
                      <div class="elementor-element elementor-element-405259a elementor-column elementor-col-25 elementor-top-column" data-id="{{$item->id}}" data-element_type="column">
                        <div class="elementor-column-wrap  elementor-element-populated">
                          <div class="elementor-widget-wrap">
                            <div class="elementor-element elementor-element-2199cbc elementor-button-info elementor-align-justify elementor-widget elementor-widget-button" data-id="2199cbc" data-element_type="widget" data-widget_type="button.default">
                              <div class="elementor-widget-container">
                                <div class="elementor-button-wrapper">
                                  <a href="{{$item->slug}}" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button" @if($item->type==1) style="border-radius: 30px" @endif>
                                    <span class="elementor-button-content-wrapper">
                                      <span class="elementor-button-text">{{$item->getTitleAttribute()}}</span>
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="structure-block">
                    <div class="elementor-element elementor-element-86ba929 elementor-column elementor-col-25 elementor-top-column" data-id="86ba929" data-element_type="column">
                      <div class="elementor-column-wrap">
                        <div class="elementor-widget-wrap"></div>
                      </div>
                    </div>
                    @foreach(\App\Models\Structure::where('is_parent', 'no')->where('column', 2)->orderBy('sort')->get() as $item)
                      <div class="elementor-element elementor-element-405259a elementor-column elementor-col-25 elementor-top-column" data-id="{{$item->id}}" data-element_type="column">
                        <div class="elementor-column-wrap  elementor-element-populated">
                          <div class="elementor-widget-wrap">
                            <div class="elementor-element elementor-element-2199cbc elementor-button-info elementor-align-justify elementor-widget elementor-widget-button" data-id="2199cbc" data-element_type="widget" data-widget_type="button.default">
                              <div class="elementor-widget-container">
                                <div class="elementor-button-wrapper">
                                  <a href="{{$item->slug}}" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button" @if($item->type==1) style="border-radius: 30px" @endif>
                                    <span class="elementor-button-content-wrapper">
                                      <span class="elementor-button-text">{{$item->getTitleAttribute()}}</span>
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="structure-block">
                    <div class="elementor-element elementor-element-86ba929 elementor-column elementor-col-25 elementor-top-column" data-id="86ba929" data-element_type="column">
                      <div class="elementor-column-wrap">
                        <div class="elementor-widget-wrap"></div>
                      </div>
                    </div>
                    @foreach(\App\Models\Structure::where('is_parent', 'no')->where('column', 3)->orderBy('sort')->get() as $item)
                      <div class="elementor-element elementor-element-405259a elementor-column elementor-col-25 elementor-top-column" data-id="{{$item->id}}" data-element_type="column">
                        <div class="elementor-column-wrap  elementor-element-populated">
                          <div class="elementor-widget-wrap">
                            <div class="elementor-element elementor-element-2199cbc elementor-button-info elementor-align-justify elementor-widget elementor-widget-button" data-id="2199cbc" data-element_type="widget" data-widget_type="button.default">
                              <div class="elementor-widget-container">
                                <div class="elementor-button-wrapper">
                                  <a href="{{$item->slug}}" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button" @if($item->type==1) style="border-radius: 30px" @endif>
                                    <span class="elementor-button-content-wrapper">
                                      <span class="elementor-button-text">{{$item->getTitleAttribute()}}</span>
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="structure-block">
                    <div class="elementor-element elementor-element-86ba929 elementor-column elementor-col-25 elementor-top-column" data-id="86ba929" data-element_type="column">
                      <div class="elementor-column-wrap">
                        <div class="elementor-widget-wrap"></div>
                      </div>
                    </div>
                    @foreach(\App\Models\Structure::where('is_parent', 'no')->where('column', 4)->orderBy('sort')->get() as $item)
                      <div class="elementor-element elementor-element-405259a elementor-column elementor-col-25 elementor-top-column" data-id="{{$item->id}}" data-element_type="column">
                        <div class="elementor-column-wrap  elementor-element-populated">
                          <div class="elementor-widget-wrap">
                            <div class="elementor-element elementor-element-2199cbc elementor-button-info elementor-align-justify elementor-widget elementor-widget-button" data-id="2199cbc" data-element_type="widget" data-widget_type="button.default">
                              <div class="elementor-widget-container">
                                <div class="elementor-button-wrapper">
                                  <a href="{{$item->slug}}" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button" @if($item->type==1) style="border-radius: 30px" @endif>
                                    <span class="elementor-button-content-wrapper">
                                      <span class="elementor-button-text">{{$item->getTitleAttribute()}}</span>
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="structure-block">
                    <div class="elementor-element elementor-element-86ba929 elementor-column elementor-col-25 elementor-top-column" data-id="86ba929" data-element_type="column">
                      <div class="elementor-column-wrap">
                        <div class="elementor-widget-wrap"></div>
                      </div>
                    </div>
                    @foreach(\App\Models\Structure::where('is_parent', 'no')->where('column', 5)->orderBy('sort')->get() as $item)
                      <div class="elementor-element elementor-element-405259a elementor-column elementor-col-25 elementor-top-column" data-id="{{$item->id}}" data-element_type="column">
                        <div class="elementor-column-wrap  elementor-element-populated">
                          <div class="elementor-widget-wrap">
                            <div class="elementor-element elementor-element-2199cbc elementor-button-info elementor-align-justify elementor-widget elementor-widget-button" data-id="2199cbc" data-element_type="widget" data-widget_type="button.default">
                              <div class="elementor-widget-container">
                                <div class="elementor-button-wrapper">
                                  <a href="{{$item->slug}}" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button" @if($item->type==1) style="border-radius: 30px" @endif>
                                    <span class="elementor-button-content-wrapper">
                                      <span class="elementor-button-text">{{$item->getTitleAttribute()}}</span>
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>

                <footer class="entry-footer">
                </footer>
              </article>
            </main>
          </div>
        </div>
      </div>
    </div>

@endsection
