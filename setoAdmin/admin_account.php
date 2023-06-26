<?
include "./admin_header.php";

// 페이징을 위한 쿼리스트링
$pqs = $_SERVER['QUERY_STRING'];

if(!$pqs){
  $end = 10;
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

if($type == "p"){
  $where = "as ss INNER JOIN st_item as si ON ss.s_iidx = si.i_idx ".$where;
  $where .= "AND si.i_name like '%{$sw}%'";
}else if($type == "b"){
  $where = "as ss INNER JOIN st_item as si ON ss.s_iidx = si.i_idx INNER JOIN st_brand as sb ON si.i_bidx = sb.b_idx ".$where;
  $where .= "AND sb.b_name like '%{$sw}%'";
}else if($type == "d"){
  $where .= "AND s_wdate like '%{$sw}%'";
}

// 메이커인 경우
if ($admin_group == "MK") {
  $where .= "AND s_aidx = {$admin_idx} ";
}else{
}


$sql = "SELECT * FROM st_smail {$where} ORDER BY s_wdate DESC {$limit}";
$mail_box = sql_query($sql);
// echo "$sql <br>";



// 번호 붙이기 위한 총 개수 추출
$total_cnt = count(getMailListAll($aid,$where));
  if(!$number){
    $pqs .= "&total_cnt={$total_cnt}";
    $number = $total_cnt;
  }


// input 만들 때 제외 할 파라미터 이름
$nopt = array("sw","type","total_cnt");
?>


<div class="container maillist">
  <div class="pagetitle">
    <h1>관리자 계정 관리</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active">관리자 계정 관리</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="cont col-lg-12 card">
    <div class="top_div card-body">
      <h5 class="card-title"><?=$type_name?> 계정 목록</h5>

    </div>

    <div class="middle_div card-body d-flex align-items-center">
      <form action="<?=$PHP_SELF?>" method="GET" onsubmit="return chgCurPage();" >
      <? echo qsChgForminput($pqs,$nopt); ?>
        <!-- <input type="hidden" name="pqs" value="<?=$pqs?>" />       -->
        <div class="search_div d-flex">
          <div class="total_count d-flex">총 <?=$total_cnt?>건</div>
          <div class="d-flex">
            <select class="form-select typeselect" aria-label="Default select example" name="type">
              <option value="p" <? if($type == "p") echo "selected"; ?>>제품</option>
              <option value="b" <? if($type == "b") echo "selected"; ?>>브랜드</option>
              <option value="d" <? if($type == "d") echo "selected"; ?>>등록일</option>
            </select>
            <input type="text" class="form-control swinput" name="sw" value="<?=$sw?>" />
            <!-- <input type="button" class="btn btn-primary subbtn" onclick="chgCurPage()" value="검색" /> -->
            <input type="submit" class="btn btn-primary subbtn" value="검색" />
          </div>
          <div class="d-flex">
            <img src="../img/exel.png" onclick="downExcel(1,'<?=$admin_idx?>')" />
          </div>
        </div>
      </form>
      <div class="table_div">
        <table clss="table table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>브랜드</th>
              <th>제품</th>
              <th>메일 주소</th>
              <th>등록일</th>
            </tr>
          </thead>
          <tbody>
<?
          foreach($mail_box as $v) :
            $item_box = getItemInfo($v['s_iidx']);
            $brand_box = getBrandInfo($item_box['i_bidx']);
            $brand_name = $brand_box['b_name'];
            $item_name = $item_box['i_name'];
            $mail = $v['s_email'];
            $wdate = $v['s_wdate'];
?>            
            <tr>
              <th><?=$number?></th>
              <td><?=$brand_name?></td>
              <td><?=$item_name?></td>
              <td><?=$mail?></td>
              <td><?=$wdate?></td>
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
          <? getPaging('seto_mailing',$pqs,$where); ?>
        </div>
      </div>

    </div>

  </div>
</div>

<?
include "./admin_footer.php";
?>