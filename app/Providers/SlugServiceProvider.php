<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\ArchiveSlug;
use App\Library\Services\NewsSlug;
use App\Library\Services\PublicationCategorySlug;
use App\Library\Services\PublicationSlug;
use App\Library\Services\PageSlug;
use App\Library\Services\LawCategorySlug;

class SlugServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\ArchiveSlug', function ($app) {
          return new ArchiveSlug();
        });

        $this->app->bind('App\Library\Services\NewsSlug', function ($app) {
          return new NewsSlug();
        });

        $this->app->bind('App\Library\Services\PublicationCategorySlug', function ($app) {
          return new PublicationCategorySlug();
        });

        $this->app->bind('App\Library\Services\PublicationSlug', function ($app) {
          return new PublicationSlug();
        });

        $this->app->bind('App\Library\Services\PageSlug', function ($app) {
          return new PageSlug();
        });

        $this->app->bind('App\Library\Services\LawCategorySlug', function ($app) {
          return new LawCategorySlug();
        });
    }
}
