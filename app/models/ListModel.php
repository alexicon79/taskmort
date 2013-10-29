<?php

namespace app\model;

require_once("../app/models/ListObject.php");

class ListModel {

	private $newFileName;
	private $listObject;
	private static $DEFAULT_FILE = "default.txt";
	private static $FILE_TYPE = ".txt";
	private static $INCLUDE_PATH = "../data/";

	public function __construct() {
		$this->listObject = new \app\model\ListObject();
	}

	public function getFileContent($selectedListName) {

		set_include_path(self::$INCLUDE_PATH);
		
		if ($this->checkIfFileExists($selectedListName)) {
			$fileContents = file_get_contents($selectedListName, true);
			return $fileContents;
		} else {
			throw new \Exception("File Not Found", 1);
		}
	}

	public function getMarkedUpFileContent($selectedListName) {
		$rawFileContent = $this->getFileContent($selectedListName);

		$items = explode("\n", $rawFileContent);
		$items = array_filter($items);

		$this->listObject->addAllItems($items);

		$markedUpObjects = array();

		foreach ($items as $string) {
			$markedUpObjects = $this->extractListObjectType($string);
		}

		return $markedUpObjects;
	}

	public function extractListObjectType($string) {

		$string = ltrim($string);
		$string = rtrim($string);

		$taskPattern = "/^(- ([^\@\n]+).+)/i";
		$donePattern = "/- (.+@done)/i";
		$projectPattern = "/^(?!-)(.+:)$/i";
		$notePattern = "/^(?!\-).*(?<!\:)$/i";

		if (preg_match($taskPattern, $string)) {
			// $string = $string . " [TASK]";
			$this->listObject->addTask($string);
		}
		
		if (preg_match($donePattern, $string)) {
			// $string = $string . " [DONE]";
			$this->listObject->addCompletedTask($string);
		}
		
		if (preg_match($notePattern, $string)) {
			// $string = $string . " [NOTE]";
			$this->listObject->addNote($string);
		}

		if (preg_match($projectPattern, $string)) {
			// $string = $string . " [PROJECT]";
			$this->listObject->addProject($string);
		}

		return $this->listObject;
	}

	public function convertToPlainText($contentArray) {

		$text = "";

		foreach ($contentArray as $string) {
			$string = strip_tags($string);
			$text .= $string . "\n";
		}
		return $text;
	} 

	public function createListFile($listName) {
		$cleanListName = self::cleanUpListName($listName);
		$this->newFileName = $cleanListName . self::$FILE_TYPE;
		
		$newFileHandle = fopen(self::$INCLUDE_PATH . $this->newFileName, 'w') or die("can't create file");
		return $newFileHandle;
	}

	public function saveList($listName, $listContent) {
		$saveFileHandle = fopen(self::$INCLUDE_PATH . $listName, 'w') or die ("can't save file");
		self::writeToFile($saveFileHandle, $listContent);
	}

	public function deleteList($listName) {
		unlink(self::$INCLUDE_PATH . $listName);
		header('Location: ?list=browse');
	}

	public function getNewListName() {
		return $this->newFileName;
	}

	public function checkIfFileExists($selectedListName) {
		
		$allLists = $this->getAllLists();

		foreach ($allLists as $validListName) {
			if ($validListName === $selectedListName) {
				return true;
			}
		} return false;
	}

	public function writeToFile($fileHandle, $fileContents) {
		fwrite($fileHandle, $fileContents);
		fclose($fileHandle);
	}

	public function getAllLists() {
		$directory = self::$INCLUDE_PATH;
		$listArray = scandir($directory);
		
		return $listArray;
	}
	
	public function getFileDirectoryPath() {
		return self::$INCLUDE_PATH;
	}

	/**
	 * [cleanUpListName description]
	 * @param  [type] $clientListName [description]
	 * @return [type]                 [description]
	 */
	public function cleanUpListName($listName) {
		
		$listName = ltrim($listName);
		$listName = rtrim($listName);
		$listName = strip_tags($listName);
		$listName = mb_strtolower($listName, 'UTF-8');
		$listName = str_replace(array('å', 'ä', 'ö', ' '), array('a', 'a', 'o', '-'), $listName);
		$listName = preg_replace("/[^a-z0-9-]/i", "", $listName);
		$listName = preg_replace("/[-]\+/", "\-", $listName);

		$cleanListName = $listName;

		return $cleanListName;
	}
}