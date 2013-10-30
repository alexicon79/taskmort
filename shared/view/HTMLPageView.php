<?php

namespace shared\view;

/**
 * Handles visual representation of application
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class HTMLPageView {
    
    /**
     * @var string $css
     */
	private $css;

    /**
     * @var string $js
     */
    private $js;

    /**
     * @var string $jquery
     */
    private $jquery = "http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js";
    
    /**
     * @var string $jqueryUI_CSS
     */
    private $jqueryUI_CSS = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
    
    /**
     * [$jqueryUI description]
     * @var string
     */
    private $jqueryUI = "http://code.jquery.com/ui/1.10.3/jquery-ui.js";

    public function __construct($styleSheetUrl, $javaScriptUrl) {
        $this->css = $styleSheetUrl;
        $this->js = $javaScriptUrl;
    }
    
    /**
     * Set applications stylesheet
     * @param string Path to stylesheet file
     */
    public function setStyleSheet($styleSheetUrl) {
        $this->css = $styleSheetUrl;
    }
    
    /**
     * Set applications JavaScript
     * @param string Path to JavaScript file
     */
    public function setJavaScript($javaScriptUrl) {
        $this->js = $javaScriptUrl;
    }
    
    /**
     * Get HTML Page
     * @param  string $title
     * @param  string $body
     * @return string HTML
     */
    public function getHTMLPage($title, $body) {

        $html = "
        <!DOCTYPE HTML>
        <html>
        <head>
        <title> " . $title . "</title>
        <meta http-equiv='content-type' content='text/html; charset=utf-8'>
        <link rel='stylesheet' href='" . $this->css . "' />
        <link rel='stylesheet' href='" . $this->jqueryUI_CSS . "' />
        <script src=' " . $this->jquery . "'></script>
        <script src='" . $this->jqueryUI . "'></script>
        <script src='" . $this->js . "' type='text/javascript'></script>
        </head>
        <body>
        <div id='mainWrapper'>"
        . $body .
        "</div>
        </body>
        </html>";

        return $html;
    }
}