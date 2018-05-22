<?php

namespace App\Providers;

use App\Comment;
use App\Observers\CommentObserver;
use App\Observers\PostObserver;
use App\Post;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);

        // Usage: @md(diskName,fileName)
        // Example: @md(local,a.md)
        Blade::directive('md', function ($expression) {

            $expressionArr = explode(',',$expression);

            $f = Storage::disk($expressionArr[0])->get($expressionArr[1]);

            return \Parsedown::instance()->text($f);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
