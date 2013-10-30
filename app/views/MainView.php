<?php

namespace app\view;

require_once("../app/views/Navigation.php");
require_once("../app/views/ListView.php");

/**
 * Handles visual representation of application
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class MainView {
	
	/**
	 * @var string $cssFile Path to application stylesheet
	 */
	private $cssFile;

	/**
	 * @var string $jsFile Path to application JavaScript
	 */
	private $jsFile;

	/**
	 * @var app\view\Navigation $navigation
	 */
	private $navigation;

	/**
	 * @var app\view\ListView
	 */
	private $listView;

	public function __construct() {
		$this->cssFile = "assets/css/style.css";
		$this->jsFile = "assets/js/view.js";
		$this->navigation = new \app\view\Navigation();
		$this->listView = new \app\view\ListView();
	}

	/**
	 * Gets path to applications stylesheet file
	 * @return string
	 */
	public function getStyleSheet() {
		return $this->cssFile;
	}

	/**
	 * Gets path to applications JavaScript file
	 * @return string
	 */
	public function getJavaScript() {
		return $this->jsFile;
	}
	
	/**
	 * Get application header
	 * @return string HTML
	 */
	public function getHeader() {
		$html = $this->navigation->getMenu();
		return $html;
	}
	
	/**
	 * Sets path to applications JavaScript file
	 * @param string
	 */
	public function setStyleSheet($href) {
		$this->cssFile = $href;
	}
	
	/**
	 * Gets editable list view
	 * @param  string $listName Name of list do display
	 * @param  string $listContent Content as plain text
	 * @return \shared\view\Page
	 */
	public function getEditListPage($listName, $listContent) {
		$html = $this->getHeader();
		$html .= $this->listView->getEditableList($listName, $listContent);

		return new \shared\view\Page("EDIT | $listName", $html);
	}
	
	/**
	 * Gets fancy list view
	 * @param  string $listName Name of list to display
	 * @param  \app\model\TaskList $listItems List items
	 * @return \shared\view\Page
	 */
	public function getViewListPage($listName, $listItems) {
		$html = $this->getHeader();
		$html .= $this->listView->getViewList($listName, $listItems);

		return new \shared\view\Page("VIEW | $listName", $html);
	}
	
	/**
	 * Gets list browser view
	 * @param  array $listArray All list names
	 * @param  string $directoryPath Path to directory
	 * @return \shared\view\Page
	 */
	public function getAllListsPage($listArray, $directoryPath) {
		$html = $this->getHeader();
		$html .= $this->listView->getAllLists($listArray, $directoryPath);
		return new \shared\view\Page("BROWSE", $html);
	}
	
	/**
	 * Gets default page
	 * @return \shared\view\Page
	 */
	public function getDefaultPage() {
		$html = $this->getHeader();
		$html .= $this->listView->getDefaultPage();
		return new \shared\view\Page("WELCOME", $html);
	}
	
	/**
	 * Gets input form for creating new list
	 * @return \shared\view\Page
	 */
	public function getNewListPage() {
		$html = $this->getHeader();
		$html .= $this->listView->getNewListPrompt();
		return new \shared\view\Page("NEW", $html);
	}
}