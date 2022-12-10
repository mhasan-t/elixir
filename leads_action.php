<?php
include_once 'config/Database.php';
include_once 'class/Leads.php';

$database = new Database();
$db = $database->getConnection();

$leads = new Leads($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listLeads') {
	$leads->listLeads();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addLeads') {	
	$leads->lead_first = $_POST["lead_first"];
    $leads->lead_last = $_POST["lead_last"];
	$leads->lead_company = $_POST["lead_company"];
	$leads->lead_industry = $_POST["lead_industry"];
	$leads->lead_budget = $_POST["lead_budget"];
	$leads->lead_status = $_POST["lead_status"];
	$leads->lead_email = $_POST["lead_email"];
	$leads->lead_phone = $_POST["lead_phone"];
	$leads->lead_website = $_POST["lead_website"];	
	$leads->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getLead') {
	$leads->id = $_POST["id"];
	$leads->getLead();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateLeads') {
	$leads->id = $_POST["id"];
	$leads->lead_first = $_POST["lead_first"];
    $leads->lead_last = $_POST["lead_last"];
	$leads->lead_company = $_POST["lead_company"];
	$leads->lead_industry = $_POST["lead_industry"];
	$leads->lead_budget = $_POST["lead_budget"];
	$leads->lead_status = $_POST["lead_status"];
	$leads->lead_email = $_POST["lead_email"];
	$leads->lead_phone = $_POST["lead_phone"];
	$leads->lead_website = $_POST["lead_website"];
	$leads->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteLead') {
	$leads->id = $_POST["id"];
	$leads->delete();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getLeadsDetails') {
	$leads->id = $_POST["id"];
	$leads->getLeadsDetails();
}
?>