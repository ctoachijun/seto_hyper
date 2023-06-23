
// 검색시 페이지는 무조건 1페이지
function chgCurPage(){
  $("input[name=cur_page]").val(1);
  // $("form").submit();
  return true;
}  
  
function downExcel(code,admin){
  if(confirm("엑셀파일로 다운로드 하시겠습니까?")){
    let type = $("select[name=type").val();
    let sw = $("input[name=sw").val();
    
    $(".top_div").append("<form id='exceldown' action='excelDownload.php' method='post'>");
    $("#exceldown").append("<input type='hidden' name='code' value='"+code+"' />");
    $("#exceldown").append("<input type='hidden' name='admin' value='"+admin+"' />");
    $("#exceldown").append("<input type='hidden' name='type' value='"+type+"' />");
    $("#exceldown").append("<input type='hidden' name='sw' value='"+sw+"' />");
    $("#exceldown").append("</form>");
    $("#exceldown").submit();
    
    // $("#exceldown").remove();
  }
}  

function setBrandList(obj){
  let val = obj.value;
  $(".top_div").append("<form method='post' id='bform'></form>");
  $("#bform").append("<input type='hidden' name='maker_idx' value='"+val+"' />");
  // $("#bform").append("</form>");
  $("#bform").submit();
}

function searchBrand(){
  let brand = $("input[name=sw").val();
  let aidx = $("#maker_select").val();

  $(".top_div").append("<form method='post' id='bform'></form>");
  $("#bform").append("<input type='hidden' name='maker_idx' value='"+aidx+"' />");
  $("#bform").append("<input type='hidden' name='sw' value='"+brand+"' />");
  $("#bform").submit();
}

function showRegPopup(){
  $("#backblack").show();
  $(".regpop").show();
}

function chkBrandName(obj){
  $.ajax({
    url: "ajax_admin.php",
    type: "post",
    data: {"w_mode":"chkBrandName","bname":obj.value},
    success: function(result){
      let json = JSON.parse(result);
      if(json.state == "Y"){
        alert("이미 등록되어 있는 브랜드명 입니다.");
        $("#bname").val("");
        $("#bname").focus();
      }
    }
  })
}

function regBrand(){
  console.log();
  if(!$("#logo_file")[0].files[0]){
    alert("로고 이미지를 등록 해 주세요.");
    clickFile();
    return false;
  }
  if(!$("input[name=bname").val() || $("#bname").val() == ""){
    alert("브랜드명을 입력 해 주세요.");
    $("#bname").focus();
    return false;
  }
  if(!$("#bdesc" || $("#bdesc").val() == "").val()){
    alert("간단 소개를 입력 해 주세요.");
    $("#bdesc").focus();
    return false;
  }
  
  
  if(confirm("브랜드를 등록 하시겠습니까?")){
    let f = new FormData($("#regForm")[0]);
    f.append("w_mode","regBrand");
    console.log(f);
    $.ajax({
      url : "ajax_admin.php",
      type : "post",
      processData: false,
      contentType: false,
      data : f,
      success : function(result){
        let json = JSON.parse(result);
        console.log(json);
        
        if(json.state == "FN"){
          alert("파일 업로드에 실패했습니다.\n지속 될 경우 문의주세요.");
          return false;
        }else if(json.state == "N"){
          alert("시스템 오류입니다.\n고객센터로 문의 부탁드립니다.");
        }else{
          alert("정상 등록 되었습니다.");
          history.go(0);
          // $(".regpop").hide();
          // $("#backblack").hide();
          // $("#bname").val("");
          // $("#bdesc").val("");
          // $("#regimg").html("로고<br>클릭 후 등록");
          // $("#logo_file").remove();
          // $(".pop_input1").append("<input type='file' id='logo_file' name='logo' onchange='setThumbnail(event);' />");
        }
      },
      error : function(err){
        console.log(err);
      }
    })
  }



}






/*

  공통적으로 사용되는 함수

*/

// 이미지 업로드시 파일 업로드 없이 바로 미리보기
function setThumbnail(event) {
  for (var image of event.target.files) {
    var reader = new FileReader();

    reader.onload = function(event) {
      var img = document.createElement("img");
      img.setAttribute("src", event.target.result);
      img.setAttribute("width","95%");
      img.setAttribute("height","90%");
      document.querySelector("div#regimg").innerHTML="";
      document.querySelector("div#regimg").appendChild(img);
    };

    console.log(image);
    reader.readAsDataURL(image);
  }
}

function onlyNum(obj){
  let val1;
  val1 = obj.value;
  val1 = val1.replace(/[^0-9]/g,"");
  obj.value = val1;
}

function onlyNumComm(obj){
  let re = obj.value;
  re = re.replace(/[^0-9\.]/g,'');
  // console.log(re);
  obj.value = re;
}

function onlyNumShim(obj){
  let re = obj.value;
  re = re.replace(/[^0-9\,]/g,'');
  // console.log(re);
  obj.value = re;
}

function onlyNumBar(obj){
  let re = obj.value;
  re = re.replace(/[^0-9\-]/g,'');
  // console.log(re);
  obj.value = re;
}

function onlyAmount(obj){
 let val1;
 val1 = obj.value;
 val1 = addComma(val1.replace(/[^0-9]/g,""));
 obj.value = val1;
}

function addComma(value){
    value = String(value);
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return value;
 }

function removeComma(str){
	let n = parseInt(str.replace(/,/g,""));
	return n;
}

function chkEmailType(email) {
  let re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  return re.test(email);
}

function chkEnNum(obj){
  let re = obj.value;
  re = re.replace(/[^a-zA-Z\.]/g,'');
  obj.value = re;
}

function chkNoKo(obj){
  let re = obj.value;
  re = re.replace(/[ㄱ-ㅎ||ㅏ-ㅣ||가-힣]/g,'');
  obj.value = re;
}

function pageBack(){
  history.go(-1);
}

function chkSpace(obj){
    let id = obj.id;
    let val = obj.value;
    val = val.replace(/\s/gi,"");

    $("#"+id).val(val);
}

function chkSpaceFe(obj){
    let id = obj.id;
    let val = obj.value;
    val = val.replace(/(^\s+)|(\s*$)/gi,"");

    $("#"+id).val(val);
}

function noHttp(obj){
  let id = obj.id;
  let val = obj.value;
  val = val.replace(/http:\/\/|https:\/\//,"");

  $("#"+id).val(val);
}

function onlyEnKi(obj){
  let id = obj.id;
  let val = obj.value;
  val = val.replace(/[^a-zA-Z0-9!@#$%^&*()\'\"-_.,\s]/gi,"");

  $("#"+id).val(val);
}
