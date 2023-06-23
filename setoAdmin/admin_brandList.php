<?
include "./admin_header.php";



if(!$maker_idx){
  // 메이커가 아닌경우 메이커 선택 가능하게 함
  if($admin_group != "MK"){
    $maker_idx = "ALL";  
  }else{
    $maker_idx = $admin_idx;  
  }
}

// 메이커 셀렉트 생성
$maker_select = getMakerSelect($maker_idx);


// 해당 메이커의 브랜드 데이터를 추출
$brand = getBrandList($maker_idx,$sw);


// 총 건수
$total_cnt = count($brand);



?>

<script>
  // $(document).ready(function(){
  //   $('.clogo').css({"background": "url('<?=$logo_path?>') 50% 50%"});
  //   $('.clogo').css({'background-repeat': 'no-repeat'});
  //   $('.clogo').css({'background-size': 'contain'});

  //   $('#clogo').on('change', preview_fpic);
  // });  
  function clickFile(){
    $("#logo_file").click();
  }
</script>


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
<?      elseif($admin_group == "MK") : ?>
          <input type="button" class="btn btn-outline-success regBtn" value="등록" onclick="showRegPopup()"/>
<?      endif; ?>          
        </div>
      </div>
    </div> <!-- end of top_div -->

    <div class="middle_div d-flex justify-content-center">

      <div class="mcont card-body">
<?      
        if($brand) :
          foreach($brand as $bv) : 
            $logo = $bv['b_logo'];
            $bname = $bv['b_name'];
            $bidx = $bv['b_idx'];
            $bdesc = mb_strimwidth($bv['b_intro'],0,90,"...","utf-8");
            if(empty($logo)){
              $logo_img = $noimg;
            }else{
              $img_path = chkBrandDir($bname);
              $logo_img = "<img src='{$img_path}/{$logo}'>";
            }
?>
              <div class="wrap_box" onclick="goBrandDetail(<?=$bidx?>)">
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

    <div class="regpop">
      <form method="post" id="regForm">
        <div class="pop_title"><h6><b>브랜드 등록</b></h6><i class="bi bi-x-lg cpointer" onclick="closeModal('regpop')"></i></div>
        <div class="pop_input1 d-flex align-items-end justify-content-between">
          <div id="regimg" class="regimg d-flex justify-content-center align-items-center cpointer" onclick="clickFile()";>
            로고<br>클릭 후 등록
          </div>
          <input type="file" id="logo_file" name="logo" onchange="setThumbnail(event,'regimg');" />
          <input type="text" class="form-control" id="bname" name="bname" placeholder="브랜드명을 입력 해 주세요." onchange="chkSpaceFe(this);chkBrandName(this)"/>
        </div>
        <div class="pop_input2">
          <textarea id="bdesc" name="bdesc" class="form-control" placeholder="간단소개를 입력 해 주세요." maxlength="250" onchange="chkSpaceFe(this);"></textarea>
        </div>
        <div class="pop_btn d-flex justify-content-end">
          <input type="button" class="btn btn-primary" value="등록" onclick="regBrand()" />
        </div>
      </form>
    </div>
    
    
    
  </div>
</div>

<?
include "./admin_footer.php";
?>