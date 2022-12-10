<h3><?php if($_SESSION["userid"]) { echo "Logged in : ".ucfirst($_SESSION["name"]); } ?> | <a href="logout.php">Logout</a> </h3><br>
<p><strong>Welcome <?php echo ucfirst($_SESSION["role"]); ?></strong></p>	
<ul class="nav nav-tabs">	
	<?php if($_SESSION["role"] == 'manager') { ?>		
		<li id="sales_people"><a href="sales_people.php">My Sales People</a></li>
		<li id="tasks"><a href="tasks.php">Tasks</a></li> 
		<li id="contact"><a href="contact.php">Contact</a></li> 		
	<?php } ?>
	
	<?php if($_SESSION["role"] == 'sales') { ?>
		<li id="tasks"><a href="tasks.php">Tasks</a></li> 
		<li id="leads"><a href="leads.php">Leads</a></li>
		<li id="opportunity"><a href="opportunity.php">Opportunity</a></li>	
		<li id="customer_win"><a href="customer_win.php">Customer / Won</a></li>			
	<?php } ?>
</ul>