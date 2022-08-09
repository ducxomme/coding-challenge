<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Log;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ルートURLを設定
        \Illuminate\Support\Facades\URL::forceRootUrl(\config('app.url'));
        // https://github.com/laravel/framework/issues/15361
        \Illuminate\Pagination\AbstractPaginator::currentPathResolver(function () {
            /** @var \Illuminate\Routing\UrlGenerator $url */
           $url = app('url');
           return $url->current();
        });

        // 発行したクエリをログ出力
        DB::listen(function ($query) {
            $str = $query->time . ' ms -> ' . $query->sql;
            $data = ['query' => '', 'bind' => ''];
            $data['query'] = $str;
            if ($query->bindings) {
                $data['bind'] = var_export($query->bindings, true);
            }

            Log::channel('sql')->debug('sql_log', $data);
        });

        // paginate した時の prev, next へのリンクを https で取れるようにする設定。
        // 参考 URL) https://qiita.com/takuma-jpn/items/712a3ec7abcd045a087d
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
