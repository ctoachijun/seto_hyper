<?
include "./admin_header.php";


// 메이커가 아닌경우 메이커 선택 가능하게 함
if($admin_group != "MK"){
  // 메이커 셀렉트 생성
  $maker_select = getMakerSelect($maker_idx);

  $maker_idx = "ALL";  
}else{
  $maker_idx = $admin_idx;  
}

// 해당 메이커의 브랜드 데이터를 추출
$brand = getBrandList($maker_idx,$sw);


// 총 건수
$total_cnt = count($brand);

$noimg = "<img src='/img/no_img2.jpg' />";
?>


<div class="container brandlist">
  <div class="pagetitle">
    <h1>브랜드 목록</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active">브랜드 목록</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="cont col-lg-12 card">
    <div class="top_div card-body">
      <h5 class="card-title">브랜드</h5>
      <div class="search_div d-flex">
        <div class="total_count d-flex align-items-end">총 <?=$total_cnt?>건</div>
        <div class="mselect_div d-flex">
<?      if($admin_group != "MK") : ?>        
          <?=$maker_select?>
          <input type="text" class="form-control" name="sw" value="<?=$sw?>" placeholder="브랜드 이름을 검색 해 주세요."/>
          <input type="button" class="btn btn-outline-primary swBtn" value="검색" onclick="searchBrand()" />
<?      endif; ?>        
          <input type="button" class="btn btn-outline-success regBtn" value="등록" />
        </div>
      </div>
    </div> <!-- end of top_div -->

    <div class="middle_div d-flex justify-content-center">

      <div class="mcont card-body">
<?      
        if($brand) :
          foreach($brand as $bv) : 
            $logo_img = $bv['b_logo'];
            $bname = $bv['b_name'];
            $bdesc = $bv['b_intro'];
            if(empty($logo_img)) $logo_img = $noimg;
?>
              <div class="wrap_box">
                  <div class="brand_box d-flex flex-column align-items-center cpointer">
                    <div class="brand_logo"><?=$logo_img?></div>
                    <div class="brand_name"><?=$bname?></div>
                    <div class="brand_desc"><?=$bdesc?></div>
                  </div>
              </div>
<?        endforeach; 
        else :
?>
          <div class="nosearch">검색 결과가 없습니다. </div>
<?      endif; ?>            
      </div>
            
    </div>      

  </div>
</div>

<?
include "./admin_footer.php";
?>