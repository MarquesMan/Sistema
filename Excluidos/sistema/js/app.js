$(document).ready(function(){

	$("input").each(function(){
		if($(this).attr("boolt") == 1){
			$(this).addClass('btn btn-danger');
		}
		else if($(this).attr("boolt") == 0){

		}
	});


});

function reply_click(ArrayofBool,param,clicked_id)
{	
	if(ArrayofBool[clicked_id]==0){
		$(param).addClass('btn btn-danger');
		ArrayofBool[clicked_id]=1;
	}
	else{
		$(param).removeClass('btn btn-danger');
		ArrayofBool[clicked_id]=0;
	}
}

function btload(ArrayofBool,param,clicked_id)
{	
	alert("Nome:"+clicked_id+"Data:"+ArrayofBool[clicked_id])
	if(ArrayofBool[clicked_id]==1){
		$(param).addClass('btn btn-danger');
	}

}

function reprove(dataObject)
{
   $.post("save-bool.php",
	 dataObject,
  function(data,status){
    alert("Data: " + data + "\nStatus: " + status);
  
  });
}

$(document).ready(function(){

	$(hideshow).attr("disabled","disabled").css("cursor", "default");

});