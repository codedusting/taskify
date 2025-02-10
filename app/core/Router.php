<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function routeTo(string $uri, string $method): mixed
    {
        foreach ($this->routes as $route) {
            if ($route["uri"] === $uri && $route["method"] === strtolower($method)) {
                return require basePath("internal/controllers/".$route["controller"]);
            }
        }
        abort(404);
    }

    public function get(string $uri, string $controller): static
    {
        return $this->add($uri, $controller, "get");
    }

    public function add(string $uri, string $controller, string $method): static
    {
        $this->routes[] = compact("uri", "controller", "method");
        return $this;
    }

    public function post(string $uri, string $controller): static
    {
        return $this->add($uri, $controller, "post");
    }
}