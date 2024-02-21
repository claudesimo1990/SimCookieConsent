<?php

namespace SimCookieConsent;

use Symfony\Component\Yaml\Yaml;

define('ROOT_PATH', dirname(__DIR__) . '/');

class CookieConsent
{
    public function getConfig()
    {
        return Yaml::parseFile(ROOT_PATH . 'config/config.yaml');
    }

    public function showHtml(): string
    {
        $config = $this->getConfig();
        $html = <<<HTML
<style>
.cookie-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    box-sizing: border-box;
    text-align: center;
}
.cookie-banner button {
    background: #2dc899;
    border: 2px solid #2dc899;
    border-radius: 2px;
    color: #fff;
    display: inline-block;
    font-family: Raleway,sans-serif;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 1px;
    margin: 10px;
    padding: 10px 32px;
    transition: .5s;
}
</style>
<div class="cookie-banner">
    <p>{$config['text']}</p>
    <button onClick="acceptCookies()">Accepter</button>
</div>
<script>
    function acceptCookies() {
    document.querySelector('.cookie-banner').style.display = 'none';
}
</script>
HTML;
        return $html;
    }
}
