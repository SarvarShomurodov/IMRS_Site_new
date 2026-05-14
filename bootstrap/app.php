<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckStatus;
use App\Providers\SlugServiceProvider;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\LangDefine;
use App\Http\Middleware\JournalAuth;
use App\Http\Middleware\JournalGuest;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        SlugServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'checkstatus'   => CheckStatus::class,
            'set_locale'    => SetLocale::class,
            'lang_define'   => LangDefine::class,
            'journal.auth'  => JournalAuth::class,
            'journal.guest' => JournalGuest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
