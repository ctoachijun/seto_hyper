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
    $output['file'] = $_FILES;
    $output['post'] = $_POST;
    
    $ifile = $_FILES['thumbsnail_img'];
    $iftmp = $ifile['tmp_name'];
    $iname = $ifile['name'];
    
    if(!empty($iname)){
      
      // 디렉토리 확인 후 없으면 생성
      $brand = getBrandInfo($brand_index);
      $bname = $brand['b_name'];
      $path = chkBrandDir($bname);

      // 파일이름 중복 확인
      $file_name = getFilename($iname,$path);
      
      // 업로드
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

        
        // 일단 상품 idx 확보
        $sql1 = "SELECT * FROM st_item ORDER BY i_idx DESC LIMIT 0,1";
        $re1 = sql_fetch($sql1);
        $iidx = $re1['i_idx'];
        
        
        // 
        // 단계별 오픈정보 등록 추가하기
        // 
        
        
        // 옵션 등록
        for($i=1; $i<=$opt_cnt; $i++){
          $title = ${"optname".$i};
          $opt_name = ${"optvalue".$i};
          
          if($i == 1){
            $sql_o1 = "INSERT INTO st_item_opt1 SET io1_iidx = {$iidx}, io1_title = '{$title}', io1_name = '{$opt_name}', io1_wdate = now();";
          }else if($i == 2){
            $o1idx_sql = "SELECT * FROM st_item_opt1 ORDER BY io1_idx DESC LIMIT 0,1";
            $o1idx_re = sql_fetch($o1idx_sql);
            $o1_idx = $o1idx_re['io1_idx'];
            $sql_o2 = "INSERT INTO st_item_opt2 SET io2_io1idx = {$o1_idx}, io2_title = '{$title}', io2_name = '{$opt_name}', io2_wdate = now();";
          }else if($i == 3){
            $o2idx_sql = "SELECT * FROM st_item_opt2 ORDER BY io2_idx DESC LIMIT 0,1";
            $o2idx_re = sql_fetch($o2idx_sql);
            $o2_idx = $o2idx_re['io2_idx'];
            $sql_o3 = "INSERT INTO st_item_opt3 SET io3_io2idx = {$o2_idx}, io3_title = '{$title}', io3_name = '{$opt_name}', io3_wdate = now();";
          }
          
          $output['sql'.$i] = ${"sql_o".$i};
          sql_exec(${"sql_o".$i});
        }
        
        
        if($re){
          $output['state'] = "Y";
        }else{
          $output['state'] = "N";
        }
      }else{
        $output['state'] = "FN";  // 업로드 실패
      }
      
    }else{
      $output['state'] = "NI"; // 이미지 없음
    }

    $output['returnurl'] = $return_page;
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
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
    $output['html'] = getOptTableHtml($opt_name,$opt_value,$cnt);
    
    
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