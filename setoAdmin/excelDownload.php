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
  
}else if($code == 2){
  $fname = "주문 리스트";
  
  
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
  
  $sql = "SELECT * FROM st_order {$join} {$where} {$sodate_txt}";
  $re = sql_query($sql);
  // echo $sql;

  
  $phpExcel = new PHPExcel();
  $phpExcel->setActiveSheetIndex(0);
  $phpExcel->getActiveSheet()
  ->setCellValue("A1","주문번호")
  ->setCellValue("B1","구매자")
  ->setCellValue("C1","브랜드")
  ->setCellValue("D1","상품")
  ->setCellValue("E1","주문개수")
  ->setCellValue("F1","주문금액")
  ->setCellValue("G1","주문수단")
  ->setCellValue("H1","주문일시")
  ->setCellValue("I1","취소여부")
  ->setCellValue("J1","택배사")
  ->setCellValue("K1","송장번호");
  
  $num = 2;
  $cnt = 1;
  foreach($re as $v){
    
    $iidx = $v['o_iidx'];
    $item_box = getItemInfo($iidx);
    $brand_box = getBrandInfo($item_box['i_bidx']);
    $brand_name = $brand_box['b_name'];
    $item_name = $item_box['i_name'];
    $oidx = $v['o_idx'];
    $order_number = $v['o_number'];
    $member = getMemberInfo($v['o_midx']);
    $order_name = $member['m_name'];
    $order_quan = number_format($v['o_quan']);
    $order_price = number_format($v['pm_amount']);
    $order_date = $v['o_odate'];
    $ptype = $v['pm_type'];
    
    if($ptype == "C"){
      $payment = "카드";
    }else if($ptype == "P"){
      $payment = "간편결제";
    }else if($ptype == "B"){
      $payment = "계좌이체";
    }else if($ptype == "H"){
      $payment = "핸드폰";
    }
    
    if($ptype != "C" && $ptype != "H"){
      $pdetail = $v['pm_detail'];
      $payment .= "<br>(".$v['pm_detail'].")";
    }
    
    $order_cancel = $v['o_cancel'];
    if($order_cancel == "Y"){
      $cancel = "취소";
      $rol = "disabled";
      $cclass = "cancel_tr";
      $onclk = "";
    }else{
      $cancel = "";
      $rol = "";
      $cclass = "";
      $onclk = "onclick='setDeliNum({$oidx})'";
    }
    
    $delivery = $item_box['i_delicomp'];
    $deli_number = $v['o_deli_number'];
    
    $phpExcel->setActiveSheetIndex(0)
    ->setCellValue("A".$num, $order_number)
    ->setCellValue("B".$num, $order_name)
    ->setCellValue("C".$num, $brand_name)
    ->setCellValue("D".$num, $item_name)
    ->setCellValue("E".$num, $order_quan)
    ->setCellValue("F".$num, $order_price)
    ->setCellValue("G".$num, $payment)
    ->setCellValue("H".$num, $order_date)
    ->setCellValue("I".$num, $cancel)
    ->setCellValue("J".$num, $delivery)
    // ->setCellValue("K".$num, $deli_number,PHPExcel_Cell_DataType::TYPE_STRING);
    ->setCellValueExplicit('K'.$num, $deli_number, PHPExcel_Cell_DataType::TYPE_STRING);
    $num++;
    $cnt++;
    // echo "num : $num<br>";
    
  }
  
}
  
  
  $fname = iconv("UTF-8","EUC-KR",$fname);
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename='.$fname.'.xlsx');
  header('Cache-Control: max-age=0');

  $ww = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
  ob_end_clean();
  $ww->save('php://output');
  exit;

  


?>