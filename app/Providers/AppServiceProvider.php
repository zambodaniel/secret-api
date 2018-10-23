<?php

namespace App\Providers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->configure('base');

        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
            return new \Illuminate\Routing\ResponseFactory(
                $app['Illuminate\Contracts\View\Factory'],
                $app['Illuminate\Routing\Redirector']
            );
        });

        Response::macro('xml', function($vars, $status = 200, array $header = array(), $rootElement = 'response', $xml = null)
        {

            if (is_object($vars) && $vars instanceof Arrayable) {
                $vars = $vars->toArray();
            }

            if (is_null($xml)) {
                $xml = new \SimpleXMLElement('<' . $rootElement . '/>');
            }
            foreach ($vars as $key => $value) {
                if (is_array($value)) {
                    if (is_numeric($key)) {
                        Response::xml($value, $status, $header, $rootElement, $xml->addChild(str_singular($xml->getName())));
                    } else {
                        Response::xml($value, $status, $header, $rootElement, $xml->addChild($key));
                    }
                } else {
                    $xml->addChild($key, $value);
                }
            }
            if (empty($header)) {
                $header['Content-Type'] = 'application/xml';
            }
            return Response::make($xml->asXML(), $status, $header);
        });
    }
}
