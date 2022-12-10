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
<script src="js/task.js"></script>	
<script src="js/general.js"></script>
<?php include('inc/container.php');?>
<div class="container" style="background-color:#f4f3ef;">  
	<h2>Customer Relationship Management (CRM) System</h2>	
	<?php include('top_menus.php'); ?>	
	<br>
	<h4>Tasks</h4>		
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addTasks" class="btn btn-info" title="Add Tasks"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="tasksListing" class="table table-bordered table-striped">
			<thead>
				<tr>						
					<th>Id</th>					
					<th>Description</th>					
					<th>Due Date</th>
					<th>Contact</th>
					<th>Sales Rep</th>
					<th>Status</th>					
					<th></th>	
					<th></th>						
				</tr>
			</thead>
		</table>
	</div>
	
	
	<div id="taskModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="taskForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Task</h4>
					</div>
					<div class="modal-body">
						<div class="form-group"
							<label for="project" class="control-label">Description</label>
							<input type="text" class="form-control" id="description" name="description" placeholder="Description name" required>			
						</div>

						<div class="form-group"
							<label for="project" class="control-label">Due Date</label>
							<input type="date" class="form-control" id="due_date" name="due_date" placeholder="Due date" >			
						</div>	

						<div class="form-group">
							<label for="country" class="control-label">Contact</label>							
							<select class="form-control" id="contact" name="contact"/>
							<?php 
							$contactResult = $user->contactList();
							while ($conatct = $contactResult->fetch_assoc()) { 	
							?>
								<option value="<?php echo $conatct['id']; ?>"><?php echo $conatct['name']; ?></option>							
							<?php } ?>
							</select>							
						</div>

						<div class="form-group">
							<label for="country" class="control-label">Sales Rep</label>							
							<select class="form-control" id="sales_rep" name="sales_rep"/>
							<?php 
							$salesRepResult = $user->salesRepList();
							while ($salesRep = $salesRepResult->fetch_assoc()) { 	
							?>
								<option value="<?php echo $salesRep['id']; ?>"><?php echo $salesRep['name']; ?></option>							
							<?php } ?>
							</select>							
						</div>

						<div class="form-group">
							<label for="country" class="control-label">Status</label>							
							<select class="form-control" id="status" name="status"/>							
								<option value="Pending">Pending</option>
								<option value="Completed">Completed</option>		
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
