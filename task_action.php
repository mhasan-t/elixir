<?php
include_once 'config/Database.php';
include_once 'class/Tasks.php';

$database = new Database();
$db = $database->getConnection();

$task = new Tasks($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listTasks') {
	$task->listTasks();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addTask') {	
	$task->description = $_POST["description"];
    $task->due_date = $_POST["due_date"];
	$task->contact = $_POST["contact"];
	$task->sales_rep = $_POST["sales_rep"];
	$task->status = $_POST["status"];	
	$task->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getTask') {
	$task->id = $_POST["id"];
	$task->getTasks();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateTask') {
	$task->id = $_POST["id"];
	$task->description = $_POST["description"];
    $task->due_date = $_POST["due_date"];
	$task->contact = $_POST["contact"];
	$task->sales_rep = $_POST["sales_rep"];
	$task->status = $_POST["status"];
	$task->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteTasks') {
	$task->id = $_POST["id"];
	$task->delete();
}
?>