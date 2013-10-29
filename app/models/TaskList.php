<?php

namespace app\model;

class TaskList {
	
	private $listDAL;
	private $allItems = array();
	private $tasks = array();
	private $notes = array();
	private $projects = array();
	private $completedTasks = array();

	public function __construct(){
		$this->listDAL = new \app\model\ListDAL();
	}

	public function getTaskList($selectedListName) {
		$rawFileContent = $this->listDAL->getFileContent($selectedListName);

		$items = explode("\n", $rawFileContent);
		$items = array_filter($items);

		$this->addAllItems($items);

		$markedUpObjects = array();

		foreach ($items as $string) {
			$this->extractListObjectType($string);
		}
		return $this;
	}

	private function extractListObjectType($string) {

		$string = ltrim($string);
		$string = rtrim($string);

		$taskPattern = "/^(- ([^\@\n]+).+)/i";
		$donePattern = "/- (.+@done)/i";
		$projectPattern = "/^(?!-)(.+:)$/i";
		$notePattern = "/^(?!\-).*(?<!\:)$/i";

		if (preg_match($taskPattern, $string)) {
			$this->addTask($string);
		}
		
		if (preg_match($donePattern, $string)) {
			$this->addCompletedTask($string);
		}
		
		if (preg_match($notePattern, $string)) {
			$this->addNote($string);
		}

		if (preg_match($projectPattern, $string)) {
			$this->addProject($string);
		}
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