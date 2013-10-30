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

/**
 * Sets up and runs the application
 * @author Alexander Hall
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Application {
	
	/**
	 * @var app\controller\ListController $listController
	 */
	private $listController;

	/**
	 * @var app\model\ListDAL $listDAL
	 */
	private $listDAL;
	
	/**
	 * @var app\model\TaskList $taskList
	 */
	private $taskList;

	/**
	 * @var app\view\MainView $mainView
	 */
	private $mainView;
	
	/**
	 * @var app\view\ClientRequestObserver $clientRequestObserver
	 */
	private $clientRequestObserver;
	
	/**
	 * @var app\view\ListView $listView
	 */
	private $listView;

	/**
	 * @var app\login\controller\LoginController $loginController
	 */
	private $loginController;
	
	/**
	 * @var app\login\model\LoginModel $loginModel
	 */
	private $loginModel;

	/**
	 * @var app\login\view\LoginView $loginView
	 */
	private $loginView;

	/**
	 * @var app\login\model\TempAccount $tempAccount
	 */
	private $tempAccount;

	/**
	 * @var app\login\view\LoginObserver $loginObserver
	 */
	private $loginObserver;

	/**
	 * __construct Everything in it's right place...
	 */
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

	/**
	 * Invokes application
	 * @return \shared\view\Page Object containing HTML (title + body)
	 */
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

	/**
	 * Get application CSS
	 * @return string Path to stylesheet-file
	 */
	public function getAppStylesheet() {
		return $this->mainView->getStyleSheet();
	}

	/**
	 * Get application JavaScript
	 * @return string Path to JavaScript-file
	 */
	public function getAppJavaScript() {
		return $this->mainView->getJavaScript();
	}
}