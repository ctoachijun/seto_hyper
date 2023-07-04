<?
include "./admin_header.php";

// $arr_tel = array("01041961379","01091900223","010395820339","01039482939","01058203959","01029938829","01039482230");
// $arr_email = array("test1@gmail.com","test2@naver.com","test3@daum.net","test4@gmail.com","test5@hanmail.net","test6@kakao.com");
// $arr_opt = array("빨강,큰거","파랑,작은거","빨강,작은거","파랑,큰거","고무,롱타입,SET1","고무,숏타입,SET1","고무,롱타입,SET2","고무,숏타입,SET2","고무,롱타입,SET3");
// $arr_val = array("8000","9000","15000","18900","25000","39900","119000","156000","300000");
// $arr_addr = array("부산 사하구","부산 사상구","부산 서구","부산 동래구","부산 북구","부산 해운대구","부산 수영구","부산 강서구","서울 송파구");


// $arr_type = array("C","P","B","H");
// $arr_bank = array("기업은행","카카오뱅크","토스뱅크","하나은행","KB은행");


// for($i=1; $i<67; $i++){
//   $tel = $arr_tel[array_rand($arr_tel)];
//   $email = $arr_email[array_rand($arr_email)];
//   $opt = $arr_opt[array_rand($arr_opt)];
//   $val = $arr_val[array_rand($arr_val)];
//   $addr = $arr_addr[array_rand($arr_addr)];
//   $a_idx = rand(2,3);
//   $i_idx = rand(1,4);  
//   $tstamp = strtotime("+{$i} seconds");
//   $number = "230703_{$a_idx}{$i_idx}{$tstamp}";

//   $now = date("Y-m-d H:i:s", $tstamp);
  
//   $sql = "INSERT INTO st_order SET o_iidx = {$i_idx}, o_aidx = {$a_idx}, o_number = '{$number}', o_tel = '{$tel}', o_email='{$email}', o_addr='{$addr}', o_popt='{$opt}', o_pval='{$val}', o_odate='{$now}', o_pmidx={$i}";
//   // sql_exec($sql);
//   // sleep(rand(1,3));
  
//   $amount = $arr_val[array_rand($arr_val)];
//   $type = $arr_type[array_rand($arr_type)];
  
//   if($type == "B"){
//     $bank = $arr_bank[array_rand($arr_bank)];
//     $bnum = $arr_tel[array_rand($arr_tel)];
//     $detail = $bank."-".$bnum;
//     $dt = "pm_detail = '{$detail}', ";
//   }else{
//     $dt = "";
//   }
  
//   // $sql = "INSERT INTO st_payment SET pm_amount = $amount, pm_type = '{$type}', {$dt} pm_pdate = '{$now}'";
//   // sql_exec($sql);
//   // echo "$sql <br>";
// }




// 페이징을 위한 쿼리스트링
$pqs = $_SERVER['QUERY_STRING'];

if(!$pqs){
  $end = 20;
  $start = 0;
  $cur_page = 1;
  $pqs = "&end={$end}&start={$start}&cur_page={$cur_page}";
}

if($cur_page > 1){
  $start = $end * ($cur_page - 1);
  $number = $total_cnt - $start;
}else{
  $start = 0;
}


$where = "WHERE 1 ";
$limit = "LIMIT {$start},{$end}";


// 검색에 따른 조건 추가
if($type){
  $start = 0;
  $cur_page = 1;
} 


$join = "as o LEFT OUTER JOIN st_payment as p ON o.o_pmidx = p.pm_idx";

if($type == "mem"){
  $join .= " INNER JOIN st_member as m ON o.o_midx = m.m_idx ";
  $where .= "AND m_name like '%{$sw}%' ";
}else if($type == "prod"){
  $join .= " INNER JOIN st_item as i ON o.o_iidx = i.i_idx ";
  $where .= "AND i_name like '%{$sw}%' ";
}else if($type == "num"){
  $where .= "AND o_number like '%{$sw}%' ";
}else if($type == "odate"){
  $where .= "AND o_odate like '%{$sw}%' ";
}

// 취소여부 정렬
if(!$sort_cancel || $sort_cancel == "A"){
  $where .= "";
}else{
  $where .= "AND o.o_cancel = '{$sort_cancel}' ";
}


// 세토웍스인 경우
if ($admin_group == "SK") {
  $where .= "";
  
// 메이커인 경우
}else if($admin_group == "MK"){
  $where .= "AND o.o_aidx = {$admin_idx}";
}

if(!$sodate){
  $sodate = "D";
}

if($sodate == "A"){
  $sodate_txt = "ORDER BY o_odate ASC";
  $od_sort = "bi-sort-down-alt";
}else{
  $sodate_txt = "ORDER BY o_odate DESC";
  $od_sort = "bi-sort-down";
}



$sql = "SELECT * FROM st_order {$join} {$where} {$sodate_txt} {$limit}";
$order_box = sql_query($sql);
// echo "$sql <br>";



// 번호 붙이기 위한 총 개수 추출
$total_cnt = count( sql_query("SELECT * FROM st_order {$join} {$where}") );
if(!$number){
  $pqs .= "&total_cnt={$total_cnt}";
  $number = $total_cnt;
}


// input 만들 때 제외 할 파라미터 이름
$nopt = array("sodate","return_cur","sort_cancel","sort_cancle","type","sw","total_cnt","gosort");

// 페이징용 where
$where = $join." ".$where;


?>


<div class="container orderlist">
  <div class="pagetitle">
    <h1>주문 목록</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active">주문 목록</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="cont col-lg-12 card">
    <div class="top_div card-body">
      <h5 class="card-title">주문</h5>

    </div>

    <div class="middle_div card-body d-flex align-items-center">
      <div class="table_div">
        <form action="<?=$PHP_SELF?>" method="GET" onsubmit="return chgCurPage();" >
        <? echo qsChgForminput($pqs,$nopt); ?>
          <input type="hidden" name="sodate" value="<?=$sodate?>" />      
          <input type="hidden" name="gosort" />      
          <div class="search_div d-flex">
            <div class="d-flex">
              <select class="form-select sortselect" aria-label="Default select example" name="sort_cancel" onchange="setCancelList()">
                <option value="A" <? if($sort_cancel == "A") echo "selected"; ?>>전체</option>
                <option value="N" <? if($sort_cancel == "N") echo "selected"; ?>>정상</option>
                <option value="Y" <? if($sort_cancel == "Y") echo "selected"; ?>>취소</option>
              </select>
              
              <select class="form-select typeselect" aria-label="Default select example" name="type">
                <option value="mem" <? if($type == "mem") echo "selected"; ?>>구매자</option>
                <option value="num" <? if($type == "num") echo "selected"; ?>>주문번호</option>
                <option value="prod" <? if($type == "prod") echo "selected"; ?>>상품</option>
                <option value="odate" <? if($type == "odate") echo "selected"; ?>>주문일시</option>
              </select>
              <input type="text" class="form-control swinput" name="sw" value="<?=$sw?>" />
              <!-- <input type="button" class="btn btn-primary subbtn" onclick="chgCurPage()" value="검색" /> -->
              <input type="submit" class="btn btn-primary subbtn" value="검색" />
            </div>
            <div class="d-flex">
              <input type='button' class='btn btn-outline-success' value='송장번호 일괄업로드' onclick='setAllDeliNum(<?=$admin_idx?>)' />
              <img src="../img/exel.png" onclick="downExcel(2,'<?=$admin_idx?>')" />
            </div>
          </div>
        </form>
        <div class="total_count d-flex">총 <?=$total_cnt?>건</div>
        <table clss="table table-striped">
          <thead>
            <tr>
              <th>주문번호</th>
              <th>구매자</th>
              <th>브랜드</th>
              <th>상품</th>
              <th>주문 개수</th>
              <th>주문 금액</th>
              <th>주문 수단</th>
              <th class="cpointer" onclick="sortOdate('<?=$sodate?>')">주문 일시 <i class='bi <?=$od_sort?>'></i></th>
              <th>취소</th>
              <th>송장 입력</th>
            </tr>
          </thead>
          <tbody>
<?
          foreach($order_box as $v) :
            $iidx = $v['o_iidx'];
            $item_box = getItemInfo($iidx);
            $brand_box = getBrandInfo($item_box['i_bidx']);
            $brand_name = $brand_box['b_name'];
            $item_name = $item_box['i_name'];
            $oidx = $v['o_idx'];
            $order_number = $v['o_number'];
            $member = getMemberInfo($v['o_midx']);
            $order_name = $member['m_name'];
            $order_quan = number_format($v['o_quan']);
            $order_price = number_format($v['pm_amount']);
            $order_date = $v['o_odate'];
            $ptype = $v['pm_type'];
            
            if($ptype == "C"){
              $payment = "카드";
            }else if($ptype == "P"){
              $payment = "간편결제";
            }else if($ptype == "B"){
              $payment = "계좌이체";
            }else if($ptype == "H"){
              $payment = "핸드폰";
            }
            
            if($ptype != "C" && $ptype != "H"){
              $pdetail = $v['pm_detail'];
              $payment .= "<br>(".$v['pm_detail'].")";
            }
            
            $order_cancel = $v['o_cancel'];
            if($order_cancel == "Y"){
              $cancel = "취소";
              $rol = "disabled";
              $cclass = "cancel_tr";
              $onclk = "";
            }else{
              $cancel = "";
              $rol = "";
              $cclass = "";
              $onclk = "onclick='setDeliNum({$oidx})'";
            }
            
            $delivery = $item_box['i_delicomp'];
            $deli_number = $v['o_deli_number'];
            


?>            
            <tr class="<?=$cclass?>">
              <td class='cpointer' onclick="detailOrder(<?=$oidx?>)"><?=$order_number?></td>
              <td><?=$order_name?></td>
              <td><?=$brand_name?></td>
              <td><?=$item_name?></td>
              <td><?=$order_quan?></td>
              <td><?=$order_price?></td>
              <td><?=$payment?></td>
              <td><?=$order_date?></td>
              <td><?=$cancel?></td>
              <td><?=$delivery?> : 
                <div class='deli_td d-flex align-items-center'>
                  <input type='text' class="form-control " name='deli_number<?=$oidx?>' onkeyup='onlyNum(this)' maxlength="15" <?=$rol?> value="<?=$deli_number?>" />
                  <input type='button' class='default_btn' value='적용' <?=$onclk?> <?=$rol?> />
                </div>
              </td>
            </tr>
<?
            $number--;
          endforeach;
?>

          </tbody>
        </table>
      </div>
      <div class="paging_div">
        <div class='pagin'>
          <? getPaging('seto_order',$pqs,$where); ?>
        </div>
      </div>

    </div>

  </div>
</div>

<?
include "./admin_footer.php";
?>