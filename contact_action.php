<?php
include_once 'config/Database.php';
include_once 'class/Contact.php';

$database = new Database();
$db = $database->getConnection();

$contact = new Contact($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listContact') {
	$contact->listContact();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addContact') {	
	$contact->contact_first = $_POST["contact_first"];
    $contact->contact_last = $_POST["contact_last"];
	$contact->contact_company = $_POST["contact_company"];
	$contact->contact_industry = $_POST["contact_industry"];
	$contact->contact_budget = $_POST["contact_budget"];
	$contact->contact_sales_rep = $_POST["contact_sales_rep"];
	$contact->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getContact') {
	$contact->contact_id = $_POST["id"];
	$contact->getContact();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateContact') {
	$contact->contact_id = $_POST["id"];
	$contact->contact_first = $_POST["contact_first"];
    $contact->contact_last = $_POST["contact_last"];
	$contact->contact_company = $_POST["contact_company"];
	$contact->contact_industry = $_POST["contact_industry"];
	$contact->contact_budget = $_POST["contact_budget"];
	$contact->contact_sales_rep = $_POST["contact_sales_rep"];	
	$contact->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteContact') {
	$contact->contact_id = $_POST["id"];
	$contact->delete();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getTasks') {
	$contact->contact_id = $_POST["id"];
	$contact->getTasks();
}
?>