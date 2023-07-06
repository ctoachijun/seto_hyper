<?
include "../lib/hyper.php";
include_once "../lib/PHPExcel/Classes/PHPExcel.php";
$aidx = $_SESSION['admin_idx'];
$aid = $_SESSION['admin_id'];

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
        $_SESSION['admin_top'] = $re['a_top'];
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

    $output['files'] = $_FILES;
    
    if(!empty($lname)){
      // 디렉토리 확인 후 없으면 생성
      $path = chkBrandDir($bname);

      $output['path'] = $path;
      // 파일이름 설정
      $lname_box = explode(".",$lname);
      $whak = end($lname_box);
      $logo = "logo_brand.{$whak}";
      
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

          // 로그
          $exec = "브랜드 \"{$bname}\" 등록";
          $sql = addslashes($sql);
          setAdminLog($aid,$aidx,$sql,$exec);
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
      $logo = "logo_brand.{$whak}";
      
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
          $output['org_name'] = $bname;

          // 로그
          $exec = "브랜드 \"{$org_bname} -> {$bname}\" 정보 수정";
          $sql = addslashes($sql);
          setAdminLog($aid,$aidx,$sql,$exec);
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
        $output['org_name'] = $bname;
        
        // 로그
        $exec = "브랜드 \"{$org_bname} -> {$bname}\" 정보 수정";
        $sql = addslashes($sql);
        setAdminLog($aid,$aidx,$sql,$exec);
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
      $sql1 = "DELETE FROM st_item WHERE i_bidx = {$bidx}";
      $re2 = sql_exec($sql1);
      
      if($re2){
        // 해당 브랜드 디렉토리 삭제(로고, 상품 이미지들 전부 삭제)
        $path = chkBrandDir($bname);
        exec('rm -rf "'.$path.'"');
        $output['state'] = "Y";
        
        // 로그
        $sql_txt = "{$sql}\n{$sql2}";
        $exec = "브랜드 \"{$bname}\" 및 관련 상품 정보 삭제";
        $sql_txt = addslashes($sql_txt);
        setAdminLog($aid,$aidx,$sql_txt,$exec);
        
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
      $output['state'] = "Y";
      $iidx = $datetime_jud;
      $return_page = $return_page."brand_index={$brand_index}&cur_page={$cur_page}";
      
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
      !$write_now ? $now_page = "N" : $now_page = $write_now;
      $landing_date = $land_start."|".$land_end;
      $open_date = $open_start."|".$open_end;
      $pre_date = $pre_start."|".$pre_end;
      
      $trans_sql = "UPDATE st_item_step SET is_landing_date = '{$landing_date}', is_open_date = '{$open_date}', is_pre_date = '{$pre_date}', is_now_page = '{$now_page}' WHERE is_iidx = {$iidx}";
      $trans_re = sql_exec($trans_sql);
      $output['trans_sql'] = $trans_sql;

      if(!$trans_re){
        $output['state'] = "TN";
      }
      
      // 로그
      $sql_txt = "{$sql}\n{$io_sql}\n{$ioe_sql}\n{$trans_sql}";
      $exec = "상품 \"{$pname}\" 및 관련 정보 수정";
      $sql_txt = addslashes($sql_txt);
      setAdminLog($aid,$aidx,$sql_txt,$exec);
      
      
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
          !$write_now ? $now_page = "N" : $now_page = $write_now;
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

            // 로그
            $sql_txt = "{$sql}\n{$io_sql}\n{$ioe_sql}\n{$trans_sql}";
            $exec = "상품 \"{$pname}\" 및 관련 정보 등록";
            $sql_txt = addslashes($sql_txt);
            setAdminLog($aid,$aidx,$sql_txt,$exec);

            
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
    
    $iidx = $item_idx;
    
    $sql_optidx = "SELECT * FROM st_item_opt WHERE io_iidx = {$iidx}";
    $re_optidx = sql_fetch($sql_optidx);
    $io_idx = $re_optidx['io_idx'];
    
    // 기간 관련 데이터 삭제
    $sql_step = "DELETE FROM st_item_step WHERE is_iidx = {$iidx}";
    $step_re = sql_exec($sql_step);
    
    // 수량, 가격 테이블 연관데이터 삭제
    $sql_opt_etc = "DELETE FROM st_item_opt_etc WHERE ioe_ioidx = {$io_idx}";
    $opt_etc_re = sql_exec($sql_opt_etc);
    
    // 옵션 테이블 연관데이터 삭제
    $sql_opt = "DELETE FROM st_item_opt WHERE io_iidx = {$iidx}";
    $opt_re = sql_exec($sql_opt);
    
    // 해당 상품 대표이미지 삭제
    $brand = getBrandInfo($bindex);
    $bname = $brand['b_name'];
    $path = chkBrandDir($bname);
    $target = $path."/".$img;
    
    if(!unlink($target)){
      $output['state2'] = "FN";
    }
    $output['target'] = $target;
    
    
    // 상품 테이블 데이터 삭제
    $sql = "DELETE FROM st_item WHERE i_idx = {$iidx}";
    $re = sql_exec($sql);
    
    if($re){
      $output['state'] = "Y";
      
      // 로그
      $sql_txt = "{$sql_step}\n{$sql_opt_etc}\n{$sql_opt}\n{$sql}";
      $exec = "상품 \"{$pname}({$iidx})\" 및 관련 정보 삭제";
      setAdminLog($aid,$aidx,$sql_txt,$exec);
      
    }else{
      $output['state'] = "N";
    }
    
    
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
  
  case "setStepDate":
    !$now ? $now_page = "N" : $now_page = $now;
    
    $sql = "UPDATE st_item_step SET 
      is_landing_date = '{$land_date}', is_open_date = '{$open_date}', is_pre_date = '{$pre_date}', is_now_page = '{$now_page}'
      WHERE is_iidx = {$dt}";
    $re = sql_exec($sql);
    // $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
            
      $item = getItemInfo($dt);
      $iname = $item['i_name'];
      // 로그
      $exec = "상품 \"{$iname}\" 관련 기간 수정";
      $sql = addslashes($sql);
      $res = setAdminLog($aid,$aidx,$sql,$exec);
      // $output['res'] = $res;
      
    }else{
      $output['state'] = "N";
    }
        
    echo json_encode($output);
  break;
  
  case "setDeliNum":
    
    if(empty($num)) $num = 0;
    $sql = "UPDATE st_order SET o_deli_number = {$num} WHERE o_idx = {$oidx}";
    $re = sql_exec($sql);
    
    $output['sql'] = $sql;

    // 로그
    $exec = "주문 idx \"{$oidx}\" 송장번호 수정";
    $sql = addslashes($sql);
    $res = setAdminLog($aid,$aidx,$sql,$exec);
    
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    
    echo json_encode($output);
  break;
  
  case "cancelOrder":
    // 결제 취소처리
    
    /*
      실제 PG사에서 결제 취소처리
    */
    
    // PG사 취소 처리 후 DB 업데이트
    $psql = "UPDATE st_payment SET pm_cancel = 'Y' WHERE pm_idx = {$pmidx}";
    
    // 주문 취소 처리
    $sql = "UPDATE st_order SET o_cancel = 'Y', o_cdate = now() WHERE o_idx = {$oidx}";
    $re = sql_exec($sql);
    
    if($re){
      $output['state'] = "Y";
      $output['sql'] = $sql;

    
      // 로그
      $exec = "주문 idx \"{$oidx}\" 취소처리 - 결제idx : {$pmidx}";
      $sql = addslashes($sql);
      $res = setAdminLog($aid,$aidx,$sql,$exec);


    }else{
      $output['state'] = "N";
    }
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  case "chgAllDeliNum":
    
    // 엑셀파일 임시 업로드 
    $file = $_FILES['allnumber'];
    $ftmp = $file['tmp_name'];
    $name = $file['name'];
    
    $box = explode(".",$name);
    $whak = end($box);
    $upname = time();
    $uppath = "../img/";
    $uname = $upname.".".$whak;
    $efiles = $uppath.$uname;

    $res = move_uploaded_file($ftmp, $efiles);
    $output['res'] = $res;

    
    // 이전 검색한 데이터 주문인덱스 추출
    $where = "WHERE 1 ";
    $join = "as o LEFT OUTER JOIN st_payment as p ON o.o_pmidx = p.pm_idx";
  
    if($type == "mem"){
      $join .= " INNER JOIN st_member as m ON o.o_midx = m.m_idx ";
      $where .= "AND m_name like '%{$sw}%' ";
    }else if($type == "prod"){
      $join .= " INNER JOIN st_item as i ON o.o_iidx = i.i_idx ";
      $where .= "AND i_name like '%{$sw}%' ";
    }else if($type == "num"){
      $where .= "AND o_number like '%{$sw}%' ";
    }else if($type == "odate"){
      $where .= "AND o_odate like '%{$sw}%' ";
    }
    
    // 취소여부 정렬
    if(!$sort_cancel || $sort_cancel == "A"){
      $where .= "";
    }else{
      $where .= "AND o.o_cancel = '{$sort_cancel}' ";
    }
    
    
    $admin = getAdminInfoIdx($admin);
    $admin_idx = $admin['a_idx'];
    $admin_group = $admin['a_group'];
    // 세토웍스인 경우
    if ($admin_group == "SK") {
      $where .= "";
      
    // 메이커인 경우
    }else if($admin_group == "MK"){
      $where .= "AND o.o_aidx = {$admin_idx}";
    }
      
    if($sodate == "A"){
      $sodate_txt = "ORDER BY o_odate ASC";
    }else{
      $sodate_txt = "ORDER BY o_odate DESC";
    }
    
    $osql = "SELECT * FROM st_order {$join} {$where} {$sodate_txt}";
    $re = sql_query($osql);
    
    $arr_oidx = array();
    foreach($re as $v){
      $o_idx = $v['o_idx'];
      array_push($arr_oidx,$o_idx);
    }
    
    $output['sql'] = $arr_oidx;
  
    $output['efiles'] = $efiles;
    // 엑셀데이터 읽기.
    $phpexcel = new PHPExcel();
    
    try{
      
      $Exreader = PHPExcel_IOFactory::createReaderForFile($efiles);
      $Exreader->setReadDataOnly(true);
      $objExcel = $Exreader->load($efiles);
  
      $objExcel->setActiveSheetIndex(0);
      $sheet1 = $objExcel->getActiveSheet();
      $garo = $sheet1->getRowIterator();
  
      foreach($garo as $row){
        $cell = $row->getCellIterator();
        $cell->setIterateOnlyExistingCells(false);
      }
  
      $sero = $sheet1->getHighestRow();
      $output['sero'] = $sero;
      
      for($i=2,$a=0; $i<=$sero; $i++,$a++){
    
          $cancel_txt = $sheet1->getCell('I'.$i)->getValue();
          $deli_num = $sheet1->getCell('K'.$i)->getValue();
          $oidx = $arr_oidx[$a];
          
          if(!$cancel_txt){
            if(empty($deli_num)) $deli_num = 0;
            
            if(!empty($oidx)){
              $sql = "UPDATE st_order SET o_deli_number = {$deli_num} WHERE o_idx = {$oidx}";
              sql_exec($sql);
              $output['sql'.$a] = $sql;
            }
          }
          
    
      }
      
    }catch(exception $e){
      $output['error'] = "엑셀 파일 읽기 에러!";
    }
    
    unlink($efiles);
    $ouput['state'] = "Y";
    
    // 로그
    $exec = "일괄 업로드. 대상 sql과 마지막 실행된 sql";
    $sql_txt = "{$osql}\n{$sql}";
    $sql_txt = addslashes($sql_txt);
    $res = setAdminLog($aid,$aidx,$sql_txt,$exec);
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  case "chkRegData" :
    $col = "a_".$type;
    
    $sql = "SELECT * FROM st_admin WHERE {$col} = '{$val}' AND a_open = 'Y'";
    $re = sql_fetch($sql);
    
    if($re){
      $output['state'] = "N";
    }else{
      $output['state'] = "Y";
    }
    
    $output['sql'] = $sql;
    
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
  break;
  
  case "regAdmin" :
    
    // 서버상 디렉토리를 만들어야하기 때문에 DB 입력을 선행.
    $passwd = password_hash($upw,PASSWORD_DEFAULT);
    if($group == "SK"){
      $dcol = "a_comp = '세토웍스', a_regnum = '1418131588', a_owner = '조충연', a_comptel = '07088498904', a_postcode = 06165,
              a_addr = '서울 강남구 삼성로 554', a_daddr = '예성빌딩 3층', a_site = 'https://setoworks.com', ";
    }else{
      if(!$postcode) $postcode = 0;
      
      $company = addslashes($company);      
      $owner = addslashes($owner);      
      $site = addslashes($site);      
      
      $dcol = "a_comp = '{$company}', a_regnum = '{$reg_number}', a_owner = '{$owner}', a_comptel = '{$comp_tel}', 
              a_postcode = {$postcode}, a_addr = '{$addr}', a_daddr = '{$daddr}', a_site = '{$site}', ";
    }
        
    $manager = addslashes($manager);
    $part = addslashes($part);
    $title = addslashes($title);
    $email = addslashes($email);
    
    if($settop == "Y"){
      $top_col = "a_top = 'Y', ";
    }else{
      $top_col = "a_top = 'N', ";
    }
    
    if($reg_type == "I"){
      $sql = "INSERT INTO st_admin SET a_group = '{$group}', a_id = '{$uid}', a_pw = '{$passwd}', {$dcol}            
              a_name = '{$manager}', a_part = '{$part}', a_title = '{$title}', a_tel = '{$mtel}', a_email = '{$email}', 
              {$top_col} a_rdate = now()
      ";
    }else{
      $sql = "UPDATE st_admin SET 
                {$dcol} a_name = '{$manager}', a_part = '{$part}', a_title = '{$title}', a_tel = '{$mtel}', {$top_col} a_email = '{$email}' 
              WHERE a_idx = {$admin_idx}";      
    }
    $re = sql_exec($sql);
    
    
    if($re){
      // 관리자의 idx 추출
      if($reg_type == "I"){
        $isql = "SELECT * FROM st_admin ORDER BY a_idx DESC LIMIT 0,1";
        $ire = sql_fetch($isql);
        $naidx = $ire['a_idx'];
        $naid = $ire['a_id'];
      }else{
        $naidx = $admin_idx;
        $naid = $uid;
      }
      
      // 디렉토리 이름 확보, 필요한 디렉토리 생성
      $dir = "{$naidx}_{$naid}";
      $up_root = "../img/maker/{$dir}";
      
      mkdir($up_root,0777);
      mkdir($up_root."/brand"); // 기본 brand 디렉토리가 있어야 이후 브랜드부터 상품까지 업로드 가능.
      
      // 로고 이미지 업로드
      $lfile = $_FILES['thumbsnail_img'];
      $lftmp = $lfile['tmp_name'];
      $lname = $lfile['name'];
      
      if($lname){
        $logo_name = "{$company}_logo";
        $fbox = explode(".",$lname);
        $whak = end($fbox);
        
        $upname = $logo_name.".".$whak;
        $up_path = $up_root."/".$upname;
        
        $res = move_uploaded_file($lftmp, $up_path);
        if($res){
          $lusql = "UPDATE st_admin SET a_logo = '{$upname}' WHERE a_idx = {$naidx}";
          $lure = sql_exec($lusql);
        }else{
          $output['error'] = "로고파일 업로드 실패";
        }
      }
      
      // 사업자 등록증 이미지 업로드
      $sfile = $_FILES['thumbsnail2_img'];
      $sftmp = $sfile['tmp_name'];
      $sname = $sfile['name'];
      
      if($sname){
        $reg_name = "{$company}_reg";
        $fbox = explode(".",$sname);
        $whak = end($fbox);
        
        $upname = $reg_name.".".$whak;
        $up_path = $up_root."/".$upname;
        
        $res = move_uploaded_file($sftmp, $up_path);
        if($res){
          $susql = "UPDATE st_admin SET a_regimg = '{$upname}' WHERE a_idx = {$naidx}";
          $sure = sql_exec($susql);
        }else{
          $output['error'] = "사업자 등록증 파일 업로드 실패";
        }
      }
      
      $output['state'] = "Y";
      $output['lusql'] = $lusql;
      $output['susql'] = $lusql;

      // 로그
      $reg_type == "I" ? $reg_txt = "등록" : $reg_txt = "수정";
      $exec = "관리자 계정 {$reg_txt}";
      $sql_txt = "{$sql}\n{$lusql}\n{$susql}";
      $sql_txt = addslashes($sql_txt);
      $res = setAdminLog($aid,$aidx,$sql_txt,$exec);
      
    }else{
      $output['state'] = "N";
    }

    $output['sql'] = $sql;
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  case "delAdmin" :
    $sql = "UPDATE st_admin SET a_open = 'N' WHERE a_idx = {$admin_idx}";
    $re = sql_exec($sql);
    
    if($re){
      $output['state'] = "Y";

      // 로그
      $exec = "관리자 계정 삭제";
      $sql = addslashes($sql);
      $res = setAdminLog($aid,$aidx,$sql_txt,$exec);
    }else{
      $output['state'] = "N";
    }
    $output['sql'] = $sql;
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;
  
  
  
  
  
  
  
  
  
  default:
    $output['error'] = "error!! switch error!!!!";
    echo json_encode($output);

}


?>