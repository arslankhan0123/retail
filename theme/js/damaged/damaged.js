function shift_cursor(kevent,target){
    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
}

$('#save,#update').on("click",function (e) {
	var base_url=$("#base_url").val();
    var flag=true;

    function check_field(id)
    {
      if(!$("#"+id).val() )
        {
            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
        }
    }

    check_field("damaged_date");

	if(flag==false)
	{
		toastr["error"]("You have missed Something to Fillup!");
		return;
	}

    var rowcount=document.getElementById("hidden_rowcount").value;
	var flag1=false;
	for(var n=1;n<=rowcount;n++){
		if($("#td_data_"+n+"_3").val()!=null && $("#td_data_"+n+"_3").val()!=''){
			flag1=true;
		}	
	}
	
    if(flag1==false){
    	toastr["warning"]("Please Select Item!!");
        $("#item_search").focus();
		return;
    }
    
    var this_id=this.id;
	e.preventDefault();
	data = new FormData($('#damaged-form')[0]);
	
	if(!xss_validation(data)){ return false; }
	
	$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
	$("#"+this_id).attr('disabled',true);
	$.ajax({
	type: 'POST',
	url: base_url+'damaged/damaged_save_and_update?command='+this_id+'&rowcount='+rowcount,
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	success: function(result){
		result=result.split("<<<###>>>");
		if(result[0]=="success")
		{
			location.href=base_url+"damaged/details/"+result[1];
		}
		else if(result[0]=="failed")
		{
		   toastr['error']("Sorry! Failed to save Record.Try again");
		}
		else
		{
			alert(result);
		}
		$("#"+this_id).attr('disabled',false);
		$(".overlay").remove();
	}
	});
});

$("#item_search").bind("paste", function(e){
    $("#item_search").autocomplete('search');
});

$("#item_search").autocomplete({
    source: function(data, cb){
        $.ajax({
            autoFocus:true,
            url: $("#base_url").val()+'items/get_json_items_details',
            method: 'GET',
            dataType: 'json',
            data: {
                name: data.term,
                store_id:$("#store_id").val(),
                warehouse_id:$("#warehouse_id").val(),
                search_for:"purchase",
            },
            beforeSend: function() {
                if($("#warehouse_id").val()==''){
                  toastr['warning']("Please Select Wareshouse!");
                  $("#warehouse_id").select2('open');
                  $("#item_search").removeClass('ui-autocomplete-loading');
                  return;
                }
                $("#item_search").addClass('ui-autocomplete-loading');
            },
            success: function(res){
                var result;
                result = [
                    {
                        label: 'No Records Found ',
                        value: ''
                    }
                ];

                if (res.length) {
                    result = $.map(res, function(el){
                        return {
                            label: el.item_code +'--'+ el.label,
                            value: '',
                            id: el.id,
                            item_name: el.value,
                        };
                    });
                }
                cb(result);
            }
        });
    },
    response:function(e,ui){
      if(ui.content.length==1){
        $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
        $(this).autocomplete("close");
      }
    },
    select: function (e, ui) { 
        if(typeof ui.content!='undefined'){
          if(isNaN(ui.content[0].id)){
            return;
          }
          var item_id=ui.content[0].id;
        }
        else{
          var item_id=ui.item.id;
        }
        return_row_with_data(item_id);
        $("#item_search").val('');
    },   
});

function check_same_item(item_id){
  if($("#damaged_table tr").length>1){
    var rowcount=$("#hidden_rowcount").val();
    for(i=0;i<=rowcount;i++){
        if($("#tr_item_id_"+i).val()==item_id){
          increment_qty(i);
          failed.currentTime = 0;
          failed.play();
          return false;
        }
    }
  }
  return true;
}

function return_row_with_data(item_id){
  var item_check=check_same_item(item_id);
  if(!item_check){return false;}
  
  $("#item_search").addClass('ui-autocomplete-loader-center');
	var base_url=$("#base_url").val();
	var rowcount=$("#hidden_rowcount").val();
	$.post(base_url+"damaged/return_row_with_data/"+rowcount+"/"+item_id,{},function(result){
        $('#damaged_table tbody').append(result);
       	$("#hidden_rowcount").val(parseInt(rowcount)+1);
        success.currentTime = 0;
        success.play();
        final_total();
        $("#item_search").removeClass('ui-autocomplete-loader-center');
        $("#item_search").removeClass('ui-autocomplete-loading');
    }); 
}

function increment_qty(rowcount){
  var item_qty=$("#td_data_"+rowcount+"_3").val();
    item_qty=parseFloat(item_qty)+1;
    $("#td_data_"+rowcount+"_3").val(format_qty(item_qty));
  final_total();
}

function decrement_qty(rowcount){
  var item_qty=$("#td_data_"+rowcount+"_3").val();
  if (parseFloat(item_qty) <= 1) {
     return;
  }
  $("#td_data_"+rowcount+"_3").val((parseFloat(item_qty)-1));
  final_total();
}

function delete_damaged(q_id)
{
    var base_url=$("#base_url").val();
    if(confirm("Do You Wants to Delete Record ?")){
      $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
      $.post(base_url+"damaged/delete_damaged",{q_id:q_id},function(result){
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
    var this_id=this.id;
    var base_url=$("#base_url").val();
    if(confirm("Are you sure ?")){
      data = new FormData($('#table_form')[0]);
      if(!xss_validation(data)){ return false; }
      
      $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
      $("#"+this_id).attr('disabled',true);
      $.ajax({
      type: 'POST',
      url: base_url+'damaged/multi_delete',
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

$('#item_search').keypress(function (e) {
  var key = e.which;
  if(key == 13){
    $("#item_search").autocomplete('search');
  }
});  
