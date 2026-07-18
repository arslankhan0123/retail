function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,9}|[0-9]{1,3})(\]?)$/;
    return filter.test(sEmail);
}

$('#save,#update').on("click",function (e) {
	var base_url=$("#base_url").val();
    var flag=true;

    function check_field(id)
    {
      if(!$("#"+id).val())
        {
            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
        }
    }

	check_field("employee_id");
	check_field("employee_name");
	check_field("joining_date");
	check_field("basic_salary");
	check_field("iqama_no");

    var email=$("#email").val();
    if (email!='' && !validateEmail(email)) {
        $("#email_msg").html("Invalid Email!").show();
        flag=false;
    } else {
        $("#email_msg").html("").hide();
    }

	if(flag==false)
    {
		toastr["warning"]("You have Missed Something to Fillup!");
		return;
    }

    var this_id=this.id;
    e.preventDefault();
    data = new FormData($('#employees-form')[0]);
    if(!xss_validation(data)){ return false; }
    
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $("#"+this_id).attr('disabled',true);

    var url = (this_id=="save") ? base_url+'employees/newemployees' : base_url+'employees/update_employees';

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(result){
            if(result=="success")
            {
                window.location=base_url+"employees";
            }
            else if(result=="failed")
            {
                toastr['error']("Sorry! Failed to save Record. Try again");
            }
            else
            {
                toastr['error'](result);
            }
            $("#"+this_id).attr('disabled',false);
            $(".overlay").remove();
       }
   });
});

function shift_cursor(kevent,target){
    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
}

function update_status(id,status)
{
	var base_url=$("#base_url").val();
	$.post(base_url+"employees/update_status",{id:id,status:status},function(result){
		if(result=="success")
		{
			toastr["success"]("Status Updated Successfully!");
			success.currentTime = 0; 
			success.play();
			if(status==0)
			{
				status="Inactive";
				var span_class="label label-danger";
				$("#span_"+id).attr('onclick','update_status('+id+',1)');
			}
			else{
				status="Active";
				var span_class="label label-success";
				$("#span_"+id).attr('onclick','update_status('+id+',0)');
			}

			$("#span_"+id).attr('class',span_class);
			$("#span_"+id).html(status);
			return false;
		}
		else if(result=="failed"){
			toastr["error"]("Failed to Update Status.Try again!");
			failed.currentTime = 0; 
			failed.play();
			return false;
		}
		else{
			toastr['error'](result);
			failed.currentTime = 0; 
			failed.play();
			return false;
		}
	});
}

function delete_employees(q_id)
{
	var base_url=$("#base_url").val();
	if(confirm("Do You Wants to Delete Record ?")){
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.post(base_url+"employees/delete_employees",{q_id:q_id},function(result){
			if(result=="success")
			{
				toastr["success"]("Record Deleted Successfully!");
				$('#example2').DataTable().ajax.reload();
			}
			else if(result=="failed"){
				toastr["error"]("Failed to Delete .Try again!");
			}
			else{
				toastr["error"](result);
			}
			$(".overlay").remove();
			return false;
		});
	}
}

function multi_delete(){
	var base_url=$("#base_url").val();
	var this_id=this.id;
    
	if(confirm("Are you sure ?")){
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$("#"+this_id).attr('disabled',true);
		
		data = new FormData($('#table_form')[0]);
		$.ajax({
			type: 'POST',
			url: base_url+'employees/multi_delete',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				if(result=="success")
				{
					toastr["success"]("Record Deleted Successfully!");
					success.currentTime = 0; 
					success.play();
					$('#example2').DataTable().ajax.reload();
					$(".delete_btn").hide();
					$(".group_check").prop("checked",false).iCheck('update');
				}
				else if(result=="failed")
				{
					toastr["error"]("Sorry! Failed to save Record.Try again!");
					failed.currentTime = 0; 
					failed.play();
				}
				else
				{
					toastr["error"](result);
					failed.currentTime = 0; 
					failed.play();
				}
				$("#"+this_id).attr('disabled',false);
				$(".overlay").remove();
		   }
	   });
	}
}

// Add/Remove documents repeater fields
$(document).ready(function() {
    var doc_row_index = 1;
    $(document).on('click', '.add_doc_row', function() {
        var tr = `
            <tr id="doc_row_${doc_row_index}">
                <td>
                    <input type="text" name="doc_name[]" class="form-control" placeholder="Document Title / Name" required>
                </td>
                <td>
                    <input type="file" name="doc_file[]" class="form-control" required accept=".pdf,.png,.jpg,.jpeg">
                </td>
                <td>
                    <input type="text" name="doc_expiry[]" class="form-control datepicker" placeholder="dd-mm-yyyy" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger remove_doc_row" data-row-id="${doc_row_index}"><i class="fa fa-minus"></i></button>
                </td>
            </tr>`;
        $('#documents_table tbody').append(tr);
        
        // Re-initialize Datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true
        });

        doc_row_index++;
    });

    $(document).on('click', '.remove_doc_row', function() {
        var id = $(this).attr('data-row-id');
        $('#doc_row_' + id).remove();
    });
});

function delete_existing_doc(doc_id) {
    var base_url=$("#base_url").val();
    if(confirm("Do You Wants to Delete this Document?")){
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post(base_url+"employees/delete_doc",{doc_id:doc_id},function(result){
            if(result=="success")
            {
                toastr["success"]("Document Deleted Successfully!");
                $('#existing_doc_' + doc_id).remove();
            }
            else {
                toastr["error"]("Failed to Delete Document. Try again!");
            }
            $(".overlay").remove();
        });
    }
}
