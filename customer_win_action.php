<?php
include_once 'config/Database.php';
include_once 'class/Customer.php';

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listOpportunity') {
	$customer->listOpportunity();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addOpportunity') {	
	$customer->lead_first = $_POST["lead_first"];
    $customer->lead_last = $_POST["lead_last"];
	$customer->lead_company = $_POST["lead_company"];
	$customer->lead_industry = $_POST["lead_industry"];
	$customer->lead_budget = $_POST["lead_budget"];
	$customer->lead_status = $_POST["lead_status"];
	$customer->lead_email = $_POST["lead_email"];
	$customer->lead_phone = $_POST["lead_phone"];
	$customer->lead_website = $_POST["lead_website"];	
	$customer->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getLead') {
	$customer->id = $_POST["id"];
	$customer->getLead();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateOpportunity') {
	$customer->id = $_POST["id"];
	$customer->lead_first = $_POST["lead_first"];
    $customer->lead_last = $_POST["lead_last"];
	$customer->lead_company = $_POST["lead_company"];
	$customer->lead_industry = $_POST["lead_industry"];
	$customer->lead_budget = $_POST["lead_budget"];
	$customer->lead_status = $_POST["lead_status"];
	$customer->lead_email = $_POST["lead_email"];
	$customer->lead_phone = $_POST["lead_phone"];
	$customer->lead_website = $_POST["lead_website"];
	$customer->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteLead') {
	$customer->id = $_POST["id"];
	$customer->delete();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getOpportunityDetails') {
	$customer->id = $_POST["id"];
	$customer->getOpportunityDetails();
}
?>