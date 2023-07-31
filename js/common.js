


/*

  공통적으로 사용되는 함수

*/

// 이미지 업로드시 파일 업로드 없이 바로 미리보기
function setThumbnail(event,did) {
  let file = event.target.files[0];
  
  if(chkFileType(file,2)){
    var reader = new FileReader();
  
      reader.onload = function(e) {
        // $('#'+did).html("");
        $('#'+did).css({"background": "url('"+e.target.result+"') 50% 50%"});
        $('#'+did).css({'background-repeat': 'no-repeat'});
        $('#'+did).css({'background-size': 'contain'});
      };
  
      reader.readAsDataURL(file);
  }else{
    alert("이미지 파일만 업로드 가능합니다.");
    return false;
  }
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
  console.log(email);
  let re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  return re.test(email);
}

function chkEnNum(obj){
  let re = obj.value;
  re = re.replace(/[^a-zA-Z0-9\.]/g,'');
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


// 카카오 주소
function openPost(){
  let width = 500;
  let height = 500;

  new daum.Postcode({
    width: width,
    height: height,
    oncomplete: function(data) {
      let post = data.zonecode;
      let jaddr = data.jibunAddress;
      let jaddr_en = data.jibunAddressEnglish;
      let raddr = data.roadAddress;
      let raddr_en = data.roadAddressEnglish;

      if(!jaddr){
        jaddr = data.autoJibunAddress;
        jaddr_en = data.autoJibunAddressEnglish;
      }
      // console.log(data);
      $("input[name=postcode]").val(post);
      $("input[name=addr]").val(raddr);
    },
    onsearch: function(data){
      animation: "true"
    }

  }).open({
    popupName: 'searchAddr',
    left: (width + 300) - (window.screen.width),
    top: (window.screen.height / 2) - (height / 2)

  });
}

function setMktType(num){
  $(".by").removeClass("bdact");
  $(".dg").removeClass("bdact");
  $(".yu").removeClass("vhide");
  $(".dn").removeClass("vhide");

  if(num == 1){
    $(".by").addClass("bdact");
    $(".dn").addClass("vhide");
    $("input[name=mkt_type]").val("P");
  }else{
    $(".dg").addClass("bdact");
    $(".yu").addClass("vhide");
    $("input[name=mkt_type]").val("W");
  }
}
