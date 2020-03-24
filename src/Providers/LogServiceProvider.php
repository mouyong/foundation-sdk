<?php

namespace Mouyong\Foundation\Providers;

use Pimple\Container;
use Mouyong\Foundation\Log;
use Pimple\ServiceProviderInterface;

class LogServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['log'] = function ($pimple) {
            $name = $pimple['options']['log']['name'] ?? 'foundation';

            return Log::getLogger()->withName($name);
        };
    }
}