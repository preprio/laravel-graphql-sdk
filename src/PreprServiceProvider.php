<?php

namespace Preprio;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class PreprServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Http::macro('prepr', function ($data) {

            $headers = [];

            if(data_get($data,'headers')) {
                $headers = data_get($data,'headers');
            }

            if (\Request()->hasHeader('x-real-ip')) {
                data_set($headers, 'Prepr-Client-IP', \Request()->header('x-real-ip'));
            }

            $json = [
                'query' => null,
                'variables' => []
            ];

            if(data_get($data,'query')) {
                $json['query'] = file_get_contents(app_path('Queries/' . data_get($data,'query') . '.graphql'));
            } elseif(data_get($data,'raw-query')) {
                $json['query'] = data_get($data,'raw-query');
            }

            if(data_get($data,'variables')) {
                $json['variables'] = data_get($data,'variables');
            }

            return Http::acceptJson()->withHeaders($headers)->post(config('services.prepr.endpoint'), $json);

        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {

    }
}