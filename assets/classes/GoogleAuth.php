<?php


	class GoogleAuth
	{

		protected $client;

		function __construct()
		{
			$this->client = new Google_Client();
			$this->client->setClientId('574911392646-bjadbu94vplvlugscp9rduaar91f7f2e.apps.googleusercontent.com');
			$this->client->setClientSecret('83PljelsNHet31sCMaQLb_2x');
			//in redirect uri please enter your redirect uri where page will redirect after login
			//In my case I directed it to http://localhost/paaysay/googletaskapi/index.php
			// you have to change this according to where you place these files
			$this->client->setRedirectUri('http://offlinetest.dev/index.php');
			$this->client->setScopes('https://www.googleapis.com/auth/tasks.readonly https://www.googleapis.com/auth/tasks');
		}


		public function isLoggedIn()
		{
			return isset($_SESSION['access_token']);

		}

		public function getAuthUrl()
		{
			return $this->client->createAuthUrl();
		}

		public function checkRedirectCode()
		{
			if (isset($_GET['code'])) {
			  $this->client->authenticate($_GET['code']);
			  $_SESSION['access_token'] = $this->client->getAccessToken();
			  return true;
			}
			return false;
		}
		public function getTasks()
		{
			if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
				$this->client->setAccessToken($_SESSION['access_token']);
				$service = new Google_Service_Tasks($this->client);
				$checkDefaultTaskList = $service->tasklists->get('@default');
				if (count($checkDefaultTaskList) == 0) {
				  $newTaskList = new Google_Service_Tasks_TaskList();
				  $newTaskList->title = '@default';
				  $createNewTaskList = $service->tasklists->insert($newTaskList);
				}
				$tasks = $service->tasks->listTasks('@default');
				return compact('tasks');
			}
		}

		public function addTask($task)
		{
			if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
				$this->client->setAccessToken($_SESSION['access_token']);
				$service = new Google_Service_Tasks($this->client);
				
				$newTask = new Google_Service_Tasks_Task;

			  	$newTask->setTitle($task);

			  	$insertTask = $service->tasks->insert('@default', $newTask);
			  	header('location: index.php');
			}
		}

		public function deleteAllTasks()
		{
			if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
				$this->client->setAccessToken($_SESSION['access_token']);
				$service = new Google_Service_Tasks($this->client);
				
			    $tasks = $service->tasks->listTasks('@default');  
			    foreach($tasks->getItems() as $task) {
			  	  $delete = $service->tasks->delete('@default', $task->getId());
			    }

			  	header('location: index.php');
			}
		}

		public function deleteTask($task)
		{
			if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
				$this->client->setAccessToken($_SESSION['access_token']);
				$service = new Google_Service_Tasks($this->client);
				
			    $delete = $service->tasks->delete('@default', $task);

			  	header('location: index.php');
			}
		}

	}

?>
