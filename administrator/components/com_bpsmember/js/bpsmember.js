$(document).ready(function(){
    $("#jform_user").blur(function(fld){
        var val_data= $(this).val();
        
        var name_data= $(this).attr("name");
        name_data = name_data.replace('jform[','');
        name_data = name_data.replace(']','');
       // console.debug(val);
       $.ajax({
        type: "POST",
        url:"index.php?option=com_bpsmember&task=bpsmember.checkuser",
        data:{
            name:name_data,
            value:val_data
        },
        success:function(data){
            if(data=="true"){
               $(".clss_user span.inputbox_mess").append().addClass("error");
               $(this).focus();
               }
               else{
                $(".clss_user span").append().removeClass("error"); 
            }
                // console.debug(data);
        }
       });
    });
  // &layout=edit
})