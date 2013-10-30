<?php

namespace app\controller;

class ListController {

	private $listDAL;
	private $listView;
	private $clientRequest;
	private $mainView;
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

	public function displayNewListPrompt() {
		return $this->mainView->getNewListPage();
	}

	public function createList() {
		$newFileHandle = $this->listDAL->createListFile($this->clientRequest->getSubmittedListName());
		$newListName = $this->listDAL->getNewListName();
		$this->listDAL->writeToFile($newFileHandle, "");
		return $this->viewList($newListName);
	}

	public function showLists() {
		$listArray = $this->listDAL->getAllLists();
		$directoryPath = $this->listDAL->getFileDirectoryPath();
		return $this->mainView->getAllListsPage($listArray, $directoryPath);
	}

	public function saveList($listName) {
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
	}

	public function deleteList($listName) {
		$this->listDAL->deleteList($listName);
		return $this->showLists();
	}

	public function editList($listName) {
		try {
			$listContent = $this->listDAL->getFileContent($listName);
			return $this->mainView->getEditListPage($listName, $listContent);
		} catch (\Exception $e) {
			return $this->mainView->getDefaultPage();
		}
	}

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