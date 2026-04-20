<?php

namespace App\Modules\News\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\News\Domain\Interfaces\NoticiaRepositoryInterface;
use App\Modules\News\Infrastructure\Repositories\NoticiaRepository;

class NewsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(NoticiaRepositoryInterface::class, NoticiaRepository::class);
    }
}
