<?
include "./admin_header.php";

$return_page = $_SERVER['QUERY_STRING'];

$order = getOrderInfo($oidx);
$item = getItemInfo($order['o_iidx']);
$brand = getBrandInfo(($item['i_bidx']));
$brand_name = $brand['b_name'];
$path = chkBrandDir($brand_name);
$member = getMemberInfo($order['o_midx']);


// 이미지
$item_img = $path."/".$item['i_img'];


// 주문상태 텍스트
$cancel = $order['o_cancel'];
if($cancel == "Y"){
 $cancel_txt = "<span class='canyes_txt'>취소</span>"; 
}else{
  $cancel_txt = "<span class='canno_txt'>정상</span>";
}

// 주문 금액 계산
$order_price = $order['o_pval'] * $order['o_quan'];
$deli_price = number_format($item['i_delival']);
$amount = $order['pm_amount'];

$pm_detail = $order['pm_detail'];
$pm_type = $order['pm_type'];
$card_part = $order['pm_card_part'];

if($pm_type == "C"){
  $type_txt = "신용카드";
  if($card_part != "일시불"){
    $part_txt = "할부 ".$card_part."개월";
  }else{
    $part_txt = $card_part;
  }
}else if($pm_type == "P"){
  $type_txt = "간편결제";
}else if($pm_type == "B"){
  $type_txt = "계좌이체";
}

// 할인
$disc_type = $order['o_disc_type'];
$discount = $order['o_discount'];
$disc_type == "P" ? $disc_txt = "%" : $disc_txt = "원";
if($disc_type == "P"){
  $amount = $order_price - ($order_price / $discount);
}else{
  $amount = $order_price - $discount;
  $discount = number_format($discount);
}

$order_price = number_format($order_price);
$amount = number_format($amount);




?>

<script>
   $(function () {
   });


</script>


<div class="container orderDetail">
   <div class="pagetitle">
      <h1>주문 상세</h1>
      <nav>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="main.php">Home</a></li>
            <li class="breadcrumb-item active">주문 상세</li>
         </ol>
        </nav>
      </div><!-- End Page Title -->
      
      <div class="cont col-lg-12">
        <div class="middle_div card">
          <div class="card-body">
            <h5 class="card-title">주문 상세 내역</h5>
            <input type='hidden' name="return_page" value="<?=$return_page?>" />
            
            
                <section class="box">
                  <div class="box_row"><h4>주문 정보</h4></div>
                  <div class="box_row order_row d-flex">
                    <div class="order_div od1">
                      <div class='item_img_div'><img src='<?=$item_img?>' /></div>                      
                    </div>
                    <div class="order_div od2 d-flex flex-column align-items-end">
                      <div class='od_row'><span class='head_txt'>주문번호</span><span class='cont_txt'><?=$order['o_number']?></span></div>
                      <div class='od_row'><span class='head_txt'>상품명</span><span class='cont_txt'><?=$item['i_name']?></span></div>
                      <div class='od_row'><span class='head_txt'>수량</span><span class='cont_txt'><?=$order['o_quan']?>개</span></div>
                    </div>
                    <div class="order_div od3 d-flex flex-column">
                      <div class='od_row'>
                        <div><span class='head_txt'>상품가</span></div><div><span class='cont_txt'><?=$order_price?>원</span></div>
                      </div>                        
                      <div class='od_row'>
                        <div><span class='head_txt'>할인</span></div><div><span class='cont_txt'><?=$discount?><?=$disc_txt?></span></div>
                      </div>
                      <div class='od_row'>
                        <div><span class='head_txt'>결제금액</span></div><div><span class='cont_txt'><?=$amount?>원</span></div>
                      </div>
                    </div>
                  </div>
                </section>
                <section class="box">
                  <div class="box_row"><h4>결제 정보</h4></div>
                  <div class="box_row">
                    <table class="table">
                      <tbody>
                      <tr>
                          <th>결제 일시</th>
                          <td><?=$order['o_odate']?></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th>결제 방식</th>
                          <td><?=$type_txt?></td>
                          <td><?=$pm_detail?></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th>총 결제금액</th>
                          <td><?=$amount?></td>
                          <td>
                            <?=$part_txt?>
                          </td>
                          <td></td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </section>
                <section class="box">
                  <div class="box_row"><h4>배송 정보</h4></div>
                  <div class="box_row">
                    <table class="table">
                      <tbody>
                        <tr>
                          <th>이름</th>
                          <td><?=$member['m_name']?></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th>연락처</th>
                          <td><?=$order['o_tel']?></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th>주소</th>
                          <td>[<?=$order['o_zipcode']?>] <?=$order['o_addr']?> <?=$order['o_daddr']?></td>
                          <td><?=$item['i_delicomp']?> <?=$order['o_deli_number']?></td>
                        </tr>
                        <tr>
                          <th>요청사항</th>
                          <td><?=$order['o_deli_request']?></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </section>

                
                
         
         </div>   <!-- end of card-body -->
      </div>   <!-- end of middle_div -->
      
   </div>
</div>

<?
include "./admin_footer.php";
?>