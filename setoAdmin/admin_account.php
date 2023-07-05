<?
include "./admin_header.php";

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

if($type == "c"){
  $where .= "AND a_comp like '%{$sw}%'";
}else if($type == "i"){
  $where .= "AND a_id like '%{$sw}%'";
}else if($type == "m"){
  $where .= "AND a_name like '%{$sw}%'";
}else if($type == "t"){
  $where .= "AND a_tel like '%{$sw}%'";
}else if($type == "e"){
  $where .= "AND a_email like '%{$sw}%'";
}


$sql = "SELECT * FROM st_admin {$where} ORDER BY a_idx DESC {$limit}";
$admin_box = sql_query($sql);
echo "$sql <br>";



// 번호 붙이기 위한 총 개수 추출
$total_cnt = count( sql_query("SELECT * FROM st_admin {$where}") );
if(!$number){
  $pqs .= "&total_cnt={$total_cnt}";
  $number = $total_cnt;
}

// input 만들 때 제외 할 파라미터 이름
$nopt = array("sw","type","total_cnt","return_cur","reg_type","aid");
?>


<div class="container adminlist">
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
        <input type="hidden" name="reg_type" />      
        <div class="search_div d-flex">
          <div class="total_count d-flex">총 <?=$total_cnt?>건</div>
          <div class="d-flex">
            <select class="form-select typeselect" aria-label="Default select example" name="type">
              <!-- <option value="a" <? if($type == "a") echo "selected"; ?>>전체</option> -->
              <option value="c" <? if($type == "c") echo "selected"; ?>>회사명</option>
              <option value="i" <? if($type == "i") echo "selected"; ?>>ID</option>
              <option value="m" <? if($type == "m") echo "selected"; ?>>담당자</option>
              <option value="t" <? if($type == "t") echo "selected"; ?>>연락처</option>
              <option value="e" <? if($type == "e") echo "selected"; ?>>이메일</option>
            </select>
            <input type="text" class="form-control swinput" name="sw" value="<?=$sw?>" />
            <input type="submit" class="btn btn-primary subbtn" value="검색" />
          </div>
          <div class="d-flex">
            <input type='button' class='btn btn-success' value='등록' onclick='goReg()' />
            <!-- <img src="../img/exel.png" onclick="downExcel(1,'<?=$admin_idx?>')" /> -->
          </div>
        </div>
      </form>
      <div class="table_div">
        <table clss="table table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>그룹</th>
              <th>ID</th>
              <th>회사명</th>
              <th>소재지</th>
              <th>담당자</th>
              <th>연락처</th>
              <th>이메일</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
<?
          foreach($admin_box as $v) :
            $group = $v['a_group'];
            if($group == "MK"){
              $group_txt = "메이커";
            }else{
              $group_txt = "세토웍스";
            }
            
            $id = $v['a_id'];
            $comp = $v['a_comp'];
            $addr = $v['a_addr'];
            $manager = $v['a_name'];
            $tel = $v['a_tel'];
            $email = $v['a_email'];
?>            
            <tr>
              <td><?=$number?></td>
              <td><?=$group_txt?></td>
              <td><?=$id?></td>
              <td><?=$comp?></td>
              <td><?=$addr?></td>
              <td><?=$manager?></td>
              <td><?=$tel?></td>
              <td><?=$email?></td>
              <td><span class='detail_txt cpointer' onclick="goDetailAdmin('<?=$id?>')">상세</span></td>
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