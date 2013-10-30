<?php

namespace app\view;

require_once("../app/views/ClientRequestObserver.php");

class ListView extends ClientRequestObserver {

	private static $REGEX_TASK = "/^(- ([^\@\n]+).+)/i";
    private static $REGEX_DONE = "/- (.+@done)/i";
	private static $REGEX_PROJECT = "/^(?!-)(.+:)$/i";
	private static $REGEX_NOTE = "/^(?!\-).*(?<!\:)$/i";

	public function getNewListPrompt() {
		
		$html = "
		<div id='contentWrapper'>
			<div id='newListPrompt'>
				<form action='?" . parent::$LIST . "=" . parent::$CREATE . "' method='post' enctype='multipart/form-data'>
					<input type='text' size='20' name='" . parent::$NEW_LIST_NAME . "' id='listName' placeholder='New List...' value='' />
					<input type='submit' name='" . parent::$CREATE_LIST . "'  value='Create List' />
				</form>
			</div>
		</div>";

		return $html;
	}

	public function getAllLists($listArray, $directoryPath){
		
		$html = "<div id='contentWrapper'><ul class='listBrowser'>";
		
		foreach ($listArray as $listName) {
			if ($listName == "." || $listName == ".."){
				$html .= "";
			} else {
				$html .= "<li><a href='?" . parent::$LIST ."=" . parent::$VIEW . "&name=" . $listName . "' class='browseFile'>". $listName . "</a>";
				$html .= "<a href='?" . parent::$LIST . "=" . parent::$DELETE . "&name=" . $listName ."' class='deleteList'>&times;</a></li>";
			}
		}
		
		$html .= "</ul></div>";

		return $html;
	}

	public function getViewList($listName, $listItems){
		
		$html = "
		<div id='contentWrapper'>
		<div class='listName'>$listName</div>
		<div class='viewListWrapper'>
		<div class='listMenu'>
			<a id='edit' href='?" . parent::$LIST ."=" . parent::$EDIT . "&name=" . $listName . "' title='EDIT PLAIN TEXT'></a>
			<a id='addItem' href='' title='ADD ITEM'>+</a>
		</div>
		<form action='?" . parent::$LIST ."=" . parent::$VIEW . "&name=" . $listName . "' method='post' enctype='multipart/form-data'>
		<input id='viewSaveButton' type='submit' name='" . parent::$SAVE_LIST . "' value='' />
		<ul class='listView'>";
		
		foreach ($listItems->getAllItems() as $item) {
			$item = trim($item);

			if (preg_match(self::$REGEX_NOTE, $item)) {
				$html .= "<li class='item note'><span class='visible'>" . $item . "</span>";
				$html .= "<input type='text' class='hidden editableNote' name='item[]' value='$item'><span class='removeItem_note'>&#10005;</span></li>";
			}

			if (preg_match(self::$REGEX_PROJECT, $item)) {
				$html .= "<li class='item project'><span class='visible'>" . $item . "</span>";
				$html .= "<input type='text' class='hidden editableProject' name='item[]' value='$item'></li>";
			}
			if (preg_match(self::$REGEX_TASK, $item)) {
				$html .= "<li class='item task'><span class='visible'>" . $item . "</span>";
				$html .= "<input type='text' class='hidden editableTask' name='item[]' value='$item'><span class='removeItem'>&#10005;</span></li>";
			}

		}
		$html .= "</ul>
					</form>
					</div></div>";
		return $html;
	}

	public function getEditableList($listName, $listContents) {

		if (empty($listContents)) {
			$listContents = "Add some tasks...";
		}

		$html = "
		<div id='contentWrapper'>
		<div class='listName'>$listName</div>
		<div class='editListWrapper'>
			<div class='listMenu'>
				<a id='view' href='?" . parent::$LIST ."=" . parent::$VIEW . "&name=" . $listName . "' title='VIEW'></a>
			</div>
			<form action='?" . parent::$LIST . "=" . parent::$VIEW . "&name=" . $listName . "' method='post' enctype='multipart/form-data'>
				<input type='submit' id='saveAndView' name='" . parent::$SAVE_TEXT . "' value='' />
				<textarea id='editableList' name='plainText' 
				placeholder='Add some tasks...'>" . $listContents . "</textarea>
			</form>
			</div>
		</div>";

		return $html;
	}

	public function getDefaultPage() {
		$html = "
		<div id='taskmortLogo'>&nbsp;</div>";
		return $html;
	}

	public function getNewContent() {
		
		$newLine = "\n";
		$test .= $POST['item'];
		dd($test);

		return "emtpy";
	}
}