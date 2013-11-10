<?php

namespace app\view\helper;

class ListHelper extends \app\view\ClientRequestObserver {
	
	public function __construct() {

	}

	public static function getDomain() {
		$domain = "localhost/PHP/taskmort/public/";
		// $domain = "http://alxlabs.se/taskmort/public/";
		return $domain;
	}

	public static function listUrl($action, $listName, $text, $selector) {

		$link = "<a href='?" . parent::$LIST . "=" . $action . "&" . parent::$NAME . "=" . $listName . "'";
		$link .= "title='" . $listName . "' ";
		$link .= "class='" . $selector . "' ";
		$link .= ">";
		$link .= $text;
		$link .= "</a>";

		return $link;
	}
}