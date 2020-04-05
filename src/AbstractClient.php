<?php

namespace Mouyong\Foundation;

use Mouyong\Foundation\Contracts\ApiContract;

abstract class AbstractClient implements ApiContract
{
    /**
     * @var Foundation
     */
    protected $app;

    public function __construct(Foundation $app)
    {
        $this->app = $app;

    }

    public function getClient()
    {
        return $this->app->http;
    }

    public function get($uri, $data = [], $options = [])
    {
        return $this->doRequest('GET', $uri, $data, $options);
    }

    public function post($uri, $data = [], $options = [])
    {
        return $this->doRequest('POST', $uri, $data, $options);
    }

    public function json($uri, $data = [], $options = [])
    {
        return $this->doRequest('JSON', $uri, $data, $options);
    }

    public function doRequest(string $method, string $uri, array $data = [], array $options = [])
    {
        if (property_exists($this->app, 'access_token')) {
            $data = $this->app->access_token->applyAccessTokenToRequest($data);
        }

        $data = $this->sign($data);

        $method = strtoupper($method);

        switch ($method) {
            case 'GET': $options['query'] = $data; break;
            case 'POST': $options['form_params'] = $data; break;
            case 'JSON': $options['json'] = $data; $method = 'POST'; break;
        }

        return $this->request($method, $uri, $options);
    }

    abstract public function sign(array $data = []): array ;

    abstract public function request(string $method, string $uri, array $options = []);

    abstract public function castResponseToType($response);
}