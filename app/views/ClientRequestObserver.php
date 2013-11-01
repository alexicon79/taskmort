<?php

namespace app\view;

/**
 * Handles rules for client interaction with lists
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class ClientRequestObserver {
	
	/**
	 * @var string $LIST Get variable
	 */
	protected static $LIST = "list";
	
	/**
	 * @var string $NEW Get variable
	 */
	protected static $NEW = "new";

	/**
	 * @var string $EDIT Get variable
	 */
	protected static $EDIT = "edit";

	/**
	 * @var string $VIEW Get variable
	 */
	protected static $VIEW = "view";

	/**
	 * @var string $DELETE Get variable
	 */
	protected static $DELETE = "delete";

	/**
	 * @var string $BROWSE Get variable
	 */
	protected static $BROWSE = "browse";

	/**
	 * @var string $CREATE Get variable
	 */
	protected static $CREATE = "create";

	/**
	 * @var string $LIST_NAME Post variable
	 */
	protected static $LIST_NAME = "name";

	/**
	 * @var string $NEW_LIST_NAME Post variable
	 */
	protected static $NEW_LIST_NAME = "newListName";

	/**
	 * @var string $CREATE_LIST Post variable
	 */
	protected static $CREATE_LIST = "createList";

	/**
	 * @var string $SAVE_LIST Post variable
	 */
	protected static $SAVE_LIST = "saveList";

	/**
	 * @var string $SAVE_TEXT Post variable
	 */
	protected static $SAVE_TEXT = "savePlainText";
	
	/**
	 * @var string $SAVE_DROPBOX Post variable;
	 */
	protected static $SAVE_DROPBOX = "saveToDropbox";

	/**
	 * Checks if user wants to create new list
	 * @return bool
	 */
	public function wantsToCreateNewList() {
		if(isset ($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$NEW) {
			return true;
		}
	}

	/**
	 * Checks if user wants to edit list
	 * @return bool
	 */
	public function wantsToEditList() {
		if(isset ($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$EDIT) {
			return true;
		} return false;
	}

	/**
	 * Checks if user wants to view list
	 * @return bool
	 */
	public function wantsToViewList() {
		if (isset($_POST[self::$SAVE_LIST]) == false) {
			if(isset ($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$VIEW) {
				return true;
			}
		} return false;
	}
	
	/**
	 * Checks if user wants to save list
	 * @return bool
	 */
	public function wantsToSaveList() {
		if (isset($_POST[self::$SAVE_LIST])) {
			return true;
		} return false;
	}
	
	/**
	 * Checks if user wants to save list as plain text
	 * @return bool
	 */
	public function wantsToSavePlainText() {
		if (isset($_POST[self::$SAVE_TEXT])) {
			return true;
		} return false;
	}

	/**
	 * Checks if user wants to save list to Dropbox
	 * @return bool
	 */
	public function wantsToSaveToDropbox() {
		if (isset($_POST[self::$SAVE_LIST]) && isset($_POST[self::$SAVE_DROPBOX])) {
			return true;
		} return false;
	}
		
	/**
	 * Checks if user wants to delete list
	 * @return bool
	 */
	public function wantsToDeleteList() {
		if (isset($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$DELETE) {
			return true;
		} return false;
	}
	
	/**
	 * Checks if user wants to browse all lists
	 * @return bool
	 */
	public function wantsToBrowseLists() {
		if(isset ($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$BROWSE) {
			return true;
		} return false;
	}
	
	/**
	 * Checks if new list has been submitted
	 * @return bool
	 */
	public function newListHasBeenSubmitted() {
		if (isset($_POST[self::$CREATE_LIST])) {
			return true;
		} return false;
	}

	/**
	 * Gets selected list name
	 * @return string Selected list name
	 */
	public function getSelectedListName() {
		if(isset ($_GET[self::$LIST_NAME])) { 
			return $_GET[self::$LIST_NAME];
		} else {
			return "default.txt";
		}
	}

	/**
	 * Gets submitted list name
	 * @return string Submitted list name
	 */
	public function getSubmittedListName(){
		$name = "untitled";
		if (isset($_POST[self::$NEW_LIST_NAME])) {
			$name = $_POST[self::$NEW_LIST_NAME];
		}
		return $name;
	}

	/**
	 * Gets submitted list content
	 * @return array Content in $_POST as array of strings
	 * @return string Content in $_POST as string
	 */
	public function getSubmittedContent(){
		if($this->wantsToSaveList()) {
			$newLine = "\n";
			$contentArray = $_POST['item'];
			return $contentArray;
		} elseif ($this->wantsToSavePlainText()) {
			$content = $_POST['plainText'];
			return $content;
		}
	}
}