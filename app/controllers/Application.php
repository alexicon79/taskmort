<?php

namespace app\controller;

require_once("../app/views/MainView.php");
require_once("../app/views/ClientRequestObserver.php");
require_once("../app/views/ListView.php");
require_once("../app/models/ListDAL.php");
require_once("../app/controllers/ListController.php");
require_once("../app/models/TaskList.php");


class Application {

	private $mainView;
	private $clientRequestObserver;
	private $listDAL;
	private $listController;
	private $listView;
	private $taskList;

	public function __construct() {
		$this->mainView = new \app\view\MainView();
		$this->clientRequestObserver = new \app\view\ClientRequestObserver();
		$this->listDAL = new \app\model\ListDAL();
		$this->listView = new \app\view\ListView();
		$this->taskList = new \app\model\TaskList();

		$this->listController = new \app\controller\ListController( $this->listDAL, 
																 	$this->listView, 
																 	$this->clientRequestObserver,
																 	$this->mainView,
																 	$this->taskList);
	}

	public function invoke() {

		$page = $this->listController->handleLists();

		return $page;
 	}

	public function getAppStylesheet() {
		return $this->mainView->getStyleSheet();
	}

	public function getAppJavaScript() {
		return $this->mainView->getJavaScript();
	}
}