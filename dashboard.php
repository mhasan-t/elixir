<?php
include_once 'config/Database.php';
include_once 'class/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(!$user->loggedIn()) {
	header("Location: index.php");
}
include('inc/header.php');
?>
<title>Elixir Customer Relationship Management (CRM) System</title>
<link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
<link href="assets/css/themify-icons.css" rel="stylesheet">
<script src="js/general.js"></script>
<?php include('inc/container.php');?>
<div class="container" style="background-color:#f4f3ef;">  
	<h2>Customer Relationship Management (CRM) System</h2>	
	<br>
	<?php include('top_menus.php'); ?>	
	<br>	
	<div class="row">
		<div class="col-lg-3 col-sm-6">
			
		</div>
	</div>
			
</div>
 <?php include('inc/footer.php');?>
