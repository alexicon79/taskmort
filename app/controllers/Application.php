<?php

namespace app\controller;

require_once("../app/views/MainView.php");
require_once("../app/views/ClientRequestObserver.php");
require_once("../app/views/ListView.php");
require_once("../app/models/ListDAL.php");
require_once("../app/controllers/ListController.php");
require_once("../app/models/TaskList.php");

require_once("../app/login/models/LoginModel.php");
require_once("../app/login/views/LoginView.php");
require_once("../app/login/controllers/LoginController.php");
require_once("../app/login/views/LoginObserver.php");
require_once("../app/login/models/TempAccount.php");


class Application {

	private $mainView;
	private $clientRequestObserver;
	private $listDAL;
	private $listController;
	private $listView;
	private $taskList;

	/**
	 * @var app\login\model\LoginModel
	 */
	private $loginModel;

	/**
	 * @var app\login\view\LoginView
	 */
	private $loginView;

	/**
	 * @var app\login\model\TempAccount
	 */
	private $tempAccount;

	/**
	 * @var app\login\view\LoginObserver
	 */
	private $loginObserver;

	/**
	 * @var app\login\controller\LoginController
	 */
	private $loginController;



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

		$this->tempAccount = new \app\login\model\TempAccount();
		$this->loginModel = new  \app\login\model\LoginModel($this->tempAccount);
		$this->loginView = new \app\login\view\LoginView();
		$this->loginObserver = new \app\login\view\LoginObserver($this->loginModel);

		$this->loginController = new \app\login\controller\LoginController( $this->loginView, 
																 			$this->loginModel, 
																 			$this->tempAccount, 
																 			$this->loginObserver);

	}

	public function invoke() {

		session_start();

		$loginResult = $this->loginController->doLoginAttempt();

		if(is_null($loginResult)) {
			$page = $this->listController->handleLists();
		} else {
			$page = new \shared\view\Page("TASKMÔRT | Login", $loginResult);
		}
		return $page;
 	}

	public function getAppStylesheet() {
		return $this->mainView->getStyleSheet();
	}

	public function getAppJavaScript() {
		return $this->mainView->getJavaScript();
	}
}