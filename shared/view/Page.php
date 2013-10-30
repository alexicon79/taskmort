<?php

namespace shared\view;

/**
 * Handles HTML Page
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Page {

	/**
	 * @var string $title
	 */
	public $title = "";

	/**
	 * @var string $body
	 */
    public $body = "";
	    
  	public function __construct($title, $body) {
	  		$this->title = $title;
	  		$this->body = $body;
  	}
}  	
