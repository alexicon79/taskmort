<?php

namespace app\model;

/**
 * Handles rules for lists and files
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class ListDAL {
	
	/**
	 * @var string Name of newly created file
	 */
	private $newFileName;

	/**
	 * @var string Default file name
	 */
	private static $DEFAULT_FILE = "default.txt";

	/**
	 * @var string Valid file extension
	 */
	private static $FILE_TYPE = ".txt";

	/**
	 * @var string Path to directory containing lists
	 */
	protected static $INCLUDE_PATH = "../data/";

	/**
	 * Gets file content as plain text
	 * @param  string $selectedListName Name of selected list
	 * @throws exception If file not found
	 * @return string
	 */
	public function getFileContent($selectedListName) {

		set_include_path(self::$INCLUDE_PATH);
		
		if ($this->checkIfFileExists($selectedListName)) {
			$fileContents = file_get_contents($selectedListName, true);
			return $fileContents;
		} else {
			throw new \Exception("File Not Found", 1);
		}
	}

	/**
	 * Creates valid list file
	 * @param  string $listName Name of list to create
	 * @return [file pointer resource] $newFileHandle
	 */
	public function createListFile($listName) {
		$cleanListName = self::cleanUpListName($listName);

		$this->newFileName = $cleanListName . self::$FILE_TYPE;

		$appendIndex = 0;

		// if filename exists append number to filename
		while ($this->checkIfFileExists($this->newFileName)) {
			$appendIndex++;
			$this->newFileName = $cleanListName . "-" . $appendIndex . self::$FILE_TYPE;
		}
		
		$newFileHandle = fopen(self::$INCLUDE_PATH . $this->newFileName, 'w') or die("can't create file");
		return $newFileHandle;
	}

	/**
	 * Saves list
 	 * @param string $listName Name of list to save
	 * @param string $listContent Content as plain text
	 * @return null
	 */
	public function saveList($listName, $listContent) {
		$saveFileHandle = fopen(self::$INCLUDE_PATH . $listName, 'w') or die ("can't save file");
		self::writeToFile($saveFileHandle, $listContent);
	}

	/**
	 * Writes content to file, adds default content if empty
	 * @param  [file pointer resource] $fileHandle
	 * @param  string $fileContents Content to write to file
	 * @return null
	 */
	public function writeToFile($fileHandle, $fileContents) {
		if (empty($fileContents)) {
			$fileContents = "Default:\n- Add some tasks...";
		}
		fwrite($fileHandle, $fileContents);
		fclose($fileHandle);
	}

	/**
	 * Deletes list
	 * @param  string $listName Name of list to delete
	 * @return null
	 */
	public function deleteList($listName) {
		unlink(self::$INCLUDE_PATH . $listName);
		header('Location: ?list=browse');
	}
	
	/**
	 * @return string Newly created list name
	 */
	public function getNewListName() {
		return $this->newFileName;
	}

	/**
	 * Checks if file name already exists
	 * @param  string $selectedListName Name to check
	 * @return bool
	 */
	public function checkIfFileExists($selectedListName) {
		
		$allLists = $this->getAllLists();

		foreach ($allLists as $validListName) {
			if ($validListName === $selectedListName) {
				return true;
			}
		} return false;
	}

	/**
	 * Returns array with all lists
	 * @return array Lists in directory
	 */
	public function getAllLists() {
		$directory = self::$INCLUDE_PATH;
		$listArray = scandir($directory);
		
		return $listArray;
	}
	
	/**
	 * Returns path to directory containing lists
	 * @return string Path to directory containing lists
	 */
	public function getFileDirectoryPath() {
		return self::$INCLUDE_PATH;
	}

	/**
	 * Converts array of list items to plain text
	 * @param  array $contentArray Array of strings
	 * @return string $text Content as plain text
	 */
	public function convertToPlainText($contentArray) {

		$text = "";

		foreach ($contentArray as $string) {
			$string = strip_tags($string);
			$text .= $string . "\n";
		}
		return $text;
	}

	/**
	 * Cleans up list name
	 * @param  string $listName List name to clean up
	 * @return string $cleanListName Clean list name
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