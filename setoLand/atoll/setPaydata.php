<?

include "./setofunc.php";

switch($w_mode){
  case "setPayData" :
    
    if($opt == "S"){
      $price = 500;
    }else if($opt == "C"){
      $price = 1000;
    }else if($opt == "D"){
      $price = 1500;
    }
    
    $product = "ATOLL Black";
    $option = "Model $opt";
    
    $html = "
      <form id='setData' name='setData' method='post' action='inputInfo2.php'>
        <input type='hidden' name='product' value='{$product}' />
        <input type='hidden' name='option' value='{$option}' />
        <input type='hidden' name='price' value='{$price}' />
        </form>
    
    ";
    
    $output['html'] = $html;
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    
  break;
        
  case "testDb" :
    
    $order_id = $midx.mktime(date('now'));
    $sql = "INSERT INTO st_order SET o_midx = 1, o_pidx = 1, o_sidx = {$sidx}, o_number = '{$order_id}', o_tel = '{$tel}', 
              o_email = '{$email}', o_addr = '{$mem_addr}', o_daddr = '{$mem_daddr}', o_popt = '{$popt}',
              o_pval = {$pval}, o_pmidx = 1, o_odate = now()
    ";
    $re = sql_exec($sql);
    
    if($re){
      $output['stat3'] = "Y";
    }else{
      $output['state'] = "N";
    }
    
    
    $output['sql'] = $sql;
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    
    
  break;
  
  
  
    
  default :
    $output['error'] = "switch error";  
  
}



?>