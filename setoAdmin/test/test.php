<?
include "../../lib/hyper.php";



// 코드 생성
// 코드 규칙은  알파벳두자리(고정)회원idx(1억 - 1명까지 가능)현재시간timestamp

$midx = 2;
$iidx = 4;

if(chkMyCode($midx,$iidx) === 0){
  
  $insview = "";
  $resview = "nview";
}else{
  $insview = "nview";
  $resview = "";
  
  $mycode = getMyCode($midx,$iidx);
  $code = $mycode['mc_code'];
  $mkt_type = $mycode['mc_type'];
  $mkt_value = $mycode['mc_value'];
  
  $mkt_type == "P" ? $ttxt = "%" : $ttxt = "원";
  
  $res_txt = "선택하신 조건은 {$mkt_value}{$ttxt} 입니다.<br>발급 코드는 : {$code} 입니다";
}

?>

<style>
  .nview{display:none;}
</style>


<div>
  이거슨 상품 상세 페이지다.<br>
  여기서 이제 수수료 별 광고코드를 클릭 해 생성하고 테이블에도 입력할꺼다.<br><br>
  
  둘중 하나를 선택합시다.<br>
  <br>
  <br>
  <input type="hidden" name="iidx" value="<?=$iidx?>" />
  <input type="hidden" name="mkt_value" value="22" />

  <div class="ins_div <?=$insview?>">
    <input type="radio" id="perc" name="mkt_type" value="P" checked /><label class="mvp" for="perc">22%</label>
    <input type="radio" id="dang" name="mkt_type" value="W" /><label class="mvw" for="dang">1500원</label>
    <br>
    
    <input type="button" value="코드 생성" onclick="crtCode(<?=$midx?>)">
  </div>
  <div class="res_div <?=$resview?>"><?=$res_txt?></div>
  
  
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
  function crtCode(idx){
    if( confirm("코드 생성을 하시겠습니까?") ){
      let type = $("input[name=mkt_type]:checked").val();
      let val = $("input[name=mkt_value]").val();
      let iidx = $("input[name=iidx]").val();
      
      $.ajax({
        url : "../ajax_admin.php",
        type: "post",
        data: {"w_mode":"crtCode","midx":idx,"iidx":iidx,"mkt_type":type,"mkt_value":val},
        success: function(result){
          let json = JSON.parse(result);
          
          console.log(json);
          
          if(json.state == "Y"){
            alert("코드가 발급되었습니다.\n마이페이지 - 발급코드 메뉴에서 확인 해 주세요.");
            history.go(0);
          }else if(json.state == "J"){
            alert("이미 코드가 발급 된 상품입니다.");
            return false;
          }else{
            alert("등록 실패!");
            return false;
          }
          
        }
      })
    }
  }
  
  $("input[type=radio]").click(function (){
    let tval = $(this).val();
    let vval;
    if(tval == "P"){
      vval = $(".mvp").html();
    }else{
      vval = $(".mvw").html();
    }
    
    vval = vval.replace(/[^0-9]/,"",vval);
    $("input[name=mkt_value]").val(vval);    
    
    
  })
</script>