<?php

namespace app\view;

use app\view\helper\ListHelper as helper;

require_once("../app/views/ClientRequestObserver.php");
require_once("../app/views/helpers/list_helpers.php");

/**
 * Handles visual representation of lists
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class ListView extends ClientRequestObserver {

	/**
	 * @var string Regular expression pattern matching a task
	 */
	private static $REGEX_TASK = "/^(- ([^\@\n]+).+)/i";

		/**
	 * @var string Regular expression pattern matching a task
	 */
	private static $REGEX_TASK_V2 = "/^(-([^\@\n]+).+)/i";

	/**
	 * @var string Regular expression pattern matching a completed task
	 */
    private static $REGEX_DONE = "/- (.+@done)/i";

    /**
	 * @var string Regular expression pattern matching a project
     */
	private static $REGEX_PROJECT = "/^(?!-)(.+:)$/i";

	/**
	 * @var string Regular expression pattern matching a note
	 */
	private static $REGEX_NOTE = "/^(?!\-).*(?<!\:)$/i";

	/**
	 * @var string Regular expression pattern matching a note
	 */
	private static $REGEX_TAG = "/@.[^ ]*/i";


	/**
	 * Displays input form for creating new list
	 * @return string HTML
	 */
	public function getNewListPrompt() {
		
		$html = "
		<div id='contentWrapper'>
			<div id='newListPrompt'>
				<form action='?" . parent::$LIST . "=" . parent::$CREATE 
					. "' method='post' enctype='multipart/form-data'>
					<input type='text' size='20' name='" . parent::$NEW_LIST_NAME 
						. "' id='listName' placeholder='New List...' value='' />
					<input type='submit' name='" . parent::$CREATE_LIST . "' value='Create List' />
				</form>
			</div>
		</div>";

		return $html;
	}
	
	/**
	 * Displays all lists
	 * @param  array $listArray Array containing list names
	 * @param  string $directoryPath Path to directory of lists
	 * @return string HTML
	 */
	public function getAllLists($listArray, $directoryPath){
		
		$html = "<div id='contentWrapper'><ul class='listBrowser'>";
		
		foreach ($listArray as $listName) {
			if ($listName == "." || $listName == ".."){
				$html .= "";
			} else {
				$html .="<li>";
					$html .= helper::listUrl(parent::$VIEW, $listName, $listName, "browseFile");
					$html .= helper::listUrl(parent::$DELETE, $listName, "&times;", "deleteList");
				$html .= "</li>";
			}
		}
		
		$html .= "</ul></div>";


		return $html;
	}
	
	/**
	 * Displays fancy list view
	 * @param  string $listName Name of list to show
	 * @param  app\model\TaskList $listItems All list items
	 * @return string HTML
	 */
	public function getViewList($listName, \app\model\TaskList $listItems){

		$dropboxSwitch = $this->getDropboxSwitch();
		
		$html = "
		<div id='contentWrapper'>
		<div class='listName'>$listName</div>
		<div class='viewListWrapper'>
		<div class='listMenu'>
			<a id='edit' href='?" . parent::$LIST ."=" . parent::$EDIT . "&name=" 
				. $listName . "' title='EDIT PLAIN TEXT'></a>
			<a id='addItem' href='' title='ADD ITEM'>+</a>
		</div>
		<form action='?" . parent::$LIST ."=" . parent::$VIEW . "&name=" . $listName 
				. "' method='post' enctype='multipart/form-data'>
		<input id='viewSaveButton' type='submit' name='" . parent::$SAVE_LIST 
				. "' value='' />" . $dropboxSwitch . "
		<ul class='listView'>";
		
		foreach ($listItems->getAllItems() as $item) {
			$item = trim($item);

			if (preg_match(self::$REGEX_NOTE, $item)) {
				$html .= "<li class='item note'><span class='visible'>" . $item . "</span>";
				$html .= "<input type='text' class='hidden editableNote' name='" . parent::$LIST_ITEM 
							. "[]' value='$item'><span class='removeItem_note'>&#10005;</span></li>";
			}

			if (preg_match(self::$REGEX_PROJECT, $item)) {
				$html .= "<li class='item project'><span class='visible'>" . $item . "</span>";
				$html .= "<input type='text' class='hidden editableProject' name='" . parent::$LIST_ITEM 
							. "[]' value='$item'><span class='removeItem_project'>&#10005;</span></li>";
			}
			if (preg_match(self::$REGEX_TASK, $item) || preg_match(self::$REGEX_TASK_V2, $item)) {				
				if (preg_match(self::$REGEX_TAG, $item)) {
					$taggedItem = preg_replace(self::$REGEX_TAG, "<span class='tag'>$0</span>", $item);
					$html .= "<li class='item task'><span class='visible'>" . $taggedItem . "</span>";
				} else {
					$html .= "<li class='item task'><span class='visible'>" . $item . "</span>";
				}
				$html .= "<input type='text' class='hidden editableTask' name='" . parent::$LIST_ITEM 
							. "[]' value='$item'><span class='removeItem'>&#10005;</span></li>";
			}

		}
		$html .= "</ul>
					</form>
					</div></div>";
		return $html;
	}
	
	public function getDropboxSwitch(){
		$html = "<div class='onoffswitch'>
    <input type='checkbox' name='" . parent::$SAVE_DROPBOX . "' class='onoffswitch-checkbox' id='myonoffswitch' >
    <label class='onoffswitch-label' for='myonoffswitch'>
        <div class='onoffswitch-inner'></div>
        <div class='onoffswitch-switch'></div>
    </label>
</div>";

		return $html;
	}

	/**
	 * Displays editable list view
	 * @param  string $listName Name of list to show in edit mode
	 * @param  string $listContents Contents as plain text
	 * @return string HTML
	 */
	public function getEditableList($listName, $listContents) {

		if (empty($listContents)) {
			$listContents = "Add some tasks...";
		}

		$html = "
		<div id='contentWrapper'>
		<div class='listName'>$listName</div>
		<div class='editListWrapper'>
			<div class='listMenu'>
				<a id='view' href='?" . parent::$LIST ."=" . parent::$VIEW . "&name=" 
					. $listName . "' title='VIEW'></a>
			</div>
			<form action='?" . parent::$LIST . "=" . parent::$VIEW . "&name=" . $listName 
				. "' method='post' enctype='multipart/form-data'>
				<input type='submit' id='saveAndView' name='" . parent::$SAVE_TEXT . "' value='' />
				<textarea id='editableList' name='". parent::$PLAIN_TEXT ."' 
				placeholder='Add some tasks...'>" . $listContents . "</textarea>
			</form>
			</div>
		</div>";

		return $html;
	}
	
	/**
	 * Display default view
	 * @return [type] [description]
	 */
	public function getDefaultPage() {
		$html = "
		<div id='taskmortLogo'>&nbsp;</div>";
		return $html;
	}	
}