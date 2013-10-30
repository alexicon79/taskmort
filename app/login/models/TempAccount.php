<?php

namespace app\login\model;

// @TODO: Implement more sophisticated solution

/**
 * Temporary account
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class TempAccount {

	/**
	 * @var string , Valid user name
	 */
	private static $validUser = "taskmort";

	/**
	 * @var string , Valid password
	 */
	private static $validPassword = "demo";

	/**
	 * @return string , Valid user name
	 */
	public function getValidUser() {
		return self::$validUser;
	}

	/**
	 * @return string , Valid password
	 */
	public function getValidPassword() {
		return self::$validPassword;
	}
	
	/**
	 * @return string , Hashed password
	 */
	public function getPasswordHash() {
		return sha1($this->getValidPassword());
	}
}