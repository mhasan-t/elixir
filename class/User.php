<?php
class User {	
   
	private $userTable = 'crm_users';
	private $contactTable = 'crm_contact';		
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function login(){
		if($this->email && $this->password) {			
			$sqlQuery = "
				SELECT * FROM ".$this->userTable."
				WHERE status = 1 
				AND roles = ? AND email = ? AND password = ?";			
			$stmt = $this->conn->prepare($sqlQuery);
			$password = md5($this->password);
			$stmt->bind_param("sss", $this->loginType, $this->email, $password);	
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				$user = $result->fetch_assoc();
				$_SESSION["userid"] = $user['id'];
				$_SESSION["role"] = $this->loginType;
				$_SESSION["name"] = $user['email'];					
				return 1;		
			} else {
				return 0;		
			}			
		} else {
			return 0;
		}
	}
	
	public function loggedIn (){
		if(!empty($_SESSION["userid"])) {
			return 1;
		} else {
			return 0;
		}
	}
	
	public function listSalesRep(){

		$sqlWhere = '';
		if($_SESSION["role"] == 'manager') { 
			$sqlWhere = "WHERE roles = 'sales' and status = 1";
		}		
		$sqlQuery = "SELECT * FROM ".$this->userTable." $sqlWhere";
		
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
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->userTable." $sqlWhere");
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($salesRep = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $salesRep['id'];
			$rows[] = ucfirst($salesRep['name']);			
			$rows[] = $salesRep['email'];
			$rows[] = $salesRep['status'];					
			$rows[] = '<button  type="button" name="view" id="'.$salesRep["id"].'" class="btn btn-info btn-xs view"><span title="View Contacts">View Contacts</span></button>';			
			$rows[] = '<button type="button" name="update" id="'.$salesRep["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';			
			$rows[] = '<button type="button" name="delete" id="'.$salesRep["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';			
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
	
	public function getContacts(){
		if($this->id) {
			$sqlQuery = "SELECT c.id, c.contact_first, c.contact_last, c.company, c.industry, c.status, c.budget
			FROM ".$this->contactTable." c  
			WHERE c.sales_rep = ?";				
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);	
			$stmt->execute();
			$result = $stmt->get_result();			
			$records = array();		
			while ($contact = $result->fetch_assoc()) { 				
				$rows = array();			
				$rows[] = $contact['id'];
				$rows[] = ucfirst($contact['contact_first']);			
				$rows[] = $contact['contact_last'];
				$rows[] = $contact['company'];
				$rows[] = $contact['industry'];	
				$rows[] = $contact['status'];
				$rows[] = $contact['budget'];				
				$records[] = $rows;
			}		
			$output = array(			
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}

	public function insertSalesRep(){
		
		if($this->sales_name) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->userTable."(`name`, `email`, `password`, `roles`, `status`)
			VALUES(?,?,?,?,?)");
		
			$this->sales_name = htmlspecialchars(strip_tags($this->sales_name));			
			$this->sales_email = htmlspecialchars(strip_tags($this->sales_email));
			$this->sales_password = md5(htmlspecialchars(strip_tags($this->sales_password)));
			$this->roles = 'sales';		
			$this->status = 1;			
			
			$stmt->bind_param("ssssi", $this->sales_name, $this->sales_email, $this->sales_password, $this->roles, $this->status);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}

	public function getSalesRep(){
		if($this->sales_rep_id) {
			$sqlQuery = "SELECT id, name, email, password	
			FROM ".$this->userTable."
			WHERE id = ?";			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->sales_rep_id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}

	public function updateSalesRep(){
		
		if($this->sales_rep_id) {				
			$stmt = $this->conn->prepare("
			UPDATE ".$this->userTable." 
			SET name= ?, email = ?, password = ?
			WHERE id = ?"); 
			
			$this->sales_name = htmlspecialchars(strip_tags($this->sales_name));			
			$this->sales_email = htmlspecialchars(strip_tags($this->sales_email));
			$this->sales_password = md5(htmlspecialchars(strip_tags($this->sales_password)));	
			
			$stmt->bind_param("sssi", $this->sales_name, $this->sales_email, $this->sales_password, $this->sales_rep_id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}

	public function deleteSalesRep(){
		if($this->sales_rep_id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->userTable." 
				WHERE id = ?");

			$this->sales_rep_id = htmlspecialchars(strip_tags($this->sales_rep_id));

			$stmt->bind_param("i", $this->sales_rep_id);

			if($stmt->execute()){
				return true;
			}
		}
	} 

	function salesRepList(){		
		$stmt = $this->conn->prepare("
		SELECT id, name FROM ".$this->userTable." 
		WHERE roles = 'sales' and status = 1");				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}

	function contactList(){		
		$stmt = $this->conn->prepare("
		SELECT id, contact_first as name FROM ".$this->contactTable);				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}

}
?>