<?php

namespace app\login\controller;

/**
 * Handles interaction with login form
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class LoginController {

	/**
	 * @var \view\LoginView
	 */
	private $loginView;

	/**
	 * @var \model\LoginModel
	 */
	private $loginModel;

	/**
	 * @var \model\TempAccount
	 */
	private $tempAccount;

	/**
	 * @var \view\LoginObserver
	 */
	private $loginObserver;

	/**
	 * @var string , User feedback
	 */
	private $message;

	/**
	 * @var string , Username provided by user/client
	 */
	private $clientUserName;

	/**
	 * @var string , Password provided by user/client
	 */
	private $clientPassword;

	public function __construct(\app\login\view\LoginView $loginView, 
								\app\login\model\LoginModel $loginModel,
								\app\login\model\TempAccount $tempAccount,
								\app\login\view\LoginObserver $loginObserver) {

								$this->loginView = $loginView;
								$this->loginModel = $loginModel;
								$this->tempAccount = $tempAccount;
								$this->loginObserver = $loginObserver;
	}

	/**
	 * Checks if user is logged in or not and returns appropriate HTML
	 * 
	 * @return string $loginFormHTML HTML with login-form, if user is logged out
	 * @return string $protectedPageHTML HTML with protected page, if user is logged in
	 */
	public function doLoginAttempt() {

		try {
			if ($this->loginObserver->UserIsAuthenticated()){

				$this->handleAuthenticationMode();

				if ($this->loginObserver->userWantsToStayLoggedIn()) {
					$this->handleCookie();
				}

				$protectedPageHTML = $this->showProtectedPage($this->message);

				if ($this->loginObserver->userWantsToLogOut()) {
					$loginFormHTML = $this->handleLogOut($this->loginView->getLogOutMessage());
					header("Location: ../public/");
					return $loginFormHTML;
				}
				
				return null;

			} else {
				
				if ($this->loginObserver->formHasBeenSubmitted()){
					$this->validateUserInput();
				}

				return $this->loginView->renderForm($this->message, $this->clientUserName);;
			}
		} catch (\Exception $cookieFail) {
			$this->loginObserver->clearCookie();
			$loginFormHTML = $this->loginView->renderForm($cookieFail->getMessage(), $this->clientUserName);
			return $loginFormHTML;
		}
	}
	
	/**
	 * Sets relevant confirmation message and saves session when necessary
	 * @return null
	 */
	private function handleAuthenticationMode() {

		switch ($this->loginObserver->AuthenticationMode()) {

			case \app\login\view\LoginObserver::FORM_AUTHENTICATION:
			$this->message = $this->loginView->getConfirmationMessage();
			$this->loginModel->saveSession();
			break;
			
			case \app\login\view\LoginObserver::SESSION_AUTHENTICATION:
			$this->message = $this->loginView->getConfirmationMessage();
			break;

			case \app\login\view\LoginObserver::COOKIE_AUTHENTICATION:
			$this->message = $this->loginView->getConfirmationMessage();
			$this->loginModel->saveSession();				
			break;

			default:
			break;
		}
	}

	/**
	 * Generates cookie and sets relevant confirmation message
	 * @return null
	 */
	private function handleCookie() {
		$this->message = $this->loginView->getCookieMessage();
		$this->loginObserver->generateCookie();
	}

	/**
	 * Logs out user, clears cookies/session and returns HTML with login form
	 * @param  string $logOutMessage Confirmation message
	 * @return string HTML
	 */
	private function handleLogOut($logOutMessage) {
		$this->loginModel->clearSession();
		$this->loginObserver->clearCookie();
		$LogOutHtml = $this->loginView->renderForm($logOutMessage, $this->clientUserName);
		return $LogOutHtml;
	}

	/**
	 * Shows protected page when logged in
	 * @param  string $message Confirmation message
	 * @return string HTML
	 */
	private function showProtectedPage($message) {

		$userName = $this->tempAccount->getValidUser();

		$protectedPageHTML = $this->loginView->renderProtectedPage($userName, $message);

		return $protectedPageHTML;
	}

	/**
	 * Validates user name and password provided by user, and sets validation message
	 * @return null
	 */
	private function validateUserInput() {
		try {
			$this->clientUserName = $this->loginObserver->getClientUserName();
			$this->clientPassword = $this->loginObserver->getClientPassword();
			$this->loginModel->validateForm($this->clientUserName, $this->clientPassword);
		} catch (\Exception $e) {
			$this->message = $e->getMessage();
		}
	}
}