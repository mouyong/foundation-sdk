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

            $logger = null;

            // TODO: 更换 logger 为可自定义
            Log::setLogger($logger);

            return Log::getLogger()->withName($name);
        };
    }

    public function formatLogConfig($app)
    {
        if (!empty($app['config']->get('log.channels'))) {
            return $app['config']->get('log');
        }

        if (empty($app['config']->get('log'))) {
            return [
                'log' => [
                    'default' => 'errorlog',
                    'channels' => [
                        'errorlog' => [
                            'driver' => 'errorlog',
                            'level' => 'debug',
                        ],
                    ],
                ],
            ];
        }

        return [
            'log' => [
                'default' => 'single',
                'channels' => [
                    'single' => [
                        'driver' => 'single',
                        'path' => $app['config']->get('log.file') ?: \sys_get_temp_dir().'/logs/easywechat.log',
                        'level' => $app['config']->get('log.level', 'debug'),
                    ],
                ],
            ],
        ];
    }
}