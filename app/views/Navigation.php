<?php

namespace app\view;

require_once("../app/views/ClientRequestObserver.php");

class Navigation extends ClientRequestObserver {
		
	public function getMenu() {
		$menu = "
		<div id='navigation'>
			<a href='?" . parent::$LIST . "=" . parent::$NEW . "'>New</a> | 
			<a href='?" . parent::$LIST . "=" . parent::$BROWSE . "'>My Lists</a>
		</div>";

		return $menu;
	}
}