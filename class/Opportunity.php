<?php
class Opportunity {	
   
	private $userTable = 'crm_users';
	private $contactTable = 'crm_contact';	
	private $tasksTable = 'crm_tasks';			
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listOpportunity(){
		
		$sqlWhere = '';
		if($_SESSION["role"] == 'sales') { 
			$sqlWhere = " WHERE c.sales_rep = '".$_SESSION["userid"]."' and c.status = 'Proposal'";
		}	
		
		$sqlQuery = "SELECT c.id, c.contact_first, c.company, c.industry, c.budget, u.name, c.phone, c.website, c.status, c.initial_contact_date, c.email
		FROM ".$this->contactTable." c
		LEFT JOIN ".$this->userTable." u ON c.sales_rep = u.id $sqlWhere";
		
		if(!empty($_POST["order"])){
			$sqlQuery .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= ' ORDER BY id ASC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->contactTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($contact = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $contact['id'];
			$rows[] = ucfirst($contact['contact_first']);			
			$rows[] = $contact['company'];
			$rows[] = $contact['industry'];	
			$rows[] = $contact['phone'];		
			$rows[] = $contact['email'];
			$rows[] = $contact['website'];					
			$rows[] = '<button  type="button" name="view" id="'.$contact["id"].'" class="btn btn-info btn-xs view"><span title="View Tasks">View Notes</span></button>';			
			$rows[] = '<button type="button" name="update" id="'.$contact["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';			
			$rows[] = '<button type="button" name="delete" id="'.$contact["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';			
			$records[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}

	public function insert(){
		
		if($this->lead_first) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->contactTable."(`contact_first`, `contact_last`, `company`, `industry`, `budget`, `sales_rep`, `phone`, `email`, `website`, `status`)
			VALUES(?,?,?,?,?,?,?,?,?,?)");
		
			$this->lead_first = htmlspecialchars(strip_tags($this->lead_first));			
			$this->lead_last = htmlspecialchars(strip_tags($this->lead_last));
			$this->lead_company = htmlspecialchars(strip_tags($this->lead_company));
			$this->lead_industry = htmlspecialchars(strip_tags($this->lead_industry));
			$this->lead_budget = htmlspecialchars(strip_tags($this->lead_budget));
			$this->lead_status = htmlspecialchars(strip_tags($this->lead_status));	
			$this->lead_email = htmlspecialchars(strip_tags($this->lead_email));
			$this->lead_phone = htmlspecialchars(strip_tags($this->lead_phone));
			$this->lead_website = htmlspecialchars(strip_tags($this->lead_website)); 					
			
			$stmt->bind_param("ssssiiisss", $this->lead_first, $this->lead_last, $this->lead_company, $this->lead_industry, $this->lead_budget, $_SESSION["userid"], $this->lead_phone, $this->lead_email, $this->lead_website, $this->lead_status);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}

	public function getLead(){
		if($this->id) {
			$sqlQuery = "
			SELECT c.id, c.contact_first, c.contact_last, c.company, c.industry, c.budget, u.id as sale_rep_id, u.name, c.phone, c.website, c.status, c.initial_contact_date, c.email
			FROM ".$this->contactTable." c
			LEFT JOIN ".$this->userTable." u ON c.sales_rep = u.id 
			WHERE c.id = ?";		
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}


	public function update(){		
		if($this->id) {	
		
			$stmt = $this->conn->prepare("
			UPDATE ".$this->contactTable." 
			SET contact_first = ?, contact_last = ?, company = ?, industry = ?, budget = ?, sales_rep = ?, phone = ?, email = ?, website = ?, status = ?
			WHERE id = ?"); 			
			
			$this->lead_first = htmlspecialchars(strip_tags($this->lead_first));			
			$this->lead_last = htmlspecialchars(strip_tags($this->lead_last));
			$this->lead_company = htmlspecialchars(strip_tags($this->lead_company));
			$this->lead_industry = htmlspecialchars(strip_tags($this->lead_industry));
			$this->lead_budget = htmlspecialchars(strip_tags($this->lead_budget));
			$this->lead_status = htmlspecialchars(strip_tags($this->lead_status));	
			$this->lead_email = htmlspecialchars(strip_tags($this->lead_email));
			$this->lead_phone = htmlspecialchars(strip_tags($this->lead_phone));
			$this->lead_website = htmlspecialchars(strip_tags($this->lead_website)); 	
			
			$stmt->bind_param("ssssiiisssi", $this->lead_first, $this->lead_last, $this->lead_company, $this->lead_industry, $this->contact_budget, $_SESSION["userid"], $this->lead_phone, $this->lead_email, $this->lead_website, $this->lead_status, $this->id);			
			if($stmt->execute()){
				return true;
			}			
		}	
	}

	public function delete(){
		if($this->id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->contactTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){
				return true;
			}
		}
	} 

	
	public function getOpportunityDetails(){
		if($this->id) {
			$sqlQuery = "SELECT t.id, t.created, t.task_type, t.task_description, t.task_due_date, t.task_status, t.task_update, c.contact_first, u.name
			FROM ".$this->tasksTable." t 
			LEFT JOIN ".$this->contactTable." c ON t.contact = c.id
			LEFT JOIN ".$this->userTable." u ON t.sales_rep = u.id
			WHERE t.contact = ?";	
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);	
			$stmt->execute();
			$result = $stmt->get_result();			
			$records = array();		
			while ($tasks = $result->fetch_assoc()) { 				
				$rows = array();			
				$rows[] = $tasks['id'];
				$rows[] = $tasks['created'];			
				$rows[] = $tasks['task_type'];
				$rows[] = $tasks['task_description'];
				$rows[] = $tasks['task_due_date'];	
				$rows[] = $tasks['task_status'];
				$rows[] = $tasks['contact_first'];
				$rows[] = $tasks['name'];
				$records[] = $rows;
			}		
			$output = array(			
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}	

	

}
?>