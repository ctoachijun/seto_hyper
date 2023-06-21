<?php
include "./setofunc.php";


$order = getOrderDataAll();

?>



<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scal=1.0">
  <title>관리자</title>

  <style>
    #wrap{width:100%;}
    #wrap div{display:flex;}
    .container{width:100%;justify-content:center;}
    .cont{width:80%;padding:.5rem;flex-direction:column;}
    .top_cont{border-bottom:2px solid #9A9A9A;height:30px;padding:.8rem;padding-bottom:0}
    .middle_cont{border:1px solid #ACACAC;margin-top:20px;}
    .table_div{width:100%}
    .otable{width:100%;text-align:center;border-collapse:collapse;}
    .ot_tr{font-size:.9rem;font-weight:700;}
    .otable th{min-width:60px;border:1px solid #666;background:#CECECE;}
    .ot_td{font-size:.8rem;height:30px;border:1px solid #CECECE;padding:.3rem;}
  </style>

</head>

<body>
  <div id="wrap">
    <div class="container">
      <div class="cont">
        <div class="top_cont">
          <span>주문 관리</span>
        </div>

        <div class="middle_cont">
          <div class="table_div">

            <table class='otable' borderc>
              <tr class='ot_tr'>
                <th>주문번호</th>
                <th>상품 / 브랜드</th>
                <th>상태</th>
                <th>ID</th>
                <th>이름</th>
                <th>연락처</th>
                <th>주소</th>
                <th>결제금액</th>
                <th>주문일시</th>
                <th>취소일시</th>
              </tr>

              <?
              foreach ($order as $v):
                $odate = preg_replace("\s","\r\n",$v['o_odate']);
                $onum = $v['o_number'];
                $product = "ATOLL Black Model S";
                $brand = "ATOLL";
                $cdate = $v['o_cdate'];
                $cy = $v['o_cancel'];
                $cy == 'N' ? $cy_txt = "" : $cy_txt = "취소";

                // 회원 정보 세팅
                $midx = $v['o_midx'];
                $member = getMemberInfo($midx);

                $id = $member['m_id'];
                $name = $member['m_name'];
                $tel = $member['m_tel'];
                $addr = $member['m_addr'] . " " . $member['m_daddr'];
                $pay = 'KRW 1,000';


                ?>

                <tr class='ot_tr'>
                  <td class='ot_td'>
                    <?= $onum ?>
                  </td>
                  <td class='ot_td'>
                    <?= $product ?> /
                    <?= $brand ?>
                  </td>
                  <td class='ot_td'>
                    <?= $cy_txt ?>
                  </td>
                  <td class='ot_td'>
                    <?= $id ?>
                  </td>
                  <td class='ot_td'>
                    <?= $name ?>
                  </td>
                  <td class='ot_td'>
                    <?= $tel ?>
                  </td>
                  <td class='ot_td'>
                    <?= $addr ?>
                  </td>
                  <td class='ot_td'>
                    <?= $pay ?>
                  </td>
                  <td class='ot_td'>
                    <?= $odate ?>
                  </td>
                  <td class='ot_td'>
                    <?= $cdate ?>
                  </td>
                </tr>

              <? endforeach; ?>
          </div>
        </div><!-- middle_cont -->
        
        
      </div>
    </div>
  </div>
</body>

</html>