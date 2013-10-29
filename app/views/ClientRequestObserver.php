<?php

namespace app\view;

class ClientRequestObserver {

	protected static $LIST = "list";
	protected static $NEW = "new";
	protected static $EDIT = "edit";
	protected static $VIEW = "view";
	protected static $DELETE = "delete";
	protected static $BROWSE = "browse";
	protected static $CREATE = "create";
	protected static $LIST_NAME = "name";

	protected static $NEW_LIST_NAME = "newListName";
	protected static $CREATE_LIST = "createList";
	protected static $SAVE_LIST = "saveList";
	protected static $SAVE_RAW = "saveRawContent";

	
	public function wantsToCreateNewList() {
		if(isset ($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$NEW) {
			return true;
		}
	}

	public function wantsToEditList() {

		if(isset ($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$EDIT) {
			return true;
		}
	}

	public function wantsToViewList() {
		if (isset($_POST[self::$SAVE_LIST]) == false) {
			if(isset ($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$VIEW) {
				return true;
			}
		}
	}

	public function wantsToSaveList() {
		if (isset($_POST[self::$SAVE_LIST])) {
			return true;
		} return false;
	}

	public function wantsToSavePlainText() {
		if (isset($_POST[self::$SAVE_RAW])) {
			return true;
		} return false;
	}

	public function getSelectedListName() {
		if(isset ($_GET[self::$LIST_NAME])) { 
			return $_GET[self::$LIST_NAME];
		} else {
			return "default.txt";
		}
	}

	public function wantsToDeleteList() {
		if (isset($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$DELETE) {
			return true;
		} return false;
	}

	public function wantsToBrowseLists() {
		if(isset ($_GET[self::$LIST]) && $_GET[self::$LIST] == self::$BROWSE) {
			return true;
		}
	}

	public function newListHasBeenSubmitted() {
		if (isset($_POST[self::$CREATE_LIST])) {
			return true;
		} return false;
	}

	public function getSubmittedListName(){
		$name = "untitled";
		if (isset($_POST[self::$NEW_LIST_NAME])) {
			$name = $_POST[self::$NEW_LIST_NAME];
		}
		return $name;
	}

	/**
	 * [getSubmittedContent description]
	 * @return array , with content in $_POST as strings
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