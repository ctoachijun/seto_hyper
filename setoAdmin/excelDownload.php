<?
include "../lib/hyper.php";
include "../lib/PHPExcel/Classes/PHPExcel.php";

// code = 1 : 구독 메일 화면
if($code == 1){
  $fname = "구독 메일 리스트";
  
  if($type == "p"){
    $where = "as ss INNER JOIN st_item as si ON ss.s_iidx = si.i_idx ".$where;
    $where .= "AND si.i_name like '%{$sw}%'";
  }else if($type == "b"){
  
    $where = "as ss INNER JOIN st_item as si ON ss.s_iidx = si.i_idx INNER JOIN st_brand as sb ON si.i_bidx = sb.b_idx ".$where;
    $where .= "AND sb.b_name like '%{$sw}%'";
    
  }else if($type == "d"){
    $where .= "AND s_wdate like '%{$sw}%'";
  }

  $sql = "SELECT * FROM st_smail {$where} ORDER BY s_wdate";
  
  // echo "<br>";
  // echo $sql;
  
  $re = sql_query($sql);
  
  
  $phpExcel = new PHPExcel();
  $phpExcel->setActiveSheetIndex(0);
  $phpExcel->getActiveSheet()
  ->setCellValue("A1","번호")
  ->setCellValue("B1","브랜드")
  ->setCellValue("C1","상품")
  ->setCellValue("D1","이메일")
  ->setCellValue("E1","발송 일시");

  $num = 2;
  $cnt = 1;
  foreach($re as $v){

    if($type == "p"){
      $brand_box = getBrandInfo($v['i_bidx']);
      $brand_name = $brand_box['b_name'];
      $item_name = $v['i_name'];
    }else if($type == "b"){
      $brand_name = $v['b_name'];
      $item_name = $v['i_name'];
    }else{
      $item_box = getItemInfo($v['s_iidx']);
      $brand_box = getBrandInfo($item_box['i_bidx']);
      $brand_name = $brand_box['b_name'];
      $item_name = $item_box['i_name'];
    }
    


    $phpExcel->setActiveSheetIndex(0)
      ->setCellValue("A".$num, $cnt)
      ->setCellValue("B".$num, $brand_name)
      ->setCellValue("C".$num, $item_name)
      ->setCellValue("D".$num, $v['s_email'])
      ->setCellValue("E".$num, $v['s_wdate']);
    $num++;
    $cnt++;
  }
  
  
  // $fname = iconv("UTF-8","EUC-KR",$fname);
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename='.$fname.'.xlsx');
  header('Cache-Control: max-age=0');

  $ww = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
  ob_end_clean();
  $ww->save('php://output');
  exit;

  
}


?>