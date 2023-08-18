<?
  
?>

<input type="text" name="email" />
<input type="button" value="접수" onclick="collectEmail('dB24_319vJkkeveguUg',this)" />


<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
  function collectEmail(code){
    let email = $("input[name=email]").val();
    $.ajax({
      url : "../ajax_admin.php",
      type: "post",
      data: {"w_mode":"collectEmail","code":code,"email":email},
      success : function(result){
        let json = JSON.parse(result);
        console.log(json.state);
      }
    })
  }
</script>