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
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/contact.js"></script>	
<script src="js/general.js"></script>
<?php include('inc/container.php');?>
<div class="container" style="background-color:#f4f3ef;">  
	<h2>Customer Relationship Management (CRM) System</h2>	
	<?php include('top_menus.php'); ?>	
	<br>
	<h4>Contact</h4>	
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addContact" class="btn btn-info" title="Add Contact"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="contactListing" class="table table-bordered table-striped">
			<thead>
				<tr>						
					<th>Id</th>					
					<th>Name</th>					
					<th>Company</th>
					<th>Industry</th>
					<th>Budget</th>
					<th>Sales Rep</th>
					<th></th>	
					<th></th>	
					<th></th>						
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="tasksDetails" class="modal fade">
		<div class="modal-dialog">    		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Tasks Details</h4>
				</div>
				<div class="modal-body">
					<table id="" class="table table-bordered table-striped">
						<thead>
							<tr>						
								<th>Id</th>					
								<th>Created</th>					
								<th>Task Type</th>
								<th>Description</th>	
								<th>Due Date</th>
								<th>Status</th>	
								<th>Contact</th>
								<th>Sales Rep</th>														
							</tr>
						</thead>
						<tbody id="tasksList">							
						</tbody>
					</table>								
				</div>    				
			</div>    		
		</div>
	</div>	
	<div id="contactModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="contactForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Sales Representative</h4>
					</div>
					<div class="modal-body">
						<div class="form-group"
							<label for="project" class="control-label">Contact First</label>
							<input type="text" class="form-control" id="contact_first" name="contact_first" placeholder="contact name" required>			
						</div>

						<div class="form-group"
							<label for="project" class="control-label">Contact Last</label>
							<input type="text" class="form-control" id="contact_last" name="contact_last" placeholder="contact last" >			
						</div>	
						
						<div class="form-group">
							<label for="address" class="control-label">Comapny</label>							
							<input type="text" class="form-control" id="contact_company" name="contact_company" placeholder="company" required>									
						</div>

						<div class="form-group">
							<label for="address" class="control-label">Industry</label>							
							<input type="text" class="form-control" id="contact_industry" name="contact_industry" placeholder="industry" required>									
						</div>
						
						<div class="form-group">
							<label for="address" class="control-label">Budget</label>							
							<input type="text" class="form-control" id="contact_budget" name="contact_budget" placeholder="budget" required>									
						</div>

						<div class="form-group">
							<label for="country" class="control-label">Sales Rep</label>							
							<select class="form-control" id="contact_sales_rep" name="contact_sales_rep"/>
							<?php 
							$salesRepResult = $user->salesRepList();
							while ($salesRep = $salesRepResult->fetch_assoc()) { 	
							?>
								<option value="<?php echo $salesRep['id']; ?>"><?php echo $salesRep['name']; ?></option>							
							<?php } ?>
							</select>							
						</div>

						
					</div>
					<div class="modal-footer">
						<input type="hidden" name="id" id="id" />
						<input type="hidden" name="action" id="action" value="" />
						<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
			
</div>
 <?php include('inc/footer.php');?>
