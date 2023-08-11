<?
// vscode에서 backup도 제외 목록중 하나이기때문에 수정후에는 upload 처리 필수.


echo "백업 시작합니다~<br>";

$today = date("ymd");
$hour = date("H");

if($hour < 12 && $hour > 0){
  $htxt = "AM";
}else if($hour >= 12 && $hour < 15){
  $htxt = "PM1";
}else{
  $htxt = "PM2";
}

$src_name = $today."_".$htxt."_src.tar.gz";

if(is_file("./".$src_name)){
  echo "오늘분 백업본이 있으니 패스합니다.";
  echo "<br><br>{$src_name}<br>";
}else{
  
  $comm = "tar zcvf {$src_name} ../ --exclude=backup";
  echo "실행합니다. <br> $comm <br>";
  
  exec($comm);
  
  if(is_file("./".$src_name)){
    echo "정상 동작했습니다.";
  }else{
    echo "실패 했습니다.";
  }
}




?>