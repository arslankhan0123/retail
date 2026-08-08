$("#view,#view_all").on("click",function(){
	

    var from_date=document.getElementById("from_date").value;
    var to_date=document.getElementById("to_date").value;
    var customer_id=document.getElementById("customer_id").value;
    var created_by=document.getElementById("created_by").value;
    var salesman_id=document.getElementById("salesman_id").value;
    var dptid=document.getElementById("dptid").value;
    var category_id=document.getElementById("category_id").value;
    var scatid=document.getElementById("scatid").value;
    var brand_id=document.getElementById("brand_id").value;

    var show_account_receivable;
    if($("#show_account_receivable").prop("checked") == true){
        show_account_receivable=1;
    }
    else{
        show_account_receivable=0;
    }


  	if(from_date == "")
        {
            toastr["warning"]("Select From Date!");
            document.getElementById("from_date").focus();
            return;
        }
  	 
  	 if(to_date == "")
        {
            toastr["warning"]("Select To Date!");
            document.getElementById("to_date").focus();
            return;
        }
	  
	      if(this.id=="view_all"){
          var view_all='yes';
        }
        else{
          var view_all='no';
        }
      	   
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post($("#base_url").val()+"reports/show_sales_report",{created_by:created_by,customer_id:customer_id,salesman_id:salesman_id,dptid:dptid,category_id:category_id,scatid:scatid,brand_id:brand_id,view_all:view_all,from_date:from_date,to_date:to_date,store_id:$("#store_id").val(),warehouse_id:$("#warehouse_id").val(),show_account_receivable:show_account_receivable},function(result){
          //alert(result);
            setTimeout(function() {
             $("#tbodyid").empty().append(result);     
             $(".overlay").remove();
            }, 0);
           }); 
     
	
});

