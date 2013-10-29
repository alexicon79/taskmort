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
					<input type='text' size='20' name='" . parent::$NEW_LIST_NAME . "' id='listName' value='' />
					<input type='submit' name='" . parent::$CREATE_LIST . "'  value='Save' />
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
				$html .= "<li><a href='?" . parent::$LIST ."=" . parent::$VIEW . "&name=" . $listName . "'>". $listName . "</a>";
				$html .= "<a href='?" . parent::$LIST . "=" . parent::$DELETE . "&name=" . $listName ."' class='deleteList'>X</a></li>";
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
			<a id='addItem' href=''>+</a>
			<a id='edit' href='?" . parent::$LIST ."=" . parent::$EDIT . "&name=" . $listName . "'>EDIT</a>
		</div>
		<form action='?" . parent::$LIST ."=" . parent::$VIEW . "&name=" . $listName . "' method='post' enctype='multipart/form-data'>
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
					<input type='submit' name='" . parent::$SAVE_LIST . "' value='spara' />
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
		<div class='listName'>$listName
			<a id='view' href='?" . parent::$LIST ."=" . parent::$VIEW . "&name=" . $listName . "'>VIEW</a>
		</div>
			<form action='?" . parent::$LIST . "=" . parent::$EDIT . "&name=" . $listName . "' method='post' enctype='multipart/form-data'>
				<textarea id='editableList' name='plainText' 
				placeholder='Add some tasks...'>" . $listContents . "</textarea>
				<input type='submit' id='listSaveButton' name='" . parent::$SAVE_RAW . "' value='Save' />
			</form>
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