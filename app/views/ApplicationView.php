<?php

namespace app\view;

require_once("../app/views/Navigation.php");


class ApplicationView {

	private $cssFile;
	private $navigation;
	private $header;

	/** @todo: add specific views **/

	public function __construct() {
		$this->cssFile = "assets/css/style.css";
		$this->navigation = new \app\view\Navigation();
		/** assign views **/
	}

	public function getStyleSheet() {
		return $this->cssFile;
	}
	
	public function getHeader() {
		$html = "<h1>TASKMORT</h1>";
		$html .= $this->navigation->getMenu();
		return $html;
	}

	public function setStyleSheet($href) {
		$this->cssFile = $href;
	}

	public function getEditListPage() {
			
	}

	public function getMainPage() {
		$html = $this->getHeader();
		
		return new \shared\view\Page("TITLE", "$html");
	}

}