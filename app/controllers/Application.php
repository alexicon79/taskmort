<?php

namespace app\controller;

require_once("../app/views/MainView.php");
require_once("../app/views/ClientRequestObserver.php");
require_once("../app/views/ListView.php");
require_once("../app/models/ListModel.php");
require_once("../app/controllers/ListController.php");

class Application {

	private $mainView;
	private $clientRequestObserver;
	private $listModel;
	private $listController;
	private $listView;

	public function __construct() {
		/* baka ihop applikationen */
		$this->mainView = new \app\view\MainView();
		$this->clientRequestObserver = new \app\view\ClientRequestObserver();

		$this->listModel = new \app\model\ListModel();
		$this->listView = new \app\view\ListView();

		$this->listController = new \app\controller\ListController( $this->listModel, 
																 	$this->listView, 
																 	$this->clientRequestObserver,
																 	$this->mainView);
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