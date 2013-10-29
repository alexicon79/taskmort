<?php

namespace app\view;

require_once("../app/views/Navigation.php");
require_once("../app/views/ListView.php");
require_once("../app/models/ListModel.php");


class MainView {

	private $cssFile;
	private $jsFile;
	private $navigation;
	private $header;
	private $listView;

	/** @todo: add specific views **/

	public function __construct() {
		$this->cssFile = "assets/css/style.css";
		$this->jsFile = "assets/js/view.js";
		$this->navigation = new \app\view\Navigation();
		$this->listView = new \app\view\ListView();
		/** assign views **/
	}

	public function getStyleSheet() {
		return $this->cssFile;
	}

	public function getJavaScript() {
		return $this->jsFile;
	}
	
	public function getHeader() {
		$html = "<h1>TASKMORT</h1>";
		$html .= $this->navigation->getMenu();
		return $html;
	}

	public function setStyleSheet($href) {
		$this->cssFile = $href;
	}

	public function getEditListPage($listName, $listContent) {
		$html = $this->getHeader();
		$html .= $this->listView->getEditableList($listName, $listContent);

		return new \shared\view\Page("EDIT | $listName", $html);
	}

	public function getViewListPage($listName, $listItems) {
		$html = $this->getHeader();
		$html .= $this->listView->getViewList($listName, $listItems);

		return new \shared\view\Page("VIEW | $listName", $html);
	}

	public function getAllListsPage($listArray, $directoryPath) {
		$html = $this->getHeader();
		$html .= $this->listView->getAllLists($listArray, $directoryPath);
		return new \shared\view\Page("BROWSE", $html);
	}

	public function getDefaultPage() {
		$html = $this->getHeader();
		$html .= $this->listView->getDefaultPage();
		return new \shared\view\Page("WELCOME", $html);
	}

	public function getNewListPage() {
		$html = $this->getHeader();
		$html .= $this->listView->getNewListPrompt();
		return new \shared\view\Page("NEW", $html);
	}

}