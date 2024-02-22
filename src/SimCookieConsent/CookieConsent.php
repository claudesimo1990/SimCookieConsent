<?php

namespace SimCookieConsent;

use Symfony\Component\Yaml\Yaml;

define('ROOT_PATH', dirname(__DIR__) . '/');

class CookieConsent
{
    private string $configPath;

    /**
     * @param string $configPath
     */
    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
    }

    public function getConfig()
    {
        return Yaml::parseFile($this->configPath);
    }

    public function html(): string
    {
        $config = $this->getConfig();
        $blocks = $config['block'];
        $block = [];
        $html = <<<HTML
<style>
.cookie-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: {$config['background_color']};
    color: #fff;
    padding: 10px 20px;
    box-sizing: border-box;
    font-family: {$config['font_family']}!important;
}
.cookie-banner button {
    border: 2px solid white;
    border-radius: 2px;
    color: #fff;
    display: inline-block;
    font-family: Raleway,sans-serif;
    font-size: 15px;
    font-weight: 700;
    float: inline-end;
    letter-spacing: 1px;
    margin: 10px;
    padding: 10px 32px;
    transition: .5s;
    cursor: pointer;
}
.btn1 {
    background: {$config['first_button_style_bg']};
}
.btn2 {
    background: {$config['second_button_style_bg']};
}
input[type='checkbox'] { display: none; } .wrap-collabsible { margin: 1.2rem 0; } .lbl-toggle { transition: all 0.25s ease-out; } .lbl-toggle:hover { color: #FFF; } .lbl-toggle::before { content: ' '; display: inline-block; border-top: 5px solid transparent; border-bottom: 5px solid transparent; border-left: 5px solid currentColor; vertical-align: middle; margin-right: .7rem; transform: translateY(-2px); transition: transform .2s ease-out; } .toggle:checked+.lbl-toggle::before { transform: rotate(90deg) translateX(-3px); } .collapsible-content { max-height: 0px; overflow: hidden; transition: max-height .25s ease-in-out; } .toggle:checked + .lbl-toggle + .collapsible-content { max-height: 350px; } .toggle:checked+.lbl-toggle { border-bottom-right-radius: 0; border-bottom-left-radius: 0; } .collapsible-content .content-inner { padding: .5rem 1rem; } .collapsible-content p { margin-bottom: 0; }
.flex-container {
  display: flex;
}
.flex-container > div {
  border: 1px solid white;
  margin: 10px;
  padding: 20px;
  font-size: 30px;
}
.checkbox + label::before {
  width: 15px;
  height: 15px;
  border-radius: 5px;
  border: 2px solid #8cad2d;
  background-color: #fff;
  display: block;
  content: "";
  float: left;
  margin-right: 5px;
  z-index: 5;
  position: relative;
}
.checkbox:checked+label::before {
  box-shadow: inset 0px 0px 0px 3px #fff;
  background-color: #8cad2d;
}
</style>
<div class="cookie-banner">
    <h2>{$config['title']}</h2>
    <p>{$config['text']}</p>
    <div>
    <div>
    <div class="wrap-collabsible"> 
        <input id="collapsible" class="toggle" type="checkbox"> 
        <label for="collapsible" class="lbl-toggle">Weitere Optionen</label>
        <div class="collapsible-content">
            <div class="content-inner">
                <div class="flex-container">
HTML;
                    foreach($blocks as $key => $block) {
                        $checked = $key === 1 ? 'checked' : '';
                        $html .= <<<HTML
                        <div>
                        <input class="checkbox" {$checked} id="confirm{$block['title']}" type="checkbox" />
                        <label for="confirm{$block['title']}" style="display: flex;font-size: 20px; font-weight: bold;margin-bottom: 5px">{$block['title']}</label>
                        <div style="font-size: 16px">
                            {$block['text']}
                        </div>
</div>
HTML;
                    }
        $html .= <<<HTML
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <div class="buttons">
    <button onClick="acceptCookies()" class="btn1">{$config['first_button_text']}</button>
    <button onClick="acceptCookies()" class="btn2">{$config['second_button_text']}</button>
</div>
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
