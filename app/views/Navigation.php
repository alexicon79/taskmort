<?php

namespace app\view;

class Navigation {
	
	/**
	 * [$NEW_LIST description]
	 * @var string
	 */
	private static $NEW_LIST = "newList";
	
	/**
	 * [$VIEW_LIST description]
	 * @var string
	 */
	private static $VIEW_LIST = "viewList";
	
	/**
	 * [$EDIT_LIST description]
	 * @var string
	 */
	private static $EDIT_LIST = "editList";

	/**
	 * [$DELETE_LIST description]
	 * @var string
	 */
	private static $DELETE_LIST = "deleteList";

	
	public function getMenu() {
		$menu = "
		<div id='navigation'>
			<a href='?file=" . self::$NEW_LIST . "'>New List</a> | 
			<a href='?file=" . self::$VIEW_LIST . "'>View List</a> | 
			<a href='?file=" . self::$EDIT_LIST . "''>Edit List</a> | 
			<a href='?file=" . self::$DELETE_LIST . "''>Delete List</a>
		</div>";

		return $menu;
	}
}