$(document).ready(function(){	

	var leadsRecords = $('#leadsListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"leads_action.php",
			type:"POST",
			data:{action:'listLeads'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 9, 10, 11],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addLeads').click(function(){
		$('#leadsModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#leadsModal").on("shown.bs.modal", function () { 
			$('#leadsForm')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Leads");			
			$('#action').val('addLeads');
			$('#save').val('Save');
		});
	});		
	
	$("#leadsListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getLead';
		$.ajax({
			url:'leads_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#leadsModal").on("shown.bs.modal", function () { 
					$('#id').val(data.id);
					$('#lead_first').val(data.contact_first);
					$('#lead_last').val(data.contact_last);
					$('#lead_company').val(data.company);	
					$('#lead_industry').val(data.industry);	
					$('#lead_budget').val(data.budget);	
					$('#lead_status').val(data.status);						
					$('#lead_email').val(data.email);	
					$('#lead_phone').val(data.phone);	
					$('#lead_website').val(data.website);	
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Leads");
					$('#action').val('updateLeads');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#leadsModal").on('submit','#leadsForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"leads_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#leadsForm')[0].reset();
				$('#leadsModal').modal('hide');				
				$('#save').attr('disabled', false);
				leadsRecords.ajax.reload();
			}
		})
	});		

	$("#leadsListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteLead";
		if(confirm("Are you sure you want to delete this record?")) {
			$.ajax({
				url:"leads_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					leadsRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	

	$(document).on('click', '.view', function(){
		var id = $(this).attr("id");
		var action = 'getLeadsDetails';
		$.ajax({
			url:'leads_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#leadsDetails").on("shown.bs.modal", function () {
					var resultHTML = '';
					respData.data.forEach(function(item){						
						resultHTML +="<tr>";
						for (var i = 0; i < item.length; i++) {							 
							 resultHTML +="<td>"+item[i]+"</td>";
						}
						resultHTML +="</tr>";
					});					
					$('#leadsList').html(resultHTML);											
				}).modal();			
			}
		});
	});
	
});