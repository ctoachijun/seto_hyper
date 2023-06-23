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

  
  default:
    $output['error'] = "error!! switch error!!!!";
    echo json_encode($output);

}


?>