@extends('client.layouts.app')

@section('metadata')
  <title>{{$item->getMetaDescription()}} | @lang('index.index')</title>
  <meta name="description" content="{{$item->getMetaDescription()}} |  @lang('index.index_des')">
  <meta name="keywords" content="{{$item->getMetaKeyword()}}">
  <meta property="og:title" content="{{$item->getMetaKeyword()}} | @lang('index.index')">
  <meta property="og:description" content="{{$item->getMetaDescription()}} |  @lang('index.index_des')">
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
                <span itemprop="name">@lang('index.publications')</span>
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
              <header class="page-header">
                <h1 class="page-title">{{$item->getTitleAttribute()}}</h1>
              </header>
              @foreach($item->pages as $category)
                <article  class="post-4435 post type-post status-publish format-standard has-post-thumbnail hentry  category-publicationItem">
                  @if($category->issetImage())
                    <a href="{{route('page', [$category->slug])}}">
                      <img width="150" height="150" src="{{$category->getImageAttribute()}}" class="alignleft wp-post-image" alt="">
                    </a>
                  @endif
                  <div class="entry-content-wrapper">

                    <header class="entry-header">
                      <h2 class="entry-title">
                        <a href="{{route('page', [$category->slug])}}" rel="bookmark">{{$category->getTitleAttribute()}}</a>
                      </h2>
                      <span class="for-reviews"> &nbsp;{{date_format($category->created_at, 'Y-m-d')}}</span>
                      <span>
                        <span class="for-reviews-view"></span>
                        @if($category->views)
                          {{$category->views}}
                        @else
                          0
                        @endif
                      </span>
                        <!-- <a href="{{route('page', [$category->slug])}}" class="read-more">@lang('index.next')</a> -->
                    </header>
                    <footer class="entry-footer"></footer>
                    <div class="entry-content">
                      </p>
                    </div>
                  </div>
                </article>
              @endforeach

            </main>
          </div>
        </div>
      </div>
    </div>
@endsection
