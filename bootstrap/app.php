<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminOrUser;
use App\Http\Middleware\Archive;
use App\Http\Middleware\Consumer;
use App\Http\Middleware\Fouls;
use App\Http\Middleware\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'isAdmin' => Admin::class,
            'isConsumer' => Consumer::class,
            'isUser' => User::class,
            'isArchive' => Archive::class,
            'isFouls' => Fouls::class,
            'isAdminOrUser' => AdminOrUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
