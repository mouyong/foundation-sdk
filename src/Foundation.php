<?php

namespace Mouyong\Foundation;

use Monolog\Logger;
use Pimple\Container;
use GuzzleHttp\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Mouyong\Foundation\Providers\LogServiceProvider;
use Mouyong\Foundation\Providers\HttpServiceProvider;
use Mouyong\Foundation\Providers\CacheServiceProvider;
use Mouyong\Foundation\Providers\RequestServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Foundation
 * @package Mouyong\Foundation
 *
 * @property-read AbstractAccessToken $access_token
 * @property-read FilesystemAdapter $cache
 * @property-read Logger $log
 * @property-read Client $http
 * @property-read Request $request
 */
class Foundation extends Container
{
    private $baseProviders = [
        CacheServiceProvider::class,
        LogServiceProvider::class,
        RequestServiceProvider::class,
        HttpServiceProvider::class,
    ];

    protected $providers = [];

    protected $config = [];

    public function __construct(array $options = [])
    {
        parent::__construct();

        $this['options'] = function () use ($options) {
            $this->config = new Collection(array_merge($this->config, $options));

            return $this->config;
        };

        foreach ($this->providers() as $provider) {
            $this->register(new $provider);
        }
    }

    public function providers()
    {
        return array_merge($this->baseProviders, $this->providers);
    }

    public function __get($name)
    {
        return $this[$name];
    }
}