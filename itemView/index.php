<?
include "../lib/hyper.php";

// 제품 idx로 세팅
$iidx = decodeParam($itemMngCode);

// 현재 공개단계를 결정
$step = getItemStep($iidx);
$nowp = $step['is_now_page'];
$today = date("Y-m-d");
$now_step = $nowp;

// $box1 = explode("|",$step['is_landing_date']);
// $box2 = explode("|",$step['is_open_date']);
// $box3 = explode("|",$step['is_pre_date']);


if($nowp == "N"){
  
  //시작일과 종료일별로 현재 진행단계를 파악
  $now_step = judStepDate($step['is_landing_date'],$step['is_open_date'],$step['is_pre_date']);
   
}else if($nowp == "L"){
  // echo "랜딩 즉시적용이다아~!!!<br>";
}else if($nowp == "O"){
  // echo "펀딩 오픈 즉시적용이다아~~~!!!!!<br>";
}else if($nowp == "P"){
  // echo "프리오더 즉시 !!!<br>";
}


// 일자도, 즉시적용도 아무것도 없는 상태
// 3단계중 그 어떤 페이지도 출력 할 수 없는상태. 안내페이지 하나 만들어서 거기로 연결하자.
if($now_step == "N"){
  echo "즉시적용도 없고, 일자 입력도 없어서 랜딩, 오픈, 프리오더 어느쪽도 표시 할 수가 없습니다.<br>";
  echo "상품 설정을 확인 해 주세요.";
}else{
  
  // include 경로 추출
  $item = getItemInfo($iidx);
  $landing_url = $item['i_landing_url'];
  $preorder_url = $item['i_preorder_url'];
  $funding_url = $item['i_funding_url'];
  
  if($now_step == "P"){
    $preo_box = explode("setoLand",$preorder_url);
    if(!empty($preo_box[1])){
      $path = $preo_box[1];
    }
  }else{
    $land_box = explode("setoLand",$landing_url);
    if(!empty($land_box[1])){
      
      // url 마지막에 '/' 유무에 따른 경로 오류 방지. 
      $lstr = substr($land_box[1],-1);
      if($lstr == "/"){
        $path = $land_box[1]."index.php";
      }else{
        $path = $land_box[1]."/index.php";
      }
    }
  }
  
  // var_dump("../setoLand{$path}");
  // 해당 url이 있는경우에는 include.  
  if(empty($path)){
    echo "페이지 지정이 없습니다...;;";
    // 페이지 지정이 없을때 처리를 넣으면 된다.
    
  }else{
    include "../setoLand{$path}";
  }
}




?>