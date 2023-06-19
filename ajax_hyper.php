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



  default:
    $output['error'] = "error!! switch error!!!!";

}


?>