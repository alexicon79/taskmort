<?php

namespace shared\view;

class HTMLPageView {

	private $css;
  private $js;

	public function __construct($styleSheetUrl, $javaScriptUrl) {
		$this->css = $styleSheetUrl;
    $this->js = $javaScriptUrl;
	}

	public function setStyleSheet($styleSheetUrl) {
		$this->css = $styleSheetUrl;
	}

  public function setJavaScript($javaScriptUrl) {
    $this->js = $javaScriptUrl;
  }

	public function getHTMLPage($title, $body) {
        
    $html = "
        <!DOCTYPE HTML>
        <html>
        	<head>
            	<title>$title</title>
            	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
            	<link rel='stylesheet' href='$this->css' />
              <link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' />
              <script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
              <script src='http://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>
              <script src='$this->js' type='text/javascript'></script>
          	</head>
         	<body>
            <div id='mainWrapper'>
            	$body
            </div>
          	</body>
        </html>";
        
    return $html;
  }
}