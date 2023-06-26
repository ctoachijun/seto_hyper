<?php
$root_path = $_SERVER['DOCUMENT_ROOT'];
require_once $root_path . "/lib/db_config.php";


$host = $_SERVER["SERVER_NAME"];

ini_set("session.use_trans_sid", 0); // PHPSESSID를 자동으로 넘기지 않음
ini_set("url_rewriter.tags", ""); // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)
ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.
ini_set("session.cookie_lifetime", 0);

// ini_set("session.cookie_domain",$host);
ini_set('display_errors', 0);
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

session_start();
//==========================================================================================================================
// extract($_GET); 명령으로 인해 page.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
// 081029 : letsgolee 님께서 도움 주셨습니다.
//--------------------------------------------------------------------------------------------------------------------------
$ext_arr = array(
  'PHP_SELF',
  '_ENV',
  '_GET',
  '_POST',
  '_FILES',
  '_SERVER',
  '_COOKIE',
  '_SESSION',
  '_REQUEST',
  'HTTP_ENV_VARS',
  'HTTP_GET_VARS',
  'HTTP_POST_VARS',
  'HTTP_POST_FILES',
  'HTTP_SERVER_VARS',
  'HTTP_COOKIE_VARS',
  'HTTP_SESSION_VARS',
  'GLOBALS'
);
$ext_cnt = count($ext_arr);
for ($i = 0; $i < $ext_cnt; $i++) {
  // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴
  if (isset($_GET[$ext_arr[$i]]))
    unset($_GET[$ext_arr[$i]]);
  if (isset($_POST[$ext_arr[$i]]))
    unset($_POST[$ext_arr[$i]]);
}

// PHP 4.1.0 부터 지원됨
// php.ini 의 register_globals=off 일 경우
@extract($_GET);
@extract($_POST);
@extract($_SERVER);



// 찾기
// 관리자 관련 / 랜딩 관련 / 공통 관련
//

/* 
    관리자 관련 함수들
*/
function getAdminInfo($id)
{
  $sql = "SELECT * FROM st_admin WHERE a_id = '{$id}'";
  return sql_fetch($sql);
}

function getAdminInfoIdx($idx)
{
  $sql = "SELECT * FROM st_admin WHERE a_idx = '{$idx}'";
  return sql_fetch($sql);
}

function chkLoginAdmin($aid, $aidx)
{
  if (!$aid || !$aidx) {
    echo "<script>
    alert('로그인이 필요한 메뉴입니다.');
    location.replace('./');
    </script>";
  }
}

function getMailListAll($id,$whr)
{

  // 관리자 고유번호와 소속을 추출
  $admin = getAdminInfo($id);
  $aidx = $admin['a_idx'];
  $agroup = $admin['a_group'];

  if ($agroup == "MK") { // 메이커인 경우
    $sql = "SELECT * FROM st_smail {$whr} AND s_aidx = {$aidx} ORDER BY s_wdate DESC";
  } else {
    $sql = "SELECT * FROM st_smail {$whr} ORDER BY s_wdate DESC";
  }

  return sql_query($sql);
}

function getItemInfo($idx)
{
  $sql = "SELECT * FROM st_item WHERE i_idx = {$idx}";
  return sql_fetch($sql);
}
function getBrandInfo($idx)
{
  $sql = "SELECT * FROM st_brand WHERE b_idx = {$idx}";
  return sql_fetch($sql);
}

function getBrandItem($bidx,$where,$limit){
  $sql = "SELECT * FROM st_item {$where} {$limit}";
  return sql_query($sql);
}
function getBrandList($idx,$sw){
  if($idx != "ALL"){
    $where = "WHERE b_aidx = {$idx}";  
  }else{
    $where = "WHERE 1";
  }
  
  if($sw){
    $where .= " AND b_name like '%{$sw}%'";
  }
  
  $sql = "SELECT * FROM st_brand {$where} ORDER BY b_wdate DESC";
  // echo "$sql <br>";
  return sql_query($sql);
}
function getMakerSelect($idx){
  $sql = "SELECT * FROM st_admin WHERE a_group = 'MK' AND a_open = 'Y'";
  $mbox = sql_query($sql);
  
  $html = "<select id='maker_select' class='form-select mselect ' onchange='setBrandList(this)'>";  
  $html .= "<option value='ALL'>전체</option>";
  foreach($mbox as $v){
    $mname = $v['a_comp'];
    $midx = $v['a_idx'];
    $idx == $midx ? $tsel = "selected" : $tsel = "";
    
    $html .= "<option value='{$midx}' {$tsel}>{$mname}</option>";
  }
  $html .= "</select>";
  
  return $html;
}

// 브랜드 디렉토리 경로를 return 하면서 없으면 생성한다.
function chkBrandDir($bname){
  $aid = $_SESSION['admin_id'];
  $aidx = $_SESSION['admin_idx'];
  $agroup = $_SESSION['admin_group'];

  if($agroup != "MK"){
    $abox = explode("|",brandnameToAdmin($bname));
    $aidx = $abox[0];
    $aid = $abox[1];
  }
  
  $comp_dir = $aidx."_".$aid;
  
  $brand_dir_path = "../img/maker/{$comp_dir}/brand/{$bname}";
  
  if(!is_dir($brand_dir_path)){
    mkdir($brand_dir_path,0777);
    // exec("mkdir {$brand_dir_path}");
  }
  return $brand_dir_path;
}

function chgBrandDirName($org,$bname){
  $aid = $_SESSION['admin_id'];
  $aidx = $_SESSION['admin_idx'];
  $agroup = $_SESSION['admin_group'];

  if($agroup != "MK"){
    $abox = explode("|",brandnameToAdmin($bname));
    $aidx = $abox[0];
    $aid = $abox[1];
  }
  
  $comp_dir = $aidx."_".$aid;
  
  $org_dir_path = "../img/maker/{$comp_dir}/brand/{$org}";
  $new_dir_path = "../img/maker/{$comp_dir}/brand/{$bname}";
  $cmd = "mv {$org_dir_path} {$new_dir_path}";
  exec($cmd);
  
  return $cmd;
  
}

// 브랜드 이름을 이용해 관리자 id, idx를 추출
function brandnameToAdmin($bname){
  $sql = "SELECT * FROM st_brand WHERE b_name = '{$bname}'";
  $re = sql_fetch($sql);
  $aidx = $re['b_aidx'];
  $admin = getAdminInfoIdx($aidx);
  $aid = $admin['a_id'];
  
  return "{$aidx}|{$aid}";
}

// 제품 검색에 따른 총 개수 
function getItemTotalCnt($bidx,$where){
  $sql = "SELECT count(*) as total FROM st_item {$where}";
  $re = sql_fetch($sql);
  
  return $re['total'];
}









/*
  공통 관련
*/

function qsChgForminput($qs,$nopt){
  $box = explode("&",$qs);
  foreach($box as $v1){
    if($v1){
      $box2 = explode("=",$v1);
      $name = $box2[0];
      $value = $box2[1];
      
      if(array_search($name,$nopt) === 0 || array_search($name,$nopt)){
      }else{
        $html .= "<input type='hidden' name='{$name}' value='{$value}' />";
      }
    }
  }
    
  return $html;
}
function getPaging($tbl, $qs, $where){

  
  if($tbl == "seto_mailing"){
    $tbl_name = "st_smail";
  }else if($tbl == "seto_product"){
    $tbl_name = "st_item";
  }
  
  // 쿼리스트링에서 변수 및 값 대입
  $box = explode("&",$qs);
  foreach($box as $v1){
    if($v1){
      $box2 = explode("=",$v1);
      $arr[$box2[0]] = $box2[1];
    }
  }

  
  // if(empty($arr['pqs'])){
  //   $arr['pqs'] = $qs;
  // }
  
  
  foreach($arr as $i => $v){
    $$i = $v;
    // echo "$i - $v <br>";
  }
  
  
  // if (!empty($where)) $where = "WHERE 1 " . $where;
  $sql = "SELECT count(*) as total FROM {$tbl_name} {$where}";
  // echo "top sql : $sql <br>";

  $re = sql_fetch($sql);
  $tcnt = $re['total']; // 전체 게시물수
  $total_cnt = $tcnt; // 쿼리스트링 세팅

  $page_rows = $end; // 한페이지에 표시할 데이터 수
  $total_page = ceil($tcnt / $page_rows); // 총 페이지수

 // echo "tcnt : $tcnt <br>";
// echo "total_page : $total_page <br>";

  // 총페이지가 0이라면 1로 설정
  if ($total_page == 0) {
    ++$total_page;
  }

  // $end == 20 ? $block_limit = 7 : $block_limit = 10;
  $block_limit = 10; // 한 화면에 뿌려질 블럭 개수
  $total_block = ceil($total_page / $block_limit); // 전체 블록수
  $cur_page = $cur_page ? $cur_page : 1; // 현재 페이지
  $cur_block = ceil($cur_page / $block_limit); // 현재블럭 : 화면에 표시 될 페이지 리스트
  $first_page = (((ceil($cur_page / $block_limit) - 1) * $block_limit) + 1); // 현재 블럭의 시작
  $end_page = $first_page + $block_limit - 1; // 현재 블럭의 마지막

  // echo "total_block : $total_page block <br>";
  // echo "cur_block : $cur_block<br>";
  // echo "cur_page : $cur_page<br>";
  // echo "first_page : $first_page <br>";
  // echo "end_page : $end_page <br>";
  // echo "block_limit : $block_limit <br>";



  if ($total_page < $end_page) {
    $end_page = $total_page;
  }

  $prev = $first_page - 1;
  $next = $end_page + 1;
  // 페이징 준비 끝


  // $sql = "SELECT * FROM {$tbl_name} LIMIT {$first_page},{$end_page}";
  // // echo $sql;
  // $total_cnt = sql_num_rows($sql);

  // 이전 블럭을 눌렀을때 현재 페이지 세팅.
// $prev_block = $cur_page - $block_limit;
// 처음 if 조건은, 현재페이지가 23페이지일경우, 이전블럭을 눌렀을때
//  20페이지가 아닌, 13페이지로 세팅이 되어서 계산조절한것.
  if ($end_page == $total_page) {
    $prev_block = floor($end_page / $block_limit) * $block_limit;
  } else {
    $prev_block = $end_page - $block_limit;
  }
  if ($prev_block < $block_limit + 1) {
    $prev_block = $block_limit;
  }

  // 다음블럭의 첫번째 페이지 산출
// $next_block = $cur_page + $block_limit;
  $next_block = $end_page + 1;
  if ($next_block > $total_page) {
    $next_block = (($cur_block + 1) * $block_limit) - ($block_limit - 1);
  }

  // 이전 버튼을 눌렀을때 LIMIT 처리
  $prev_start = $first_page - $block_limit;
  $prev_end = $end_page - $block_limit;
  if ($prev_start < $block_limit + 1) {
    $prev_start = 1;
    $prev_end = $block_limit;
  }

  // 다음 버튼을 눌렀을때 LIMIT 처리
  $next_start = $first_page + $block_limit;
  $next_end = $end_page + $block_limit;
  if ($next_end > $total_page) {
    $next_end = $total_page;
    if ($next_start > $next_end) {
      $next_start = $cur_block * $block_limit + 1;
    }
  }

  // echo "<br>";
// echo "prev_start : $prev_start <br>";
// echo "next_start : $next_start <br>";

  // 블럭 이동용 쿼리스트링 만들기 - 처음
  $prev_qs = $next_qs = "?";
  foreach($arr as $i => $v){
      if($i == "cur_page"){
        $prev_qs .= "cur_page={$prev_block}&";  
      }else if($i == "start"){
        $prev_qs .= "start={$prev_start}&";  
      }else{
        $prev_qs .= "{$i}={$$i}&";
      }
  }

  // 블럭 이동용 쿼리스트링 만들기 - 마지막
  foreach($arr as $i => $v){
      if($i == "cur_page"){
        $next_qs .= "cur_page={$next_block}&";  
      }else if($i == "start"){
        $next_qs .= "start={$next_start}&";  
      }else{
        $next_qs .= "{$i}={$$i}&";
      }
  }
  
  $cur_path = $_SERVER['SCRIPT_NAME'];
  $prev_url = $cur_path.$prev_qs; 
  $next_url = $cur_path.$next_qs;

  
  
  // var_dump($prev_qs);
  // echo "<br>";
  // var_dump($next_qs);
  

  // 이전, 다음버튼 제어 처리
  if ($cur_block == $total_block) {
    $end_class = "disabled";
    $li_href2 = " ";
  } else {
    $end_class = " ";
    $li_href2 = "href='{$next_url}'";
  }
  if ($cur_block == 1) {
    $start_class = "disabled";
    $li_href1 = " ";
  } else {
    $start_class = " ";
    $li_href1 = "href='{$prev_url}'";
  }


  
  
  // 페이지 이동용 쿼리스트링 만들기 
  $p_qs = "?";
  foreach($arr as $i => $v){
    if($i == "cur_page"){
    }else{
      $p_qs .= "{$i}={$$i}&";
    }
  }

  echo "<ul class='pagination'>";
  // <!-- li태그의 클래스에 disabled를 넣으면 마우스를 위에 올렸을 때 클릭 금지 마크가 나오고 클릭도 되지 않는다.-->
  // <!-- disabled의 의미는 앞의 페이지가 존재하지 않다는 뜻이다. -->
  echo "<li class='page-item {$start_class}'>";
  echo "<a {$li_href1}>«</a>";
  echo "</li>";
  // <!-- li태그의 클래스에 active를 넣으면 색이 반전되고 클릭도 되지 않는다. -->
// <!-- active의 의미는 현재 페이지의 의미이다. -->
  for ($i = $first_page; $i <= $end_page; $i++) {
    if ($i == $cur_page) {
      $act = "active";
      $cont = "<a>{$i}</a>";
    } else {
      $act = " ";
      
      $cur_url = $cur_path . $p_qs . "cur_page={$i}";
      $cont = "<a href='{$cur_url}'>{$i}</a>";
    }
    echo "<li class='page-item {$act}'>{$cont}</li>";
  }
  echo "<li class='page-item {$end_class}'><a {$li_href2}>»</a></li>";
  echo "</ul>";
}




?>