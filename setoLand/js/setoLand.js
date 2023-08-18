function collectEmail(code,obj){
  let classname = obj.className;
  let number = classname.replace(/[^0-9]/gi,"");
      
  let email = $("input[name=email"+number+"]").val();
  let emailReg = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;
  let consetAgree = $('#terms'+number+':checked').val();
  if (email.length < 1) {
    return false;
  } else if (!emailReg.test(email)) {
    return false;
  }
  if (consetAgree == undefined) {
    return false;
  }
  
  // console.log(email);
  $.ajax({
    url : "../ajax_setoLand.php",
    type: "post",
    data: {"w_mode":"collectEmail","code":code,"email":email},
    success : function(result){
      let json = JSON.parse(result);
      console.log(json);
      
      if(json.state == "Y"){
        alert("정상적으로 등록 되었습니다.\n감사합니다.");
        $("input[name=email"+number+"]").val("");
      }else{
        alert("시스템 에러입니다.");
        return false;
      }
    }
  })
}

