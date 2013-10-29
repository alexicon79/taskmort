<?php

namespace app\model;

class ListObject {
	
	private $allItems = array();
	private $tasks = array();
	private $notes = array();
	private $projects = array();
	private $completedTasks = array();

	public function __construct(){
		
	}

	public function addAllItems($items) {
		$this->allItems = $items;
	}

	public function getAllItems(){
		return $this->allItems;
	}

	public function addTask($task) {
		$this->tasks[] = $task;
	}

	public function addNote($note) {
		$this->notes[] = $note;
	}

	public function addProject($project) {
		$this->projects[] = $project;
	}

	public function addCompletedTask($completedTask) {
		$this->completedTasks[] = $completedTask;
	}

	public function convertAllItemsToString(){
		foreach ($this->allItems as $string) {
			# code...
		}
	}

}