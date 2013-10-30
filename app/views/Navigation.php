<?php

namespace app\view;

require_once("../app/views/ClientRequestObserver.php");

/**
 * Handles visual representation of application navigation
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Navigation extends ClientRequestObserver {
	
	/**
	 * Display navigation
	 * @return string HTML
	 */
	public function getMenu() {
		$menu = "
		<div id='navigation'>
			<span id='home'>TASKMÔRT</span>
			<a href='?" . parent::$LIST . "=" . parent::$NEW . "'>New</a> | 
			<a href='?" . parent::$LIST . "=" . parent::$BROWSE . "'>My Lists</a> | 
			<a href='?" . \app\login\view\LoginObserver::$LOGOUT . "' id='signOut'>Sign Out</a>
		</div>";

		return $menu;
	}
}