<?php

namespace Mouyong\Foundation\Contracts;

interface ApiContract
{
    public function sign(array $data = []): array ;

    public function request(string $method, string $uri, array $options = []);

    public function castResponseToType($response);
}