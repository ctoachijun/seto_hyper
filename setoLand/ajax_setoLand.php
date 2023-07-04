<?
header('content-Type: text/json');
header('Access-Control-Allow-Origin: *');

include "../lib/hyper.php";


switch ($w_mode) {
  case "regEmail":
    
    if($test == 1){
      $iidx = 1;
      $aidx = 1;
    }
    
    $sql = "INSERT INTO st_smail SET s_aidx = {$aidx}, s_iidx = {$iidx}, s_iname = '{$type}', s_email='{$email}',s_wdate = now();";
    $re = sql_exec($sql);
    
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    $output['sql'] = $sql;
    echo json_encode($output);
  break;


  default:
    echo "ajax error. maybe json.";
}

?>