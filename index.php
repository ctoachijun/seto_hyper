<?php
 
  include "./lib/db_config.php";
  
  
    
  
   
?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  $(function(){
    $("#submitbtn").on("click",function(){
      if(!$('#id').val()){
        alert("ID를 입력 해 주세요.");
        $("#id").focus();
        return false;
      }
      if(!$("#pw").val()){
        alert("비밀번호를 입력 해 주세요");
        $("#pw").focus();
        return false;
      }
      
      let id = $("#id").val();
      let pw = $("#pw").val();
      
      $.ajax({
        url : "ajax_hyper.php",
        type: "post",
        data: {"w_mode":"adminChk","id":id,"pw":pw}
      }).done(function (result){
        let json = JSON.parse(result);

        if(json.state == "N"){
          alert("계정정보를 확인 해 주세요");
          return false;
        }else{
          alert("계정정보 맞음");
        }
        
      }).always(function(always){
      })
      
    })
  });
    
  
</script>
  


<form method="post" id="adminInfo">
  <input type="text" name="id" id="id" />
  <input type="password" name="pw" id="pw" />
  <input type="button" id="submitbtn" value="전송" />
</form>
