$(document).ready(function(){	

	var contactRecords = $('#contactListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"contact_action.php",
			type:"POST",
			data:{action:'listContact'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 6, 7, 8],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addContact').click(function(){
		$('#contactModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#contactForm')[0].reset();
		$("#contactModal").on("shown.bs.modal", function () { 
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Contact");			
			$('#action').val('addContact');
			$('#save').val('Save');
		});
	});		
	
	$("#contactListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getContact';
		$.ajax({
			url:'contact_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#contactModal").on("shown.bs.modal", function () { 
					$('#id').val(data.id);
					$('#contact_first').val(data.contact_first);
					$('#contact_last').val(data.contact_last);
					$('#contact_company').val(data.company);	
					$('#contact_industry').val(data.industry);	
					$('#contact_budget').val(data.budget);	
					$('#contact_sales_rep').val(data.sale_rep_id);						
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Contact");
					$('#action').val('updateContact');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#contactModal").on('submit','#contactForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"contact_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#contactForm')[0].reset();
				$('#contactModal').modal('hide');				
				$('#save').attr('disabled', false);
				contactRecords.ajax.reload();
			}
		})
	});		

	$("#contactListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteContact";
		if(confirm("Are you sure you want to delete this record?")) {
			$.ajax({
				url:"contact_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					contactRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	

	$(document).on('click', '.view', function(){
		var id = $(this).attr("id");
		var action = 'getTasks';
		$.ajax({
			url:'contact_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#tasksDetails").on("shown.bs.modal", function () {
					var resultHTML = '';
					respData.data.forEach(function(item){						
						resultHTML +="<tr>";
						for (var i = 0; i < item.length; i++) {							 
							 resultHTML +="<td>"+item[i]+"</td>";
						}
						resultHTML +="</tr>";
					});					
					$('#tasksList').html(resultHTML);											
				}).modal();			
			}
		});
	});
	
});