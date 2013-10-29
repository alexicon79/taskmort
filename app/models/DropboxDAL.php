<?php

namespace app\model;

class DropboxDAL extends ListDAL {

	private $appInfo;
	private $webAuth;
	private $dbxClient;

	private static $DBX_ACCESS_TOKEN = "KB7jXVnaY84AAAAAAAAAAa9BX1yL4feEQLa5cjyCicezxeZEeuQ5AiNRFIsM1rS6";
	private static $DBX_APP_INFO = "../app-info.json";
	private static $DBX_APP_NAME = "Taskmort";

	public function __construct() {
		$this->appInfo = \Dropbox\AppInfo::loadFromJsonFile(self::$DBX_APP_INFO);
		$this->webAuth = new \Dropbox\WebAuthNoRedirect($appInfo, self::$DBX_APP_NAME);
		$this->dbxClient = new \Dropbox\Client(self::$DBX_ACCESS_TOKEN, self::$DBX_APP_NAME);
	}

	public function saveToDropboxFile($listName, $listContent) {
		
		$f = fopen("../data/hawohl.txt", "rb");
		$result = $dbxClient->uploadFile("/hawohl.txt", \Dropbox\WriteMode::force(), $f);
		fclose($f);

		$folderMetadata = $dbxClient->getMetadataWithChildren("/");
	}

	public function getAccountInfo() {
		return $this->dbxClient->getAccountInfo();
	}
}