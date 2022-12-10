<?php
class Contact {	
   
	private $userTable = 'crm_users';
	private $contactTable = 'crm_contact';	
	private $tasksTable = 'crm_tasks';			
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listContact(){
		
		$sqlWhere = '';
		if($_SESSION["role"] == 'sales') { 
			$sqlWhere = " WHERE c.sales_rep = '".$_SESSION["userid"]."'";
		}	
		
		$sqlQuery = "SELECT c.id, c.contact_first, c.company, c.industry, c.budget, u.name 
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
			$rows[] = $contact['budget'];		
			$rows[] = $contact['name'];				
			$rows[] = '<button  type="button" name="view" id="'.$contact["id"].'" class="btn btn-info btn-xs view"><span title="View Tasks">View Tasks</span></button>';			
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
		
		if($this->contact_first) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->contactTable."(`contact_first`, `contact_last`, `company`, `industry`, `budget`, `sales_rep`)
			VALUES(?,?,?,?,?,?)");
		
			$this->contact_first = htmlspecialchars(strip_tags($this->contact_first));			
			$this->contact_last = htmlspecialchars(strip_tags($this->contact_last));
			$this->contact_company = htmlspecialchars(strip_tags($this->contact_company));
			$this->contact_industry = htmlspecialchars(strip_tags($this->contact_industry));
			$this->contact_budget = htmlspecialchars(strip_tags($this->contact_budget));
			$this->contact_sales_rep = htmlspecialchars(strip_tags($this->contact_sales_rep));			
			
			$stmt->bind_param("ssssii", $this->contact_first, $this->contact_last, $this->contact_company, $this->contact_industry, $this->contact_budget, $this->contact_sales_rep);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}

	public function getContact(){
		if($this->contact_id) {
			$sqlQuery = "
			SELECT c.id, c.contact_first, c.contact_last, c.company, c.industry, c.budget, u.id as sale_rep_id, u.name 
			FROM ".$this->contactTable." c
			LEFT JOIN ".$this->userTable." u ON c.sales_rep = u.id 
			WHERE c.id = ?";		
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->contact_id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}


	public function update(){		
		if($this->contact_id) {				
			$stmt = $this->conn->prepare("
			UPDATE ".$this->contactTable." 
			SET contact_first = ?, contact_last = ?, company = ?, industry = ?, budget = ?, sales_rep = ?
			WHERE id = ?"); 			
			$this->contact_first = htmlspecialchars(strip_tags($this->contact_first));			
			$this->contact_last = htmlspecialchars(strip_tags($this->contact_last));
			$this->contact_company = htmlspecialchars(strip_tags($this->contact_company));
			$this->contact_industry = htmlspecialchars(strip_tags($this->contact_industry));
			$this->contact_budget = htmlspecialchars(strip_tags($this->contact_budget));
			$this->contact_sales_rep = htmlspecialchars(strip_tags($this->contact_sales_rep));				
			$stmt->bind_param("ssssiii", $this->contact_first, $this->contact_last, $this->contact_company, $this->contact_industry, $this->contact_budget, $this->contact_sales_rep, $this->contact_id);			
			if($stmt->execute()){
				return true;
			}			
		}	
	}

	public function delete(){
		if($this->contact_id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->contactTable." 
				WHERE id = ?");

			$this->contact_id = htmlspecialchars(strip_tags($this->contact_id));

			$stmt->bind_param("i", $this->contact_id);

			if($stmt->execute()){
				return true;
			}
		}
	} 

	
	public function getTasks(){
		if($this->contact_id) {
			$sqlQuery = "SELECT t.id, t.created, t.task_type, t.task_description, t.task_due_date, t.task_status, t.task_update, c.contact_first, u.name
			FROM ".$this->tasksTable." t 
			LEFT JOIN ".$this->contactTable." c ON t.contact = c.id
			LEFT JOIN ".$this->userTable." u ON t.sales_rep = u.id
			WHERE t.contact = ?";	
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->contact_id);	
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