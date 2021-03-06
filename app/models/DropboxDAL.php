<?php

namespace app\model;

/**
 * Handles communication with Dropbox
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class DropboxDAL extends ListFile {

	/**
	 * @var \Dropbox\AppInfo $appInfo
	 */
	private $appInfo;

	/**
	 * @var \Dropbox\WebAuthNoRedirect $webAuth
	 */
	private $webAuth;

	/**
	 * @var \Dropbox\Client $dbxClient
	 */
	private $dbxClient;

	/**
	 * @var string Dropbox access token
	 */
	private static $DBX_ACCESS_TOKEN = "KB7jXVnaY84AAAAAAAAAAa9BX1yL4feEQLa5cjyCicezxeZEeuQ5AiNRFIsM1rS6";
	
	/**
	 * @var string Path to Dropbox AppInfo file
	 */
	private static $DBX_APP_INFO_PATH = "../app-info.json";
	
	/**
	 * @var string App name
	 */
	private static $DBX_APP_NAME = "Taskmort";

	public function __construct() {
		$this->appInfo = \Dropbox\AppInfo::loadFromJsonFile(self::$DBX_APP_INFO_PATH);
		$this->webAuth = new \Dropbox\WebAuthNoRedirect($this->appInfo, self::$DBX_APP_NAME);
		$this->dbxClient = new \Dropbox\Client(self::$DBX_ACCESS_TOKEN, self::$DBX_APP_NAME);
	}

	/**
	 * @param  string $listName 	Name of list to save to Dropbox
	 * @param  string $listContent 	Content to save
	 * @return null              
	 */
	public function saveListToDropbox($listName, $listContent) {
		
		$f = fopen(parent::$INCLUDE_PATH . $listName, "rb");
		$result = $this->dbxClient->uploadFile("/" . $listName, \Dropbox\WriteMode::force(), $f);
		fclose($f);

		// $folderMetadata = $dbxClient->getMetadataWithChildren("/");
	}

	/**
	 * @return array Info about current Dropbox Account
	 */
	public function getAccountInfo() {
		return $this->dbxClient->getAccountInfo();
	}
}