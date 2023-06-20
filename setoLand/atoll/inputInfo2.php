<?php
include "./setofunc.php";


// 이하, 테스트용 고정 값
$midx = 1;
$sidx = 1;
$mid = "1849705C64";
$skey = "289F40E6640124B2628640168C3C5464";

$product_opt = $option;
$product_full = "{$product} {$product_opt}";
$uprice = $price;
$amount = $price;
// $uprice = 1;
// $amount = 1;
$quantity = 1;


// 모바일 체크
$mchk = chkMobile();
$mchk = "Y";


// 이전 페이지에서 받은 값으로 유저 데이터 추출
$sql = "SELECT * FROM st_member WHERE m_idx = {$midx}";
$re = sql_fetch($sql);

$mem_id = $re['m_id'];
$mem_name = $re['m_name'];
$mem_tel = $re['m_tel'];
$mem_addr = $re['m_addr'];
$mem_daddr = $re['m_daddr'];
$mem_email = $re['m_email'];

?>


<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>주문정보 입력</title>
</head>

<style>
  #wrap,
  .content {
    width: 100%;
  }
  form{width:100%}

  .cont {
    width: 80%;
    border: 1px solid #CCC;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin:0 auto;
  }

  .cont .input_div {
    display: flex;
    flex-direction: column;
    width: 70%;
    justify-content: flex-start;
    margin-bottom: 15px;
    margin:0 auto;
  }

  .input_div div {
    display: flex;
    width: 100%;
    height: 30px;
    padding: 1rem;
    align-items: center;

  }

  .input_div input[type=text] {
    width: 70%;
    margin-left: 20px;
    height: 30px
  }

  .input_div .order_input {
    border: 1px solid #EEE;
    border-radius: 5px;
    padding-left: 10px;
    color: #888
  }

  .cont .detail_div {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 70%;
    margin:0 auto;
  }

  .confirm_div {
    display: flex;
    flex-direction: column;
    margin-top: 20px;
  }

  .confirm_div div {
    display: flex;
  }

  .confirm_div .chead {
    font-size: 1.2rem;
    font-weight: 700;
    margin-right: 20px;
  }

  .confirm_div .cbody {
    margin-left: 10px;
    color: #777;
    font-size: 1.4rem;
  }

  .agree_div {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px
  }

  .agree_div .agree_txt {
    font-size: .4rem;
    color: #CCC;
    margin-bottom: 10px
  }

  .agree_div div {
    display: flex
  }

  .button_div {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 50px;
  }

  .button_div input {
    border: 1px solid #0F77BB;
    background-color: #0F77BB;
    padding: .5rem;
    width: 200px;
    height: 60px;
    color: #fff;
    font-size: 2rem;
    font-weight: 700;
    cursor:pointer;
  }
  .button_div .cbtn{
    border:1px solid #BCBCBC;
    background-color: #CECECE;
    width:100px;
    height:30px;
    font-size: .9rem;
    color:#777;
    margin-left:20px;
    padding: 0;
  }
</style>
<!-- <script src="./payments/js/ie-emulation-modes-warning.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script type="text/javascript">
  <!--
    function payment(){
      
      if(!$("#agree").is(':checked')){
        alert("동의 해 주세요.");
        return false;
      }
      
      
      let tform = new FormData($("#regForm")[0]);
      tform.append("w_mode","testDb");
      
      // 관리자 표시를 위해 DB에 우선 입력. 원래는 결제 후 입력할 처리.
      $.ajax({
        url : "setPaydata.php",
        type: "post",
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,
        data: tform,
        success: function(result){
          let json = JSON.parse(result);
          console.log(json);
        }
      })
      
      
      var frm = document.regForm;
  
      window.open("", "payment2", "resizable=yes,scrollbars=yes,width=820,height=600");
      frm.target = "payment2";
      frm.submit();
    }
  //-->
</script>

<body>
  <div id="wrap">
    <div class="content">
      <div class="cont">

        <form class="form-horizontal" id="regForm" name="regForm" method="post" action="payments/request.php">

          <!-- 개발자 추가로 세팅하는 값 -->
          <input type="hidden" name="mid" value="<?= $mid ?>" />
          <input type="hidden" name="midx" value="<?= $midx ?>" />
          <input type="hidden" name="ref" value="demo20170418202020" />
          <input type="hidden" name="displaytype" value="P" /> <!-- P:팝업 / R:디스플레이 -->
          <input type="hidden" name="ostype" value="P" /> <!-- PC -->
          <input type="hidden" name="cur" value="KRW" /> <!-- 통화 -->
          <input type="hidden" name="amt" value="<?= $amount ?>" /> <!-- 가격 -->
          <input type="hidden" name="shop" value="세토웍스" /> <!-- 구매하는 샵 이름 -->
          <input type="hidden" name="buyer" value="jun" /> <!-- 판매자 -->
          <input type="hidden" name="lang" value="KR" /> <!-- 언어 -->
          <input type="hidden" name="autoclose" value="N" /> <!-- 자동 창닫기 -->
          <input type="hidden" name="item_0_product" value="<?= $product_full ?>" /> <!-- 제품명 -->
          <input type="hidden" name="item_0_quantity" value="<?= $quantity ?>" /> <!-- 제품수량 -->
          <input type="hidden" name="item_0_unitPrice" value="<?= $uprice ?>" /> <!-- 제품 개당 가격 -->
          <input type="hidden" name="callfromapp" value="<?= $mchk ?>" /> <!-- 모바일 체크 -->
          <input type="hidden" name="popt" value="<?= $product_opt ?>" /> <!-- 제품 옵션 -->
          <input type="hidden" name="pval" value="<?= $amount ?>" /> <!-- 결제 가격 -->
          <input type="hidden" name="sidx" value="<?= $sidx ?>" /> <!-- 서비스 index -->



          <!-- 결제에 필요 한 필수 파라미터 -->
          <input type="hidden" name="ver" value="230" /><!-- 연동 버전 -->
          <input type="hidden" name="txntype" value="PAYMENT" /><!-- 거래 타입 -->
          <input type="hidden" name="charset" value="UTF-8" /><!-- 고정 : UTF-8 -->

          <!-- statusurl(필수 값) : 결제 완료 시 Back-end 방식으로 Eximbay 서버에서 statusurl에 지정된 가맹점 페이지를 Back-end로 호출하여 파라미터를 전송 -->
          <!-- 스크립트, 쿠키, 세션 사용 불가 -->
          <!-- 결제완료시, 리턴url로 이동. status는 백으로 호출만하니까 보여지지않음. 완료페이지는 리턴으로 변경할것. -->
          <input type="hidden" name="statusurl" value="http://silencecorner.kr/payments/payments/status.php" />
          <input type="hidden" name="returnurl" value="http://silencecorner.kr/payments/payments/return.php" />
          <!--결제 완료 시 Front-end 방식으로 사용자 브라우저 상에 호출되어 보여질 가맹점 페이지 -->


          <!-- 배송지 파라미터(선택) -->
          <input type="hidden" name="shipTo_country" value="US" />
          <input type="hidden" name="shipTo_city" value="Mountain View" />
          <input type="hidden" name="shipTo_state" value="CA" />
          <input type="hidden" name="shipTo_street1" value="100 Elm Street" />
          <input type="hidden" name="shipTo_postalCode" value="94043" />
          <input type="hidden" name="shipTo_phoneNumber" value="1234" />
          <input type="hidden" name="shipTo_firstName" value="First Name" />
          <input type="hidden" name="shipTo_lastName" value="Last Name" />

          <!-- 청구지 파라미터 (선택) -->
          <input type="hidden" name="billTo_city" value="" />
          <input type="hidden" name="billTo_country" value="" />
          <input type="hidden" name="billTo_firstName" value="" />
          <input type="hidden" name="billTo_lastName" value="" />
          <input type="hidden" name="billTo_phoneNumber" value="" />
          <input type="hidden" name="billTo_postalCode" value="" />
          <input type="hidden" name="billTo_state" value="" />
          <input type="hidden" name="billTo_street1" value="" />

          <!-- 결제 응답 값 처리 파라미터 -->
          <input type="hidden" name="rescode" />
          <input type="hidden" name="resmsg" />

          <div class="input_div">
            <div><span>ID :</span> <input type="text" id="mem_id" name="mem_id" class="order_input"
                value="<?= $mem_id ?>" readonly /></div>
            <div><span>이름 :</span> <input type="text" id="mem_name" name="mem_name" class="order_input"
                value="<?= $mem_name ?>" readonly /></div>
            <div><span>연락처 :</span> <input type="text" id="mem_tel" name="tel" class="order_input"
                value="<?= $mem_tel ?>" readonly /></div>
            <div><span>이메일 :</span> <input type="text" id="mem_email" name="email" class="order_input"
                value="<?= $mem_email ?>" readonly /></div>
            <div><span>주소 :</span> <input type="text" id="mem_addr" name="mem_addr" class="order_input"
                value="<?= $mem_addr ?>" readonly /></div>
            <div><span>상세주소 :</span> <input type="text" id="mem_daddr" name="mem_daddr" class="order_input"
                value="<?= $mem_daddr ?>" readonly /></div>
          </div>
          <div class="detail_div">
            <div class="confirm_div">
              <div><span class="chead">상품명</span><span class="cbody">
                  <?= $product ?>
                </span></div>
              <div><span class="chead">옵션</span><span class="cbody">
                  <?= $product_opt ?>
                </span></div>
              <div><span class="chead">결제가격</span><span class="cbody">
                  <?= $amount ?>
                </span></div>
            </div>
            <div class="agree_div">
              <span class='agree_txt'>환불, 교환 절대 안됨. 7일내 그런거 없음. 안됨. 배 째!</span>
              <div><input type="checkbox" id="agree" class="chkbox" /><label for="agree">구매 관련 주의사항을 확인했고, 동의합니당</label>
              </div>
            </div>

          </div>
          <div class="button_div">
            <input type="button" value="결제하기" onclick="payment();" />
            <input type="button" class='cbtn' value="취소" onclick="history.go(-1);" />
          </div>
        </form>
        
      </div>
    </div>
  </div>




</body>

</html>