<?php

namespace app\login\model;

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