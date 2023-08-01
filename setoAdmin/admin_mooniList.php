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


$join = "as mn INNER JOIN st_mooni_category as mnc ON mn.mn_mncidx = mnc.mnc_idx INNER JOIN st_member as m ON mn.mn_midx = m.m_idx ";
$where = "WHERE 1 ";
$limit = "LIMIT {$start},{$end}";


// 메이커인 경우
if ($admin_group == "MK") {
  // $where .= "AND mn_midx = {$admin_idx} ";
  
  // 나한테 속한 브랜드idx 추출
  $brand_box = getBrandList($admin_idx,"");
  $bcnt = 0;
  foreach($brand_box as $v){
    $bidx_box[$bcnt] = $v['b_idx'];
    $bcnt++;
  }
  $bidxs = implode(",",$bidx_box);

  // 내 브랜드idx를 가지고있는 상품 idx추출
  $bi_where = "WHERE i_bidx IN ({$bidxs})";
  $bi_box = getBrandItem("",$bi_where,"");
  
  $bicnt = 0;
  foreach($bi_box as $v){
    $biidx_box[$bcnt] = $v['i_idx'];
    $bcnt++;
  }
  $biidxs = implode(",",$biidx_box);
  
  
  // 내 브랜드의 상품과 관련있는 문의만 추출하도록.
  $where .= "AND mn_iidx IN ({$biidxs}) ";
  
  
  $sel2 = setMooniTypeSel('P',$type);
  $selgp = setMyBrandItemSel($admin_idx,$gprod);
  
  if($gprod && $gprod != "N"){
    $where .= "AND mn_iidx = {$gprod} ";
  }
  
}else{
  // type 있을때
  if($type){
    $sel2 = setMooniTypeSel($tclass,$type);
  }else{
    $sel2 = "<option value='N'>==선택==</option>";
  }
}


// 셀렉트바 첫번째, 두번째 값이 설정되었을때 where문에 조건 추가.
if(!empty($tclass) && $tclass != "N"){
  $where .= "AND mnc_class = '{$tclass}' ";
}
if(!empty($type) && $type != "N"){
  $where .= "AND mnc_idx = {$type} ";
}


// 검색어가 있을때
if($sw){
  
  // 검색 조건이 작성자일때는 칼럼명을 다르게.
  if($swsel == "name"){
    $where .= "AND m_{$swsel} like '%{$sw}%'";
    
  // 제목, 작성일일때는 그대로.
  }else{
    $where .= "AND mn_{$swsel} like '%{$sw}%'";
  }
}


// 페이징에 먹히게 join절을 where절과 합침.
$where = $join.$where;

$sql = "SELECT * FROM st_mooni {$where} ORDER BY mn_mdate DESC {$limit}";
$mooni_box = sql_query($sql);
// echo "$sql <br>";


// 번호 붙이기 위한 총 개수 추출
$total_cnt = getMooniAllCount($where);
  if(!$number){
    $pqs .= "&total_cnt={$total_cnt}";
    $number = $total_cnt;
  }

  
// input 만들 때 제외 할 파라미터 이름
$nopt = array("sw","type","total_cnt","tclass","return_cur","swsel","gprod");
?>


<div class="container moonilist">
  <div class="pagetitle">
    <h1>문의 목록</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item">문의 관리</li>
        <li class="breadcrumb-item active">문의 목록</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="cont col-lg-12 card">
    <div class="top_div card-body">
      <h5 class="card-title">문의</h5>

    </div>

    <div class="middle_div card-body d-flex align-items-center">
      <form action="<?=$PHP_SELF?>" method="GET" onsubmit="return chgCurPage();" >
      <? echo qsChgForminput($pqs,$nopt); ?>
        <div class="search_div d-flex">
          <div class="total_count d-flex">총 <?=$total_cnt?>건</div>
          <div class="d-flex">
            <? if($admin_group == "SK") : ?>
            <select class="form-select tclassselect" aria-label="Default select example" name="tclass" onchange="setSel2(this);">
              <option value="N" <? if($tclass == "N") echo "selected"; ?>>전체</option>
              <option value="S" <? if($tclass == "S") echo "selected"; ?>>사이트</option>
              <option value="P" <? if($tclass == "P") echo "selected"; ?>>제품</option>
            </select>
            <? endif; ?>
            
            <select class="form-select typeselect" aria-label="Default select example" name="type" onchange="sortType(this)">
              <?=$sel2?>
            </select>
            <? if($admin_group == "MK") : ?>
            <select class="form-select gpselect" aria-label="Default select example" name="gprod" onchange="sortType(this)">
              <?=$selgp?>
            </select>
            <? endif; ?>
            <select class="form-select swselect" aria-label="Default select example" name="swsel">
              <option value="subject" <? if($swsel == "subject") echo "selected"; ?>>제목</option>
              <option value="name" <? if($swsel == "name") echo "selected"; ?>>작성자</option>
              <option value="mdate" <? if($swsel == "mdate") echo "selected"; ?>>작성일</option>
            </select>

            <input type="text" class="form-control swinput" name="sw" value="<?=$sw?>" />
            <input type="submit" class="btn btn-primary subbtn" value="검색" />
          </div>
        </div>
      </form>
      <div class="table_div">
        <table clss="table table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>분류</th>
              <th>상품명</th>
              <th>작성자</th>
              <th>제목</th>
              <th>내용</th>
              <th>작성일</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
<?         
          if($mooni_box) :
            foreach($mooni_box as $v) :
              $subj = mb_strimwidth($v['mn_subject'],0,45,"...");
              $cont = mb_strimwidth($v['mn_cont'],0,45,"...");
              $mdate_box = explode(" ",$v['mn_mdate']);
              $mbox = getMemberInfo($v['mn_midx']);
              $mname = $mbox['m_name'];
              $cate = $v['mnc_name'];
              $iidx = $v['mn_iidx'];
              $mnidx = $v['mn_idx'];
              $aidx = $v['mn_aidx'];
              
              $mdate = $mdate_box[0];
              if(empty($aidx)){
                $ans_txt = "<span class='noans'>미답변</span>";
              }else{
                $ans_txt = "<span class='yans'>완료</span>";
              }
              
              
              
              $item_info = getItemInfo($iidx);
              $item_name = mb_strimwidth($item_info['i_name'],0,20,"...");
?>            

              <tr class="cpointer" onclick="goMooniDetail(<?=$mnidx?>)">
                <td><?=$number?></td>
                <td><?=$cate?></td>
                <td><?=$item_name?></td>
                <td><?=$mname?></td>
                <td><?=$subj?></td>
                <td><?=$cont?></td>
                <td><?=$mdate?></td>
                <td><?=$ans_txt?></td>
              </tr>
<?
              $number--;
            endforeach;
          else :
?>
            <tr><td colspan="8" style="height:100px;">검색 결과가 없습니다. </td></tr>
<?        endif; ?>              

          </tbody>
        </table>
      </div>
      <div class="paging_div">
        <div class='pagin'>
          <? getPaging('seto_mooni',$pqs,$where); ?>
        </div>
      </div>

    </div>

  </div>
</div>

<?
include "./admin_footer.php";
?>