<?php

namespace app\controller;

require_once("../app/views/ApplicationView.php");
require_once("../app/views/ClientRequestObserver.php");


class Application {

	private $applicationView;
	private $clientRequest;

	public function __construct() {
		/* baka ihop applikationen */
		$this->applicationView = new \app\view\ApplicationView();
		$this->clientRequest = new \app\view\ClientRequestObserver();
	}

	public function invoke() {

		if ($this->clientRequest->createNewList()){
			return $this->applicationView->getNewListPage();
		}
		return $this->applicationView->getMainPage();
	}

	public function getAppStylesheet() {
		return $this->applicationView->getStyleSheet();
	}
}