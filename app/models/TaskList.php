<?php

namespace app\model;

/**
 * Handles rules for task list items
 * @author Alexander Hall 
 * @link http://www.alxhall.se
 * @link https://github.com/alexicon79/taskmort/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class TaskList {
	
	/**
	 * @var app\model\ListFile $listFile
	 */
	private $listFile;

	/**
	 * @var array $allItems
	 */
	private $allItems = array();

	/**
	 * @var array $tasks
	 */
	private $tasks = array();
	
	/**
	 * @var array $notes
	 */
	private $notes = array();
	
	/**
	 * @var array $projects
	 */
	private $projects = array();
	
	/**
	 * @var array $completedTasks
	 */
	private $completedTasks = array();
	
	/**
	 * @var string Regular expression pattern matching a task
	 */
	private static $REGEX_TASK = "/^(- ([^\@\n]+).+)/i";

	/**
	 * @var string Regular expression pattern matching a completed task
	 */
	private static $REGEX_COMPLETED_TASK = "/- (.+@done)/i";
	
	/**
	 * @var string Regular expression pattern matching a project
	 */
	private static $REGEX_PROJECT = "/^(?!-)(.+:)$/i";

	/**
	 * @var string Regular expression pattern matching a note
	 */
	private static $REGEX_NOTE = "/^(?!\-).*(?<!\:)$/i";

	public function __construct(){
		$this->listDAL = new \app\model\ListFile();
	}

	/**
	 * Get marked up tasklist
	 * @param  string $selectedListName Name of list to create task list from
	 * @return app\model\TaskList
	 */
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

	/**
	 * Marks up list items based on regex patterns and stores in arrays
	 * @param  string $string List item to mark up and store
	 * @return null
	 */
	private function extractListObjectType($string) {

		$string = ltrim($string);
		$string = rtrim($string);

		$taskPattern = "/^(- ([^\@\n]+).+)/i";
		$donePattern = "/- (.+@done)/i";
		$projectPattern = "/^(?!-)(.+:)$/i";
		$notePattern = "/^(?!\-).*(?<!\:)$/i";

		if (preg_match(self::$REGEX_TASK, $string)) {
			$this->addTask($string);
		}
		
		if (preg_match(self::$REGEX_COMPLETED_TASK, $string)) {
			$this->addCompletedTask($string);
		}
		
		if (preg_match(self::$REGEX_NOTE, $string)) {
			$this->addNote($string);
		}

		if (preg_match(self::$REGEX_PROJECT, $string)) {
			$this->addProject($string);
		}
	}
	
	/**
	 * Add to array containing all list items
	 * @param array $items All list items
	 */
	public function addAllItems($items) {
		$this->allItems = $items;
	}

	/**
	 * Get array containing all list items
	 * @return array
	 */
	public function getAllItems(){
		return $this->allItems;
	}
	
	/**
	 * Add to array containing all task items
	 * @param string $task Task item
	 */
	public function addTask($task) {
		$this->tasks[] = $task;
	}

	/**
	 * Add to array containing all note items
	 * @param string $note Note item
	 */
	public function addNote($note) {
		$this->notes[] = $note;
	}
	
	/**
	 * Add to array containing all project items
	 * @param string $project Project item
	 */
	public function addProject($project) {
		$this->projects[] = $project;
	}

	/**
	 * Add to array containing all completed task items
	 * @param string $completedTask Completed task item
	 */
	public function addCompletedTask($completedTask) {
		$this->completedTasks[] = $completedTask;
	}

}