<?php
class Tasks {	
   
	private $userTable = 'crm_users';
	private $contactTable = 'crm_contact';	
	private $tasksTable = 'crm_tasks';			
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listTasks(){
		
		$sqlWhere = '';
		if($_SESSION["role"] == 'sales') { 
			$sqlWhere = " WHERE t.sales_rep = '".$_SESSION["userid"]."'";
		}	
			
		$sqlQuery = "SELECT t.id, t.created, t.task_type, t.task_description, t.task_due_date, t.task_status, t.task_update, c.contact_first, u.name
			FROM ".$this->tasksTable." t 
			LEFT JOIN ".$this->contactTable." c ON t.contact = c.id
			LEFT JOIN ".$this->userTable." u ON t.sales_rep = u.id $sqlWhere";	
		
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
		while ($tasks = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $tasks['id'];
			$rows[] = $tasks['task_description'];			
			$rows[] = $tasks['task_due_date'];
			$rows[] = $tasks['contact_first'];	
			$rows[] = $tasks['name'];
			$rows[] = $tasks['task_status'];					
			$rows[] = '<button type="button" name="update" id="'.$tasks["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';			
			$rows[] = '<button type="button" name="delete" id="'.$tasks["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';			
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
		
		if($this->description) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->tasksTable."(`task_description`, `task_due_date`, `contact`, `sales_rep`, `task_status`)
			VALUES(?,?,?,?,?)");
		
			$this->description = htmlspecialchars(strip_tags($this->description));			
			$this->due_date = htmlspecialchars(strip_tags($this->due_date));
			$this->contact = htmlspecialchars(strip_tags($this->contact));
			$this->sales_rep = htmlspecialchars(strip_tags($this->sales_rep));
			$this->status = htmlspecialchars(strip_tags($this->status));
					
			$stmt->bind_param("ssiis", $this->description, $this->due_date, $this->contact, $this->sales_rep, $this->status);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}

	public function getTasks(){
		if($this->id) {	
			$sqlQuery = "SELECT t.id, t.created, t.task_type, t.task_description, t.task_due_date, t.task_status, t.task_update, c.contact_first, u.name, u.id as sales_rep
			FROM ".$this->tasksTable." t 
			LEFT JOIN ".$this->contactTable." c ON t.contact = c.id
			LEFT JOIN ".$this->userTable." u ON t.sales_rep = u.id
			WHERE t.id = ?";	

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
			UPDATE ".$this->tasksTable." 
			SET task_description = ?, task_due_date = ?, contact = ?, sales_rep = ?, task_status = ?
			WHERE id = ?"); 			
			$this->description = htmlspecialchars(strip_tags($this->description));			
			$this->due_date = htmlspecialchars(strip_tags($this->due_date));
			$this->contact = htmlspecialchars(strip_tags($this->contact));
			$this->sales_rep = htmlspecialchars(strip_tags($this->sales_rep));
			$this->status = htmlspecialchars(strip_tags($this->status));				
			$stmt->bind_param("ssiisi", $this->description, $this->due_date, $this->contact, $this->sales_rep, $this->status, $this->id);			
			if($stmt->execute()){
				return true;
			}			
		}	
	}

	public function delete(){
		if($this->id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->tasksTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){
				return true;
			}
		}
	} 

}
?>