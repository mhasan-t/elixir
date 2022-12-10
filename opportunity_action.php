<?php
include_once 'config/Database.php';
include_once 'class/Opportunity.php';

$database = new Database();
$db = $database->getConnection();

$opportunity = new Opportunity($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listOpportunity') {
	$opportunity->listOpportunity();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addOpportunity') {	
	$opportunity->lead_first = $_POST["lead_first"];
    $opportunity->lead_last = $_POST["lead_last"];
	$opportunity->lead_company = $_POST["lead_company"];
	$opportunity->lead_industry = $_POST["lead_industry"];
	$opportunity->lead_budget = $_POST["lead_budget"];
	$opportunity->lead_status = $_POST["lead_status"];
	$opportunity->lead_email = $_POST["lead_email"];
	$opportunity->lead_phone = $_POST["lead_phone"];
	$opportunity->lead_website = $_POST["lead_website"];	
	$opportunity->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getLead') {
	$opportunity->id = $_POST["id"];
	$opportunity->getLead();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateOpportunity') {
	$opportunity->id = $_POST["id"];
	$opportunity->lead_first = $_POST["lead_first"];
    $opportunity->lead_last = $_POST["lead_last"];
	$opportunity->lead_company = $_POST["lead_company"];
	$opportunity->lead_industry = $_POST["lead_industry"];
	$opportunity->lead_budget = $_POST["lead_budget"];
	$opportunity->lead_status = $_POST["lead_status"];
	$opportunity->lead_email = $_POST["lead_email"];
	$opportunity->lead_phone = $_POST["lead_phone"];
	$opportunity->lead_website = $_POST["lead_website"];
	$opportunity->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteLead') {
	$opportunity->id = $_POST["id"];
	$opportunity->delete();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getOpportunityDetails') {
	$opportunity->id = $_POST["id"];
	$opportunity->getOpportunityDetails();
}
?>