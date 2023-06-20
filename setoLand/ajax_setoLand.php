<?
include "../lib/hyper.php";


switch ($w_mode) {
  case "regEmail":
    $sql = "INSERT INTO st_smail SET s_iidx = {$iidx}, s_email = '{$email}', s_wdate = now()";
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