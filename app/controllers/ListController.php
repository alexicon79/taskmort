<?php

namespace app\controller;

class ListController {

	private $listModel;
	private $listView;
	private $clientRequest;
	private $mainView;
	
	public function __construct(\app\model\ListModel $listModel,
								\app\view\ListView $listView,
								\app\view\ClientRequestObserver $clientRequest,
								\app\view\MainView $mainView){
		
		$this->listModel = $listModel;
		$this->listView = $listView;
		$this->clientRequest = $clientRequest;
		$this->mainView = $mainView;
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
		else {
			return $this->mainView->getDefaultPage();
		}
	}

	public function displayNewListPrompt() {
		return $this->mainView->getNewListPage();
	}

	public function createList() {
		$newFileHandle = $this->listModel->createListFile($this->clientRequest->getSubmittedListName());
		$newListName = $this->listModel->getNewListName();
		$this->listModel->writeToFile($newFileHandle, "Add some tasks...");
		return $this->editList($newListName);
	}

	public function showLists() {
		$listArray = $this->listModel->getAllLists();
		$directoryPath = $this->listModel->getFileDirectoryPath();
		return $this->mainView->getAllListsPage($listArray, $directoryPath);
	}

	public function saveList($listName) {
		if ($this->clientRequest->wantsToSavePlainText()) {
			$content = $this->clientRequest->getSubmittedContent();
			$this->listModel->saveList($listName, $content);
			return $this->editList($listName);

		} elseif ($this->clientRequest->wantsToSaveList()) {
			$submittedContent = $this->clientRequest->getSubmittedContent();
			$content = $this->listModel->convertToPlainText($submittedContent);
			$this->listModel->saveList($listName, $content);
			return $this->viewList($listName);
		}
		return $this->viewList($listName);
	}

	public function editList($listName) {
		try {
			$listContent = $this->listModel->getFileContent($listName);
			return $this->mainView->getEditListPage($listName, $listContent);
		} catch (\Exception $e) {
			return $this->mainView->getDefaultPage();
		}
	}

	public function viewList($listName) {
		try {
			$listItems = $this->listModel->getMarkedUpFileContent($listName);
			return $this->mainView->getViewListPage($listName, $listItems);
		} catch (\Exception $e) {
			return $this->mainView->getDefaultPage();
		}
	}
}