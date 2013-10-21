<?php

namespace shared\view;

class HTMLPageView {

	private $css;

	public function __construct($styleSheetUrl) {
		$this->css = $styleSheetUrl;
	}

	public function setStyleSheet($styleSheetUrl) {
		$this->css = $styleSheetUrl;
	}

	public function getHTMLPage($title, $body) {
        
    $html = "
        <!DOCTYPE HTML>
        <html>
        	<head>
            	<title>$title</title>
            	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
            	<link rel='stylesheet' href='$this->css' />
          	</head>
         	<body>
            	$body
          	</body>
        </html>";
        
    return $html;
  }
}