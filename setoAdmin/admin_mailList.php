<?
include "./admin_header.php";

// for($i=1;$i<27;$i++){
  
//   $iindex = rand(1,3);
//   $aindex = rand(2,3);
//   $Strings = '0123456789abcdefghijklmnopqrstuvwxyz';  
//   $email = substr(str_shuffle($Strings), 0, 7)."@setoworks.com";
  
//   $sql = "INSERT INTO st_smail SET s_aidx = {$aindex}, s_iidx = {$iindex}, s_email = '{$email}', s_wdate = now()";
//   sql_exec($sql);
//   sleep(1);
// }


// 페이징을 위한 쿼리스트링
$qs = $_SERVER['QUERY_STRING'];
if(!$qs){
  $end = 5;
  $start = 0;
  $cur_page = 1;
  $qs = "&end={$end}&start={$start}&cur_page={$cur_page}";
}

if($cur_page > 1){
  $start = $end * ($cur_page - 1);
  $total_cnt = $total_cnt - $start;
}else{
  $start = 0;
}

$tbl_name = "st_smail";
$where = "WHERE 1 ";
$limit = "LIMIT {$start},{$end}";


// 관리자 고유번호와 소속을 추출
$admin = getAdminInfo($id);
$aidx = $admin['a_idx'];
$agroup = $admin['a_group'];

if ($agroup == "MK") { // 메이커인 경우
  $where .= "AND s_aidx = {$aidx} ";
} else {
}
$sql = "SELECT * FROM {$tbl_name} {$where} ORDER BY s_wdate DESC {$limit}";
$mail_box = sql_query($sql);

// 번호 붙이기 위한 총 개수 추출
if(!$total_cnt){
  $total_cnt = count(getMailListAll($aid));
}  
$qs .= "&total_cnt={$total_cnt}";

?>

<div class="container maillist">
  <div class="pagetitle">
    <h1>General Tables</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active">General</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="cont col-lg-12 card">
    <div class="top_div card-body">
      <h5 class="card-title">수집 된 메일 목록</h5>

    </div>
    <div class="middle_div card-body d-flex align-items-center">

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
              <th><?=$total_cnt?></th>
              <td><?=$brand_name?></td>
              <td><?=$item_name?></td>
              <td><?=$mail?></td>
              <td><?=$wdate?></td>
            </tr>
<?
            $total_cnt--;
          endforeach;
?>

          </tbody>
        </table>
      </div>
      <div class="paging_div">
        <div class='pagin'>
          <? getPaging($tbl_name,$qs); ?>
        </div>
      </div>

    </div>

  </div>
</div>

<?
include "./admin_footer.php";
?>