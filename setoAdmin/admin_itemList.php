<?
include "./admin_header.php";


// for($i=1; $i<33; $i++){
//   $tname = "testItem{$i}";
//   $parr = array("500","1800","3500","9000","18900","21300","59000","7300","91000");
//   $price = $parr[array_rand($parr)];
//   $qarr = array("300","500","800","1000","1500","2000","9999");
//   $quan = $qarr[array_rand($qarr)];
//   $darr = array("2500","3000","3500","5000","0");
//   $dval = $darr[array_rand($darr)];
  
//   $sql = "INSERT INTO st_item SET i_bidx = 2, i_name = '{$tname}', i_delival = {$dval}, i_quantity = {$quan}, i_price = {$price}";
  
//   // echo "$sql <br>";
//   // sql_exec($sql);
  
// }



// 브랜드 정보 세팅
$brand = getBrandInfo($bidx);
$bname = $brand['b_name'];
$blogo = $brand['b_logo'];
$bdesc = $brand['b_intro'];

if($agroup != "MK"){
  $abox = explode("|",brandnameToAdmin($bname));
  $aidx = $abox[0];
  $aid = $abox[1];
}else{
  $aidx = $admin_idx;
  $aid = $admin_id;
}

$img_path = chkBrandDir($bname);
if(!$blogo){
  $logo = "/img/no_img2.jpg";
}else{
  $logo = $img_path."/".$blogo;
}
// var_dump($logo);


// 상품 정보 추출
$item_box = getBrandItem($bidx);

?>

<script>
  // 브랜드 로고 세팅
  $(document).ready(function(){
    $('.blogo').css({"background": "url('<?=$logo?>') 50% 50%"});
    $('.blogo').css({'background-repeat': 'no-repeat'});
    $('.blogo').css({'background-size': 'contain'});

  });  
  function clickFile(){
    $("#logo_file").click();
  }
</script>


<div class="container branddetail">
  <div class="pagetitle">
    <h1>브랜드 상세</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active">브랜드 상세</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  
  <div class="cont col-lg-12 card">
    <div class="top_div card-body">
      <h5 class="card-title">상세</h5>
      <div class="brand_div">
        <form method="post" id="brandForm">
          <input type="hidden" name="org_logo" value="<?=$blogo?>" />
          <input type="hidden" name="org_bname" value="<?=$bname?>" />
          <input type="hidden" name="brand_index" value="<?=$bidx?>" />
          <input type="file" id="logo_file" name="logo" onchange="setThumbnail(event,'blogo');" />
          <div class="brand1 d-flex align-items-end justify-content-start">
            <div id="blogo" class="blogo d-flex justify-content-center align-items-center cpointer" onclick="clickFile()";>
              <!-- <img src="<?=$logo?>" /> -->
            </div>
            <div class="binfo d-flex flex-column">
              <span class='brand_title'><?=$bname?></span>
              <input type="text" class="form-control" id="bname" name="bname" placeholder="브랜드명을 입력 해 주세요." value="<?=$bname?>" onchange="chkSpaceFe(this);chkBrandNameEdit(this,'<?=$bname?>')"/>
            </div>
          </div>
          <div class="brand2 d-flex">
            <div class="brand2_textarea">
              <textarea id="bdesc" name="bdesc" class="form-control" placeholder="간단소개를 입력 해 주세요." maxlength="250" onchange="chkSpaceFe(this);"><?=$bdesc?></textarea>
            </div>
            <div class="brand_btn d-flex justify-content-start">
              <input type="button" class="btn btn-outline-primary" value="수정" onclick="editBrand()" />
            </div>
          </div>
        </form>
      </div>
      
    </div> <!-- end of top_div -->

    <div class="middle_div d-flex flex-column justify-content-start">
      <div class="msearch_div card-body d-flex justify-content-between ">

        <div class="msearch d-flex align-items-center">
          <input type="text" class="form-control sw" name="sw" value="<?=$sw?>" />
          <input type="button" class="btn btn-primary" value="검색" />
        </div>
        <div class="regbtn"><input type="button" class="btn btn-success" value="상품 등록" onclick=""></div>
      </div>
      
      <div class="mtable_div card-body">
        <table class="table table-hover mtable">
          <thead>
            <tr>
              <th>썸네일</th>
              <th>상품명</th>
              <th>수량</th>
              <th>최소수량</th>
              <th>가격</th>
              <th>배송비</th>
              <th>배송업체</th>
              <th>배송예정일</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
<?
          foreach($item_box as $v) :
            $imgname = $v['i_img'];
            empty($imgname) ? $item_img = $noimg : $item_img = "<img src='{$img_path}/{$imgname}' />";
            
?>            
            <tr>
              <td><?=$item_img?></td>
              <td><?=$v['i_name']?></td>
              <td><?=number_format($v['i_quantity'])?></td>
              <td><?=number_format($v['i_moq'])?></td>
              <td><?=number_format($v['i_price'])?></td>
              <td><?=number_format($v['i_delival'])?></td>
              <td><?=$v['i_delicomp']?></td>
              <td><?=$v['i_deliday']?></td>
              <td>상세</td>
            </tr>
<?
          endforeach;
?>

<?
?>
          </tbody>
        </table>
        
      </div>
      <div class="mpaging_div card-body"></div>

          
          
      <!-- <div class="nosearch">검색 결과가 없습니다. </div> -->


            
    </div>      
    
    
  </div>
</div>

<?
include "./admin_footer.php";
?>