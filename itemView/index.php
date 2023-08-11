<?
include "../lib/hyper.php";

// 제품 idx로 세팅
$iidx = decodeParam($itemMngCode);

// 현재 공개단계를 결정
$step = getItemStep($iidx);
$nowp = $step['is_now_page'];
$today = date("Y-m-d");
$now_step = $nowp;

if($nowp == "N"){
  $box1 = explode("|",$step['is_landing_date']);
  $box2 = explode("|",$step['is_open_date']);
  $box3 = explode("|",$step['is_pre_date']);
  
  
  // 각 종료일을 기준으로 우선 단계를 파악.
  if(!empty($box1[1]) && $today <= $box1[1]){
    $now_step = "L";
    echo "랜딩이다! <br>";
  }else if(!empty($box2[1]) && $today <= $box2[1]){
    $now_step = "O";
    echo "펀딩중이다!!!<br>";
  }else if(!empty($box3[1] && $today <= $box3[1])){
    $now_step = "P";
    echo "프리오더다!!! <br>";
  }else{
    //종료일 기준으로 단계가 없을때 시작일 기준으로 단계를 파악
    if(!empty($box3[0]) && $today >= $box3[0]){
      $now_step = "P";
      echo "프리오더다!!! <br>";
    }else if(!empty($box2[0]) && $today >= $box2[0]){
      $now_step = "O";
      echo "펀딩중이다!!!<br>";
    }else if(!empty($box1[0] && $today >= $box1[0])){
      $now_step = "L";
      echo "랜딩이다! <br>";
    }else{
      echo "암것도 없다아~!!!<br>";
    }
  }
  
}else if($nowp == "L"){
  echo "랜딩 즉시적용이다아~!!!<br>";
}else if($nowp == "O"){
  echo "펀딩 오픈 즉시적용이다아~~~!!!!!<br>";
}else if($nowp == "P"){
  echo "프리오더 즉시 !!!<br>";
}


// 3단계 스텝 중 하나인 경우에만 해당 페이지를 include
if($now_page == "N"){
  echo "암것도 없으면...뭘 가져와서 보여주죠??? <br>";
}else{
  // include 경로 추출
  $item = getItemInfo($iidx);
  $landing_url = $item['i_landing_url'];
  $preorder_url = $item['i_preorder_url'];
  
  if($now_step == "P"){
    $preo_box = explode("setoLand/",$preorder_url);
    if(!empty($preo_box[1])){
      $path = $preo_box[1];
    }
  }else{
    $land_box = explode("setoLand/",$landing_url);
    if(!empty($land_box[1])){
      $path = $land_box[1]."index.php";
    }
  }
  
  // 해당 url이 있는경우에는 include.  
  if(empty($path)){
    echo "페이지 지정이 없습니다...;;";
  }else{
    include "../setoLand/{$path}";
  }
}



?>