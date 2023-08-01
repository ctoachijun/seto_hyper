<?
include "./lib/hyper.php";

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
      } else {
        $output['state'] = "N";
      }
    }
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
  break;
  
  case "regMooni" :
    
    // 첨부파일 기본 세팅
    $attach1 = $_FILES['attach1'];
    $attach2 = $_FILES['attach2'];
    
    $att1_name = $attach1['name'];
    $att1_tmp = $attach1['tmp_name'];
    $att2_name = $attach2['name'];
    $att2_tmp = $attach2['tmp_name'];
    
    $path = "./img/mooni/";
    $nows = time();
    
    // 파일 있으면 업로드
    if(!empty($att1_name)){
      // $file_name1 = getFilename($att1_name,$path);  // 파일이름 중복 확인
      $box = explode(".",$att1_name);
      $whak = end($box);
      $file_name1 = "{$memberid}{$nows}_1.{$whak}";
      $res = move_uploaded_file($att1_tmp, $path.$file_name1);  // 업로드
      $output['j1'] = "첨부파일1 있음";
      $output['res1'] = $res;
      $output['f1'] = $file_name1;
      $output['path'] = $path;
    }
    if(!empty($att2_name)){
      $box = explode(".",$att2_name);
      $whak = end($box);
      $file_name2 = "{$memberid}{$nows}_2.{$whak}";

      // $file_name2 = getFilename($att2_name,$path);
      $res = move_uploaded_file($att2_tmp, $path.$file_name2);
    }
    
    $subject = addslashes($subject);
    $cont = addslashes($cont);
    $attachs = $file_name1."|".$file_name2;
    if(!isset($productid)) $productid = 0;
    
    $sql = "INSERT INTO st_mooni SET mn_midx = {$memberid}, mn_iidx = {$productid}, mn_mncidx = {$moontype}, mn_subject = '{$subject}', mn_cont = '{$cont}', mn_attach = '{$attachs}', mn_mdate = now()";    
    $re = sql_exec($sql);
    
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state']= "N";
    }
    
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;



  default:
    $output['error'] = "error!! switch error!!!!";

}


?>