<?php

namespace Cookix;

class Cookie
{
    private $content;

    public function __construct(string $handle, $expiry = 2592000, $secure = false, $http_only = false)
    {
        $this->handle = $handle;
        $this->expiry = $expiry;
        $this->secure = $secure;
        $this->http_only = $http_only;
        $this->loadContent();
    }

    private function loadContent()
    {
        $content = $_COOKIE[$this->handle] ?? null;
        $this->content = $content ? json_decode(\stripslashes($content), true) : null;
    }

    public function get()
    {
        return $this->content;
    }

    public function set($content)
    {
        $content = json_encode($content);
        \setcookie($this->handle, $content, time() + $this->expiry, "/", "", $this->secure, $this->http_only);
        $this->loadContent();
    }

    public function clear()
    {
        unset($_COOKIE[$this->handle]);
        \setcookie($this->handle, null, time() - 10, '/', '', $this->secure, $this->http_only);
    }
}
