
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

function chkBrandNameEdit(obj,org){
  $.ajax({
    url: "ajax_admin.php",
    type: "post",
    data: {"w_mode":"chkBrandNameEdit","bname":obj.value, "org":org},
    success: function(result){
      let json = JSON.parse(result);
      if(json.state == "Y"){
        alert("이미 등록되어 있는 브랜드명 입니다.");
        // $("#bname").val("");
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
          $(".regpop").hide();
          $("#backblack").hide();
          $("#bname").val("");
          $("#bdesc").val("");
          $("#regimg").html("로고<br>클릭 후 등록");
          $("#logo_file").remove();
          $(".pop_input1").append("<input type='file' id='logo_file' name='logo' onchange='setThumbnail(event,'regimg');' />");
          return false;
        }else if(json.state == "N"){
          // alert("시스템 오류입니다.\n고객센터로 문의 부탁드립니다.");
          errorAlert();
        }else{
          alert("정상 등록 되었습니다.");
          history.go(0);
        }
      },
      error : function(err){
        console.log(err);
      }
    })
  }
}

function editBrand(){
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
  
  
  if(confirm("브랜드 정보를 수정 하시겠습니까?")){
    let f = new FormData($("#brandForm")[0]);
    f.append("w_mode","editBrand");
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
          // alert("시스템 오류입니다.\n고객센터로 문의 부탁드립니다.");
          errorAlert();
        }else{
          alert("수정 되었습니다.");
          $(".brand_title").html(json.bname);
          // $("#bname").val(json.bname);
          // $("#bdesc").val(json.bdesc);
          $("#logo_file").remove();
          $("#brandForm").append("<input type='file' id='logo_file' name='logo' onchange='setThumbnail(event);' />");
        }
      },
      error : function(err){
        console.log(err);
      }
    })
  }
}

function delBrand(){
  let bidx = $("input[name=brand_index").val();
  let bname = $("input[name=org_bname").val();
 
  if(confirm(bname+" 브랜드를 삭제 하시려면 확인 버튼을 눌러주세요.\n등록된 상품도 모두 삭제됩니다.\n삭제 후 복구는 불가하니 주의 해 주세요.")){
    $.ajax({
      url : "ajax_admin.php",
      type: "post",
      data: {"w_mode":"delBrand","bidx":bidx,"bname":bname},
      success: function(result){
        let json = JSON.parse(result);
        console.log(json);
        
        if(json.state == "Y"){
          alert("정상 처리되었습니다.");
          location.replace("./admin_brandList.php");
        }else{
          errorAlert();
          return false;
        }
      }
    })
  }
  
}

function goBrandDetail(bidx){
  let bdform = $("#regForm");
  bdform.append("<input type='hidden' name='bidx' value='"+bidx+"'>");
  bdform.attr("action","admin_itemList.php");
  bdform.submit();
}

function goRegItem(bidx){
  let itform = $("#ilist");
  itform.attr("action","admin_itemDetail.php");
  itform.submit();
}

function setKeyWord(){
  let org_kw = $("input[name=keyword_txt").val();
  let new_kw = $("input[name=kw").val();
  let kw_txt = "";
  
  if(!new_kw){
    alert("키워드를 입력 해 주세요");
    return false;
  }
  
  if(!org_kw){
    console.log("키워드 없었던거임");
    kw_txt = new_kw;
  }else{
    let karr = org_kw.split("|");
  
    if(karr.length == 10){
      alert("키워드는 10개까지 등록 가능합니다.");
      $("#kw").val("");
      return false;
    }
  
    // console.log($.inArray(new_kw,karr));
    // console.log(karr);
    if($.inArray(new_kw,karr) > -1){
      alert("중복 된 키워드 입니다.");
      $("#kw").val("");
      return false;
    }
      
    karr.push(new_kw);
    kw_txt = karr.join("|");
  }

  $("input[name=keyword_txt").val(kw_txt);
  
  // 키워드 html 처리
  $.ajax({
    url : "ajax_admin.php",
    type: "post",
    data: {"w_mode":"setKeyWord","keyword":kw_txt},
    success : function(result){
      let json = JSON.parse(result);
      $(".key_box").html(json.html);      
      $("#kw").val("");
      $("#kw").focus();
    }
  })
}

function keywordDel(num){
  let org_kw = $("input[name=keyword_txt").val();
  console.log("num : "+num);
  $.ajax({
    url : "ajax_admin.php",
    type: "post",
    data: {"w_mode":"keywordDel","cnum":num,"keyword":org_kw},
    success: function(result){
      let json = JSON.parse(result);
      console.log(json);
      
      $(".key_box").html(json.html);
      $("input[name=keyword_txt").val(json.new_kw);
    }
  })
}

function cancelReturn(){
  let rp = $("input[name=return_page").val();
  location.href=rp;
}

function regItem(type){

  if(!$("#pname").val()){
    alert("상품명을 입력 해 주세요.");
    $("#pname").focus();
    return false;
  }
  if(!$(".thumbimg")[0].files[0]){
    alert("대표 이미지를 등록 해 주세요.");
    $(".thumbimg").click();
    return false;
  }
  
  // 기간에 대해서는 별도 독자적으로 체크. 
  // 기본값은 랜딩 즉시 적용
  
  if(!$("#price").val()){
    alert("가격을 입력 해 주세요.");
    $("#price").focus();
    return false;
  }
  if(!$("#odate").val().trim()){
    alert("주문 시작일을 입력 해 주세요.");
    $("#odate").focus();
    return false;
  }
  if(!$("#edate").val().trim()){
    alert("주문 종료일을 입력 해 주세요.");
    $("#edate").focus();
    return false;
  }
  if(!$("#quan").val()){
    alert("수량을 입력 해 주세요");
    $("#quan").focus();
    return false;
  }
  // if(!$("#moq").val()){
  //   alert("최소 수량을 입력 해 주세요");
  //   $("#moq").focus();
  //   return false;
  // }
  if($("#dcomp").val() == "ALL"){
    alert("배송업체를 선택 해 주세요");
    return false;
  }
  if(!$("#dydate").val().trim()){
    alert("배송 예정일을 입력 해 주세요.");
    $("#dydate").focus();
    return false;
  }    
  if(!$("#dval").val()){
    alert("배송비를 선택 해 주세요");
    $("#dval").focus();
    return false;
  }  
  
  
  
  if(confirm("상품을 등록 하시겠습니까?")){
    let f = new FormData($("#itemForm")[0]);
    f.append("w_mode","regItem");
    f.append("reg_type",type);
    
    $.ajax({
      url : "ajax_admin.php",
      type: "post",
      processData: false,
      contentType: false,
      data: f,
      success: function(result){
        let json = JSON.parse(result);
        console.log(json);
        
        if(json.state == "Y"){
          alert('등록 되었습니다.');
          location.href = json.returnurl;
        }else if(json.state == "NI"){
          alert("대표 이미지가 누락되었습니다.\n재등록 부탁드립니다.\n지속될 경우 고객센터로 문의 주세요.");
          return false;
        }else{
          errorAlert();
        }
      }
    })
  }
  
  
}







/*

  공통적으로 사용되는 함수

*/

// 이미지 업로드시 파일 업로드 없이 바로 미리보기
function setThumbnail(event,did) {
  let file = event.target.files[0];
  var reader = new FileReader();

    reader.onload = function(e) {
      // $('#'+did).html("");
      $('#'+did).css({"background": "url('"+e.target.result+"') 50% 50%"});
      $('#'+did).css({'background-repeat': 'no-repeat'});
      $('#'+did).css({'background-size': 'contain'});
    };

    reader.readAsDataURL(file);
}


function closeModal(cname){
  $("."+cname).hide();
  $("#backblack").hide();
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

function goList(target){
  location.href="./"+target;
}

function maxLengthCheck(object){
  if (object.value.length > object.maxLength){
    object.value = object.value.slice(0, object.maxLength);
  }    
}

function errorAlert(){
  alert("시스템 오류입니다.\n반복 될 경우 고객센터로 문의 주세요.");
}