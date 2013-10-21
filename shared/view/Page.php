<?php

namespace shared\view;

class Page {
	
	public $title = "";
    public $body = "";
	    
  	public function __construct($title, $body) {
	  		$this->title = $title;
	  		$this->body = $body;
  	}
}  	
