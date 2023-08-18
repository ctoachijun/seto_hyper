<?
// header('content-Type: text/json');
// header('Access-Control-Allow-Origin: *');

include "../lib/hyper.php";


switch ($w_mode) {
    
  case "collectEmail" :
    $iidx = decodeParam($code);
    
    $item = getItemInfo($iidx);
    $bidx = $item['i_bidx'];
    $iname = $item['i_name'];
    
    $brand = getBrandInfo($bidx);
    $bname = $brand['b_name'];
    $admin_idx = $brand['b_aidx'];    
    
    $sql = "INSERT INTO st_smail SET s_aidx = {$admin_idx}, s_iidx = {$iidx}, s_iname = '{$iname}', s_email = '{$email}', s_wdate = now()";
    $re = sql_exec($sql);
    
    
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    
    // $output['sql'] = $sql;
    echo json_encode($output);
  break;
  


  default:
    echo "ajax error. maybe json.";
}

?>