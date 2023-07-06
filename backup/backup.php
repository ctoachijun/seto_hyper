<?
echo "백업 시작합니다~<br>";

$today = date("ymd");
$src_name = $today."_src.tar.gz";

if(is_file("./".$src_name)){
  echo "오늘분 백업본이 있으니 패스합니다.";
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