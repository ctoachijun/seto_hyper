<?
include "../lib/hyper.php";
$aidx = $_SESSION['admin_idx'];

switch ($w_mode) {
  case "adminChk":
    $re = getAdminInfo($id);

    if (!$re) {
      $output['state'] = "N";
    } else {
      $admin_pw = $re['a_pw'];

      // 해시 암호화 된 비밀번호 비교 return : bool
      if (password_verify($pw, $admin_pw)) {
        $jud = 1;
      }

      if ($jud == 1) {
        $output['state'] = "Y"; 
        $_SESSION['admin_id'] = $id;
        $_SESSION['admin_idx'] = $re['a_idx'];
        $_SESSION['admin_group'] = $re['a_group'];
      } else {
        $output['state'] = "N";
      }
    }
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
  break;
  
  case "chkBrandName" :
    $sql = "SELECT * FROM st_brand WHERE b_aidx = {$aidx} AND b_name='{$bname}'";
    $re = sql_fetch($sql);
    
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    
    echo json_encode($output);
  break;

  case "chkBrandNameEdit" :
    if($org == $bname){
      $output['state'] = "N";      
    }else{
      $sql = "SELECT * FROM st_brand WHERE b_aidx = {$aidx} AND b_name='{$bname}'";
      $re = sql_fetch($sql);
      
      if($re){
        $output['state'] = "Y";
      }else{
        $output['state'] = "N";
      }
    }
    
    echo json_encode($output);
  break;
  
  case "regBrand" :
    $lfile = $_FILES['logo'];
    $lftmp = $lfile['tmp_name'];
    $lname = $lfile['name'];

    if(!empty($lname)){
      // 디렉토리 확인 후 없으면 생성
      $path = chkBrandDir($bname);

      
      // 파일이름 설정
      $lname_box = explode(".",$lname);
      $whak = end($lname_box);
      $logo = "logo_{$bname}.{$whak}";
      
      // 업로드
      $res = move_uploaded_file($lftmp, $path."/".$logo);
      if($res){
        $bname = addslashes($bname);
        $bdesc = addslashes($bdesc);
        
        $sql = "INSERT INTO st_brand SET b_aidx = {$aidx}, b_name = '{$bname}', b_logo = '{$logo}', b_intro = '{$bdesc}', b_wdate = now();";
        $re = sql_exec($sql);
        $output['sql'] = $sql;
        
        if($re){
          $output['state'] = "Y";
        }else{
          $output['state'] = "N";
        }
      }else{
        $output['state'] = "FN";  // 업로드 실패
      }
    }

    echo json_encode($output);
  break;

  case "editBrand" :
    $lfile = $_FILES['logo'];
    $lftmp = $lfile['tmp_name'];
    $lname = $lfile['name'];

    $path = chkBrandDir($org_bname);
    if(!empty($lname)){
      
      // 파일이름 설정
      $lname_box = explode(".",$lname);
      $whak = end($lname_box);
      $logo = "logo_{$bname}.{$whak}";
      
      // 업로드
      $res = move_uploaded_file($lftmp, $path."/".$logo);
      if($res){
        $bname = addslashes($bname);
        $bdesc = addslashes($bdesc);
        
        $sql = "UPDATE st_brand SET b_name = '{$bname}', b_logo = '{$logo}', b_intro = '{$bdesc}' WHERE b_idx = {$brand_index}";
        $re = sql_exec($sql);
        $output['sql'] = $sql;
        
        if($re){
          $output['state'] = "Y";
          $output['cmd'] = chgBrandDirName($org_bname,$bname);
        }else{
          $output['state'] = "N";
        }
      }else{
        $output['state'] = "FN";  // 업로드 실패
      }
    }else{
      $sql = "UPDATE st_brand SET b_name = '{$bname}', b_intro = '{$bdesc}' WHERE b_idx = {$brand_index}";
      $re = sql_exec($sql);
      $output['sql'] = $sql;
      
      if($re){
        $output['state'] = "Y";
        $output['chg'] = chgBrandDirName($org_bname,$bname);
      }else{
        $output['state'] = "N";
      }
    }
    $output['bname'] = $bname;
    
    echo json_encode($output);
  break;

  case "setKeyWord":
    $output['html'] = setKeywordHtml($keyword);
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  case "keywordDel":
    $idx = $cnum -1;
    
    $output['nums'] = "$idx - $cnum";
    
    $box = explode("|",$keyword);
    
    $output['box'] = $box;
    $output['target'] = $box[$idx];
    
    unset($box[$idx]);
    
    $new_kw = implode("|",$box);
    
    $output['new_kw'] = $new_kw;
    $output['html'] = setKeywordHtml($new_kw);
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  case "delBrand" :
      
    // 브랜드 정보 삭제
    $sql = "DELETE FROM st_brand WHERE b_idx = {$bidx}";
    $re = sql_exec($sql);

    if($re){
      // 브랜드와 관련 된 상품 정보 삭제
      $sql = "DELETE FROM st_item WHERE i_bidx = {$bidx}";
      $re2 = sql_exec($sql);
      
      if($re2){
        // 해당 브랜드 디렉토리 삭제(로고, 상품 이미지들 전부 삭제)
        $path = chkBrandDir($bname);
        exec('rm -rf "'.$path.'"');
        $output['state'] = "Y";
      }else{
        $output['state'] = "IN";
      }
    }else{
      $output['state'] = "BN";
    }
    
    echo json_encode($output);   
  break;
  
  case "regItem":
    $output['post'] = $_POST;
    if($reg_type == "E"){
      $iidx = $datetime_jud;
      $ifile = $_FILES['thumbsnail_img'];
      $iftmp = $ifile['tmp_name'];
      $iname = $ifile['name'];
      
      // 파일 새로 올렸으면 업로드, 아니면 기존 이름 그대로.      
      if(!empty($iname)){
        
        // 디렉토리 확인 후 없으면 생성 및 경로 확보
        $brand = getBrandInfo($brand_index);
        $bname = $brand['b_name'];
        $path = chkBrandDir($bname);
  
        // 파일이름 중복 확인
        $file_name = getFilename($iname,$path);
        
        //업로드
        $res = move_uploaded_file($iftmp, $path."/".$file_name);
        // $res = true;
        if(!$res){
          $output['state'] = "FN";   // 업로드 실패
        }      
  

      }else{
        $file_name = $item_img;
      }
      
      $pname = addslashes($product_name);
      $period = $order_start."|".$order_end;
      if(!$product_moq) $product_moq = 1;

      
      // 상품 정보 업데이트
      $sql = "UPDATE st_item SET i_bidx = {$brand_index}, i_name = '{$pname}', i_img = '{$file_name}', i_keyword = '{$keyword_txt}', i_deliday = '{$delivery_maybe}', i_delival = $delivery_coast,
        i_delicomp = '{$delivery_comp}', i_period = '{$period}', i_quantity = {$product_quantity}, i_moq = {$product_moq}, i_price = {$product_price}, i_sell_type = '{$sale_type}'
        WHERE i_idx = {$iidx}";
      $re = sql_exec($sql);
      // $output['sql'] = $sql;
      
      if(!$re) $output['state'] = "N";
      
      
      // 옵션 정보 업데이트
      // 옵션 개수별로 column 세팅
      for($i=1,$a=0; $i<=$opt_cnt; $i++){
        $title = ${"optname".$i};
        $opt_name = ${"optvalue".$i};
        
        $io_col .= "io{$i}_name = '{$title}', io{$i}_value = '{$opt_name}' ";
        
        if($i < $opt_cnt){
          $io_col .= ",";
        }
      }
      
      $io_sql = "UPDATE st_item_opt SET {$io_col} WHERE io_iidx = {$iidx}";
      $io_re = sql_exec($io_sql);
      $output['io_sql'] = $io_sql;
      
      if(!$io_re){
        $output['state'] = "ION";
      }
      
      
      
      // 재고수량, 추가금액 입력 - 부분적으로 지워진 옵션에 대응하기위해 전부 다 입력
      $io_sql = "SELECT * FROM st_item_opt WHERE io_iidx = {$iidx}";
      $io_re = sql_fetch($io_sql);
      $io_idx = $io_re['io_idx'];
      
      $ioe_del_sql = "DELETE FROM st_item_opt_etc WHERE ioe_ioidx = {$io_idx}";
      $ioe_del_re = sql_exec($ioe_del_sql);
      
      for($i=0; $i<count($addquan); $i++){
        $ioe_value = $opt_v1[$i].",".$opt_v2[$i].",".$opt_v3[$i];
        $ioe_keep = $addquan[$i];
        $ioe_add_value = $addval[$i];
        
        $ioe_sql = "INSERT INTO st_item_opt_etc SET ioe_ioidx = {$io_idx}, ioe_value = '{$ioe_value}', ioe_keep = '{$ioe_keep}', ioe_add_value = '{$ioe_add_value}', ioe_wdate = now()";
        $ioe_re = sql_exec($ioe_sql);        
        
        
        if(!$ioe_re){
          $output['state'] = "IOE";
        }
      }

      // 기간설정 입력
      if($write_now == "Y1"){
        $now_page = "L";
      }else if($write_now == "Y2"){
        $now_page = "O";
      }else if($write_now == "Y3"){
        $now_page = "P";
      }else{
        $now_page = "N";          
      }

      $landing_date = $land_start."|".$land_end;
      $open_date = $open_start."|".$open_end;
      $pre_date = $pre_start."|".$pre_end;
      
      $trans_sql = "UPDATE st_item_step SET is_landing_date = '{$landing_date}', is_open_date = '{$open_date}', is_pre_date = '{$pre_date}', is_now_page = '{$now_page}' WHERE is_iidx = {$iidx}";
      $trans_re = sql_exec($trans_sql);
      $output['trans_sql'] = $trans_sql;

      if(!$trans_re){
        $output['state'] = "TN";
      }
            
      
      
    }else{
      
      $ifile = $_FILES['thumbsnail_img'];
      $iftmp = $ifile['tmp_name'];
      $iname = $ifile['name'];
      
      // $iname = "dd";
      if(!empty($iname)){
        
        // 디렉토리 확인 후 없으면 생성 및 경로 확보
        $brand = getBrandInfo($brand_index);
        $bname = $brand['b_name'];
        $path = chkBrandDir($bname);
  
        // 파일이름 중복 확인
        $file_name = getFilename($iname,$path);
        
        //업로드
        $res = move_uploaded_file($iftmp, $path."/".$file_name);
        // $res = true;
        if($res){
          $pname = addslashes($product_name);
          $period = $order_start."|".$order_end;
          
          if(!$product_moq) $product_moq = 1;
          
          $sql = "INSERT INTO st_item SET i_bidx = {$brand_index}, i_name = '{$pname}', i_img = '{$file_name}', i_keyword = '{$keyword_txt}', i_deliday = '{$delivery_maybe}', i_delival = $delivery_coast,
                  i_delicomp = '{$delivery_comp}', i_period = '{$period}', i_quantity = {$product_quantity}, i_moq = {$product_moq}, i_price = {$product_price}, i_sell_type = '{$sale_type}',
                  i_wdate = now();";
          $re = sql_exec($sql);
          // $output['sql'] = $sql;
  
          
          // 상품 idx 확보
          $sql1 = "SELECT * FROM st_item ORDER BY i_idx DESC LIMIT 0,1";
          $re1 = sql_fetch($sql1);
          $iidx = $re1['i_idx'];
          
          // 옵션 개수별로 column 세팅
          for($i=1,$a=0; $i<=$opt_cnt; $i++){
            $title = ${"optname".$i};
            $opt_name = ${"optvalue".$i};
            
            $io_col .= "io{$i}_name = '{$title}', io{$i}_value = '{$opt_name}', ";
          }
          
          $io_sql = "INSERT INTO st_item_opt SET io_iidx = {$iidx}, {$io_col} io_wdate = now()";
          $io_re = sql_exec($io_sql);
          
          // 옵션 idx 확보
          $io_idx_sql = "SELECT * FROM st_item_opt ORDER BY io_idx DESC LIMIT 0,1";
          $io_idx_re = sql_fetch($io_idx_sql);
          $ioidx = $io_idx_re['io_idx'];
          
          // 재고수량, 추가금액 입력 - 부분적으로 지워진 옵션에 대응하기위해 전부 다 입력
          for($i=0; $i<count($addquan); $i++){
            $ioe_value = $opt_v1[$i].",".$opt_v2[$i].",".$opt_v3[$i];
            $ioe_keep = $addquan[$i];
            $ioe_add_value = $addval[$i];
            
            $ioe_sql = "INSERT INTO st_item_opt_etc SET ioe_ioidx = {$ioidx}, ioe_value = '{$ioe_value}', ioe_keep = '{$ioe_keep}', ioe_add_value = '{$ioe_add_value}', ioe_wdate = now()";
            $ioe_re = sql_exec($ioe_sql);
          }
          
          
          // 기간설정 입력
          // $write_now == "Y1" ? $now_page = "L" : $write_now == "Y2" ? $now_page = "O" : $write_now == "Y3" ? $now_page = "P" : $now_page = "L";
          if($write_now == "Y1"){
            $now_page = "L";
          }else if($write_now == "Y2"){
            $now_page = "O";
          }else if($write_now == "Y3"){
            $now_page = "P";
          }else{
            $now_page = "N";          
          }
  
          $landing_date = $land_start."|".$land_end;
          $open_date = $open_start."|".$open_end;
          $pre_date = $pre_start."|".$pre_end;
          
          $trans_sql = "INSERT INTO st_item_step SET is_iidx = {$iidx}, is_landing_date = '{$landing_date}', is_open_date = '{$open_date}', is_pre_date = '{$pre_date}', is_now_page = '{$now_page}', is_wdate = now()";
          $trans_re = sql_exec($trans_sql);
          $output['trans_sql'] = $trans_sql;
          
  
          if($re){
            $output['state'] = "Y";
            
            if(!$io_re) $output['state'] = "ION";
            if(!$trans_re) $output['state'] = "TN";
            
          }else{
            $output['state'] = "N";
          }
        }else{
          $output['state'] = "FN";  // 업로드 실패
        }
        
      }else{
        $output['state'] = "NI"; // 이미지 없음
      }
    }
    
    $output['returnurl'] = $return_page;
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  case "delItem":
    
    $sql_optidx = "SELECT * FROM st_item_opt WHERE io_iidx = {$iidx}";
    $re_optidx = sql_fetch($sql_optidx);
    $io_idx = $re_optidx['io_idx'];
    
    // 수량, 가격 테이블 연관데이터 삭제
    $sql_opt_etc = "DELETE FROM st_item_opt_etc WHERE ioe_ioidx = {$io_idx}";
    
    // 옵션 테이블 연관데이터 삭제
    $sql_opt = "DELETE FROM st_item_opt WHERE io_iidx = {$iidx}";
    
    // 상품 테이블 데이터 삭제
    $sql = "DELETE FROM st_item WHERE i_idx = {$iidx}";
    
    $output['sql_etc'] = $sql_opt;
    $output['sql_opt'] = $sql_opt_etc;
    $output['sql'] = $sql;
    
    echo json_encode($output);
  break;
    
  case "addOpt":
    $output['name'] = $name;
    $output['value'] = $value;
    $output['html'] = getOptInputHtml($cnt,$name,$value);
    $output['cnt'] = $cnt+1;
        
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  case "setOptTable":
    $output['opt_name'] = $opt_name;
    $output['opt_value'] = $opt_value;
    $output['html'] = getOptTableHtml($opt_name,$opt_value,$cnt,"");
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  case "delOpt":
    $output['name'] = $name;
    $output['value'] = $value;
    $output['html'] = getOptInputHtmlDel($cnt,$name,$value);
    $output['cnt'] = $cnt-1;
        
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  
  
  
  
  default:
    $output['error'] = "error!! switch error!!!!";
    echo json_encode($output);

}


?>