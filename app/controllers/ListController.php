<?php

namespace app\controller;

/**
 * Handles interaction with task lists
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class ListController {

	/**
	 * @var app\model\ListDAL $listDAL
	 */
	private $listDAL;

	/**
	 * @var app\view\ListView $listView
	 */
	private $listView;

	/**
	 * @var app\view\ClientRequestObserver $clientRequestObserver
	 */
	private $clientRequest;

	/**
	 * @var app\view\MainView $mainView
	 */
	private $mainView;

	/**
	 * @var app\model\TaskList $taskList
	 */
	private $taskList;
	
	public function __construct(\app\model\ListDAL $listDAL,
								\app\view\ListView $listView,
								\app\view\ClientRequestObserver $clientRequest,
								\app\view\MainView $mainView,
								\app\model\TaskList $taskList){
		
		$this->listDAL = $listDAL;
		$this->listView = $listView;
		$this->clientRequest = $clientRequest;
		$this->mainView = $mainView;
		$this->taskList = $taskList;
	}

	/**
	 * Controlling interaction with task lists
	 * @return \shared\view\Page Object containing HTML (title + body)
	 */
	public function handleLists() {
		if ($this->clientRequest->wantsToCreateNewList()){
			return $this->displayNewListPrompt();
		}
		elseif ($this->clientRequest->wantsToSaveList()){
			$listName = $this->clientRequest->getSelectedListName();
			return $this->saveList($listName);
		}
		elseif ($this->clientRequest->wantsToSavePlainText()){
			$listName = $this->clientRequest->getSelectedListName();
			return $this->saveList($listName);
		}
		elseif ($this->clientRequest->wantsToEditList()){
			$listName = $this->clientRequest->getSelectedListName();
			return $this->editList($listName);
		}
		elseif ($this->clientRequest->wantsToViewList()){
			$listName = $this->clientRequest->getSelectedListName();
			return $this->viewList($listName);
		}
		elseif ($this->clientRequest->newListHasBeenSubmitted()) {
			return $this->createList();
		}
		elseif ($this->clientRequest->wantsToBrowseLists()) {
			return $this->showLists();
		}
		elseif ($this->clientRequest->wantsToDeleteList()) {
			$listName = $this->clientRequest->getSelectedListName();
			return $this->deleteList($listName);
		}
		else {
			return $this->mainView->getDefaultPage();
		}
	}
	
	/**
	 * Displays input field to let user enter name of new list
	 * @return \shared\view\Page - HTML
	 */
	public function displayNewListPrompt() {
		return $this->mainView->getNewListPage();
	}
	
	/**
	 * Creates a new list
	 * @return \shared\view\Page - HTML
	 */
	public function createList() {
		try {
			$newFileHandle = $this->listDAL->createListFile($this->clientRequest->getSubmittedListName());
			$newListName = $this->listDAL->getNewListName();
			$this->listDAL->writeToFile($newFileHandle, "");
			return $this->viewList($newListName);
		} catch (\Exception $e) {
			return $this->mainView->getDefaultPage();
		}
	}
	
	/**
	 * Shows all lists
	 * @return \shared\view\Page - HTML
	 */
	public function showLists() {
		$listArray = $this->listDAL->getAllLists();
		$directoryPath = $this->listDAL->getFileDirectoryPath();
		return $this->mainView->getAllListsPage($listArray, $directoryPath);
	}
	
	/**
	 * Saves list items as plain text
	 * @param  string $listName Name of list to save
	 * @return \shared\view\Page - HTML
	 */
	public function saveList($listName) {
		try {
			if ($this->clientRequest->wantsToSavePlainText()) {
				$content = $this->clientRequest->getSubmittedContent();
				$this->listDAL->saveList($listName, $content);
				return $this->viewList($listName);

			} elseif ($this->clientRequest->wantsToSaveList()) {
				$submittedContent = $this->clientRequest->getSubmittedContent();
				$content = $this->listDAL->convertToPlainText($submittedContent);
				$this->listDAL->saveList($listName, $content);
				return $this->viewList($listName);
			}
			return $this->viewList($listName);
		} catch (\Exception $e) {
			return $this->mainView->getDefaultPage();
		}
	}

	/**
	 * Deletes list
	 * @param  string $listName Name of list to delete
	 * @return \shared\view\Page - HTML
	 */
	public function deleteList($listName) {
		try {
			$this->listDAL->deleteList($listName);
			return $this->showLists();
		} catch (\Exception $e) {
			return $this->mainView->getDefaultPage();
		}
	}

	/**
	 * Lets user edit list in plain text mode
	 * @param  string $listName Name of list to edit
	 * @return \shared\view\Page - HTML
	 */
	public function editList($listName) {
		try {
			$listContent = $this->listDAL->getFileContent($listName);
			return $this->mainView->getEditListPage($listName, $listContent);
		} catch (\Exception $e) {
			return $this->mainView->getDefaultPage();
		}
	}

	/**
	 * Lets user view (and edit) list in fancy list mode
	 * @param  string $listName Name of list to view
	 * @return \shared\view\Page - HTML
	 */
	public function viewList($listName) {
		try {
			$listItems = $this->taskList->getTaskList($listName);
			if (empty($listItems)){
				$listItems = new \app\model\TaskList();
			}
			return $this->mainView->getViewListPage($listName, $listItems);
		} catch (\Exception $e) {
			return $this->mainView->getDefaultPage();
		}
	}
}