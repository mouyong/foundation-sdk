<?php

namespace Mouyong\Foundation;

use Symfony\Contracts\Cache\ItemInterface;

abstract class AbstractAccessToken
{
    protected $app;

    protected $access_token_key = 'access_token';

    protected $refresh_token_key = 'refresh_token';

    protected $expire_in_key = 'expire_in';

    public function __construct(Foundation $app)
    {
        $this->app = $app;
    }

    abstract public function getClient(): AbstractClient;

    public function token($force = false)
    {
        if ((! $this->hasToken()) || $force) {
            $this->app->cache->delete($this->cacheFor());
        }

        return $this->app->cache->get($this->cacheFor(), function (ItemInterface $item) {
            $tokenResult = $this->getTokenFromServer();

            $item->expiresAfter($tokenResult[$this->expire_in_key] ?? 7200 - 500);

            return $tokenResult;
        });
    }

    abstract public function applyAccessTokenToRequest(array $data = []);

    abstract public function getTokenFromServer();

    abstract public function refreshToken();

    public function hasToken(): bool
    {
        return $this->app->cache->hasItem($this->cacheFor());
    }

    public function getToken(): string
    {
        return $this->token()[$this->access_token_key] ?? '';
    }

    public function getRefreshToken()
    {
        return $this->token()[$this->refresh_token_key] ?? '';
    }

    public function credential()
    {
        return [];
    }

    protected function cacheFor()
    {
        return 'access_token.'.sha1(json_encode($this->credential()));
    }
}