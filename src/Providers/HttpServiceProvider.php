<?php

namespace Mouyong\Foundation\Providers;

use Pimple\Container;
use GuzzleHttp\Client;
use Pimple\ServiceProviderInterface;

class HttpServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['http'] = function ($pimple) {
            $options = $pimple['options']['http'] ?? [
                'timeout' => 10,
            ];

            return new Client($options);
        };
    }
}