<?php

namespace Mouyong\Foundation\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class CacheServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['cache'] = function () {
            $namespace = $pimple['options']['cache']['namespace'] ?? 'foundation';

            return new FilesystemAdapter($namespace);
        };
    }
}