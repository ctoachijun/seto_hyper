<?php
include "./setofunc.php";

// 이하, 테스트용 고정 값
$midx = 1;
$mid = "1849705C64";
$skey = "289F40E6640124B2628640168C3C5464";

$arr_product = array("살아 숨쉬는 숯 깔창", "미쳐 날뛰는 키보드", "힛 더 마우스", "오 마마 미어캣");
$arr_opt = array("유선", "무선", "기계식", "무소음", "3cm", "5cm", "10cm","3마리", "10마리");
$arr_amt = array("1500", "81000", "25000", "8900", "169000", "55000");

$product = $arr_product[array_rand($arr_product)];
$product_opt = $arr_opt[array_rand($arr_opt)];
$amount = $arr_amt[array_rand($arr_amt)];



// 이전 페이지에서 받은 값으로 유저 데이터 추출
$sql = "SELECT * FROM st_member WHERE m_idx = {$midx}";
$re = sql_fetch($sql);

$mem_id = $re['m_id'];
$mem_name = $re['m_name'];
$mem_tel = $re['m_tel'];
$mem_addr = $re['m_addr'];
$mem_daddr = $re['m_daddr'];


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

  .cont {
    width: 80%;
    border: 1px solid #CCC;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .cont .input_div {
    display: flex;
    flex-direction: column;
    width: 70%;
    justify-content:flex-start;
    margin-bottom:15px;
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
    width: 70%
  }
  
  .confirm_div{
    display:flex;
    flex-direction:column;
    margin-top:20px;
  }
  .confirm_div div{
    display:flex;
  }
  .confirm_div .chead{
    font-size:1.2rem;
    font-weight:700;
    margin-right:20px;
  }
  .confirm_div .cbody{
    margin-left:10px;
    color:#777;
    font-size:1.4rem;
  }
  .agree_div{display:flex;flex-direction:column;align-items:center;margin-top:20px} 
  .agree_div .agree_txt{font-size:.4rem;color:#CCC;margin-bottom:10px}
  .agree_div div{display:flex}
  .button_div{
    display:flex;
    justify-content: center;
    align-items: center;
    margin-top:50px;
  }
  .button_div input{
    border:1px solid #0F77BB;
    background-color:#0F77BB;
    padding:.5rem;
    width:200px;
    height:60px;
    color:#fff;
    font-size:2rem;
    font-weight:700;
  }
</style>


<body>
  <div id="wrap">
    <div class="content">
      <div class="cont">
        <div class="input_div">
          <div><span>ID :</span> <input type="text" id="mem_id" name="mem_id" class="order_input" value="<?= $mem_id ?>"
              readonly /></div>
          <div><span>이름 :</span> <input type="text" id="mem_name" name="mem_name" class="order_input"
              value="<?= $mem_name ?>" readonly /></div>
          <div><span>연락처 :</span> <input type="text" id="mem_tel" name="mem_tel" class="order_input"
              value="<?= $mem_tel ?>" readonly /></div>
          <div><span>주소 :</span> <input type="text" id="mem_addr" name="mem_addr" class="order_input"
              value="<?= $mem_addr ?>" readonly /></div>
          <div><span>상세주소 :</span> <input type="text" id="mem_daddr" name="mem_daddr" class="order_input"
              value="<?= $mem_daddr ?>" readonly /></div>
        </div>
        <div class="detail_div">
          <div class="confirm_div">
            <div><span class="chead">상품명</span><span class="cbody"><?=$product?></span></div>
            <div><span class="chead">옵션</span><span class="cbody"><?=$product_opt?></span></div>
            <div><span class="chead">결제가격</span><span class="cbody"><?=$amount?></span></div>
          </div>
          <div class="agree_div">
            <span class='agree_txt'>환불, 교환 절대 안됨. 7일내 그런거 없음. 안됨. 배 째!</span>
            <div><input type="checkbox" id="agree" class="chkbox" /><label for="agree">구매 관련 주의사항을 확인했고, 동의합니당</label></div>
          </div>

        </div>
        <div class="button_div">
          <input type="button" value="결제하기" />
        </div>
      </div>
    </div>
  </div>




</body>

</html>