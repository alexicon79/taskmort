<?php

namespace app\login\view;

require_once("../app/login/views/LoginObserver.php");

class LoginView extends LoginObserver {

	/**
	 * @var \model\TempAccount
	 */
	private $tempAccount;

	/**
	 * @var \view\LoginObserver
	 */
	private $loginObserver;

	public function __construct() {
		$this->tempAccount = new \app\login\model\TempAccount();
		$this->loginObserver = new \app\login\view\loginObserver();
	}

	/**
	 * Renders login form and returns HTML
	 * @param  string $message  , Error message
	 * @param  string $username , User name
	 * @return string HTML
	 */
	public function renderForm($message, $username) {
		return "
		<div id='formWrapper'>
			<h1 class='login'>TASKMÔRT</h1>
			<p id='errorMsg'>$message</p>
			<form method='post' action=''>
				<label class='login'>Username</label>
				<input class='loginForm' name='" . LoginObserver::$USERNAME . "' placeholder='Username' value='$username'>
				<label class='login'>Password</label>
				<input class='loginForm' name='" . LoginObserver::$PASSWORD . "' type='password' placeholder='Password'>
				<span id='checkbox'><input class='loginCheckbox' name='" . LoginObserver::$COOKIE . "' type='checkbox'>
				Stay logged in</span>
				<input class='loginSubmit' id='submit' name='" . LoginObserver::$SUBMIT . "' type='submit' value='Login'>
			</form>
			<span id='loginDisclaimer'>Taskmôrt is a plain text task manager created by <a href='http://www.alxhall.se'>Alexander Hall</a>. The app is currently in beta. New features will be added continuously.</span>
		</div>";
	}

	/**
	 * Renders protected page and returns HTML
	 * @param  string $userName
	 * @param  string $message , Confirmation message     
	 * @return string HTML
	 */
	public function renderProtectedPage($userName, $message) {
		return "
		<div id='formWrapper'>
			<h1>$userName är inloggad</h1>
			<p>$message</p>
			<p><a href='?". LoginObserver::$LOGOUT . "'>Logga ut</a></p></div>";
	}

	/**
	 * Gets relevant confirmation message depending on authentication mode
	 * @return string
	 */
	public function getConfirmationMessage() {

		switch ($this->loginObserver->AuthenticationMode()) {
			// form
			case LoginObserver::FORM_AUTHENTICATION:
				return "Inloggningen lyckades";
			// session			
			case LoginObserver::SESSION_AUTHENTICATION:
				return "";
			// cookie
			case LoginObserver::COOKIE_AUTHENTICATION:
				return "Inloggningen lyckades via cookies";

			default:
				return "";
		}
	}
	
	/**
	 * Returns log out message
	 * @return string
	 */
	public function getLogOutMessage() {
		return "Du har nu loggat ut";
	}

	/**
	 * Returns saved cookie message
	 * @return string 
	 */
	public function getCookieMessage() {
		return "Inloggningen lyckades och vi kommer ihåg dig nästa gång";
	}

	/**
	 * Returns invalid cookie message
	 * @return string
	 */
	public function getCookieIsInvalidMessage() {
		return "Felaktig information i cookie";
	}
}