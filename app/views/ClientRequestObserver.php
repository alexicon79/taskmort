<?php

namespace app\view;

class ClientRequestObserver {

	public function createNewList() {
		if(isset ($_GET['file']) && $_GET['file'] == "newList") {
			return true;
		}
	}
}