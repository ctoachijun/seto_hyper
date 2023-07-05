<?
include "./admin_header.php";

if (!$reg_type) $reg_type = "I";
$reg_type == "I" ? $reg_txt = "등록" : $reg_txt = "";
$return_page = "admin_account.php?".$_SERVER['QUERY_STRING'];
$img_path = $img_path2 = $noimg_url;

if ($reg_type == "V") {
  $admin = getAdminInfo($aid);
  var_dump($admin);
    
  $aidx = $admin['a_idx'];
  $group = $admin['a_group'];
  $sels = "checked";
  $selm = "";

  
  if($group == "MK"){
    $comp = $admin['a_comp'];
    $regnum = $admin['a_regnum'];
    $owner = $admin['a_owner'];
    $comptel = $admin['a_comptel'];
    $postcode = $admin['a_postcode'];
    $site = $admin['a_site'];
    $sels = "";
    $selm = "checked";
  }

  $id = $aid;
  $manager = $admin['a_name'];
  $part = $admin['a_part'];
  $title = $admin['a_title'];
  $tel = $admin['a_tel'];
  $email = $admin['a_email'];

} else {
  
}


?>



<script>
  $(function () {

    $(".onlymk").addClass("disp_none");
    // 대표 이미지 세팅
    $('#thumbsimg').css({ "background": "url('<?= $img_path ?>') 50% 50%" });
    $('#thumbsimg').css({ 'background-repeat': 'no-repeat' });
    $('#thumbsimg').css({ 'background-size': 'contain' });
    
    // 대표 이미지 세팅
    $('#thumbsimg2').css({ "background": "url('<?= $img_path2 ?>') 50% 50%" });
    $('#thumbsimg2').css({ 'background-repeat': 'no-repeat' });
    $('#thumbsimg2').css({ 'background-size': 'contain' });

    $(".iupload").click(function () {
      $(".thumbimg").click();
    })
    $(".iupload2").click(function () {
      $(".thumbimg2").click();
    })

    // 그룹에 따른 입력 폼 조절
    $("input[type=radio]").on("click",function(){
      let rval = $("input[type=radio]:checked").val();
      
      if(rval == "SK"){
        $(".onlymk").addClass("disp_none");

      }else{
        $(".onlymk").removeClass("disp_none");
      }
      
      
    })
    


  });


</script>


<div class="container adminDetail">
  <div class="pagetitle">
    <h1>관리자 계정
      <?= $reg_txt ?>
    </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active">관리자 계정
          <?= $reg_txt ?>
        </li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="cont col-lg-12">
    <div class="middle_div card">
      <div class="card-body">
        <h5 class="card-title"></h5>

        <!-- Multi Columns Form -->
        <form class="row g-3" method="post" id="adminForm">
          <input type='hidden' name="pwjud" value="" />
          <input type='hidden' name="lengjud" value="" />
          <input type='hidden' name="emailjud" value="" />
          <input type='hidden' name="return_page" value="<?= $return_page ?>" />
          <input type="hidden" name="reg_type" value="<?= $reg_type ?>" />
          <input type='hidden' name='cur_page' value="<?= $return_cur ?>" />

          
          <div class="col-md-12">
            <div class="reg_row d-flex">
              <div class="col-sm-8">
                <input type="radio" id="comp_sk" name="group" value="SK" <?=$sels?> /><label for="comp_sk">세토억스</label>
                <input type="radio" id="comp_mk" name="group" value="MK" <?=$selm?> /><label for="comp_mk">메이커스</label>
              </div>
            </div>
          </div>

          <div class="col-md-12 onlymk">
            <div class="reg_row d-flex">
              <div class="col-md-2">
                <label for="thumbsimg" class="form-label">로고 이미지</label>
                <div class="thumbsnail" id="thumbsimg">
                  <div class="thumbbtn_div">
                    <a class="btn btn-primary btn-sm iupload" title="대표 이미지 업로드"><i class="bi bi-upload"></i></a>
                    <input type="file" name="thumbsnail_img" class="thumbimg" onchange="setThumbnail(event,'thumbsimg')" accept="image/gif, image/jpeg, image/png"/>
                  </div>
                </div>
              </div>
              <div class="col-sm-4"></div>
              <div class="col-md-2">
                <label for="thumbsimg2" class="form-label">사업자 등록증</label>
                <div class="thumbsnail" id="thumbsimg2">
                  <div class="thumbbtn_div">
                    <a class="btn btn-primary btn-sm iupload2" title="대표 이미지 업로드"><i class="bi bi-upload"></i></a>
                    <input type="file" name="thumbsnail2_img" class="thumbimg2" onchange="setThumbnail(event,'thumbsimg2')" accept="image/gif, image/jpeg, image/png"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 onlymk">
            <div class="reg_row d-flex">
              <div class="col-sm-5">
                <label for="pname" class="form-label">회사명</label><span class="pil">*</span>
                <input type="text" class="form-control" id="company" name="company" onchange="chkSpaceFe(this);"
                value="<??>">
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-5">
                <label for="pname" class="form-label">사업자 등록 번호</label><span class="pil">*</span><span class='error error_regnum'></span>
                <input type="text" class="form-control" id="reg_number" name="reg_number" oninput="maxLengthCheck(this); onlyNum(this)" onchange="chkSpaceFe(this); chkRegData(this,1)" maxlength="10"
                value="<?= $item_name ?>" placeholder="- 빼고 입력">
              </div>
            </div>
          </div>
          <div class="col-md-12 onlymk">
            <div class="reg_row d-flex">
              <div class="col-sm-5">
                <label for="pname" class="form-label">대표명</label><span class="pil">*</span>
                <input type="text" class="form-control" id="owner" name="owner" onchange="chkSpaceFe(this);"
                  value="<??>">
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-5">
                <label for="pname" class="form-label">회사 전화번호</label>
                <input type="number" class="form-control" id="comp_tel" name="comp_tel" oninput="maxLengthCheck(this)" onchange="chkSpaceFe(this);" maxlength="13"
                  value="<?= $item_name ?>" placeholder="- 빼고 입력">
              </div>
            </div>
          </div>          

          <div class="col-md-12 onlymk">
            <div class="reg_row d-flex">
              <div class="col-sm-5">
                <label for="" class="form-label">주소</label>
                <input type='button' value='주소검색' onclick='openPost()' />
                <div class='d-flex addr_div'>
                  <input type='text' class='form-control' name="postcode" readonly />
                  <input type='text' class='form-control' name="addr" readonly />
                </div>
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-5">
                <label for="pname" class="form-label">상세주소</label>
                <input type="text" class="form-control" id="daddr" name="daddr" onchange="chkSpaceFe(this)"
                  value="<?= $item_name ?>">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="reg_row d-flex">
              <div class="col-sm-5">
                <label for="pname" class="form-label">담당자</label><span class="pil">*</span>
                <input type="text" class="form-control" id="manager" name="manager" onchange="chkSpaceFe(this)"
                  value="<?= $manager ?>">
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-5">
                <label for="pname" class="form-label">부서 / 직함</label>
                <div class="d-flex position_div">
                  <input type="text" class="form-control" id="part" name="part" onchange="chkSpaceFe(this)" placeholder="부서" value="<?=$part?>">
                  <input type="text" class="form-control" id="title" name="title" onchange="chkSpaceFe(this)" placeholder="직함" value="<?=$title?>">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="reg_row d-flex">
              <div class="col-sm-5">
                <label for="pname" class="form-label">담당자 연락처</label><span class="pil">*</span>
                <input type="text" class="form-control" id="mtel" name="mtel" oninput="onlyNum(this)" onchange="chkSpaceFe(this)" placeholder="- 빼고 입력"
                  value="<?=$tel?>">
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-5">
                <label for="pname" class="form-label">담당자 이메일</label><span class="pil">*</span><span class='error error_email'></span>
                <input type="text" class="form-control" id="email" name="email" oninput="" onchange="chkSpaceFe(this); chkEmail(this)"
                  value="<?= $email ?>">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="reg_row d-flex onlymk">
              <div class="col-sm-5">
                <label for="pname" class="form-label">회사 홈페이지</label>
                <input type="text" class="form-control" id="site" name="site" onchange="chkSpaceFe(this)"
                  value="<?= $site ?>">
              </div>
              <div class="col-sm-1"></div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="reg_row d-flex">
              <div class="col-sm-5">
                <label for="pname" class="form-label">ID</label><span class="pil">*</span><span class='error error_id'></span>
                <input type="text" class="form-control" id="uid" name="uid" oninput="chkEnNum(this); chkLength(1,this)" onchange="chkSpaceFe(this); chkRegData(this,2)"
                  value="<?= $id ?>" disabled>
              </div>
              <div class="col-sm-1"></div>
            </div>
          </div>
          
          <? if($reg_type == "I") : ?>
          <div class="col-md-12">
            <div class="reg_row d-flex">
              <div class="col-sm-5">
                <label for="pname" class="form-label">비밀번호</label><span class="pil">*</span><span class='error error_pw'></span>
                <input type="password" class="form-control" id="upw" name="upw" oninput="chkRegPw()" onchange="chkSpaceFe(this);chkLength(2,this);"
                  value="<?= $item_name ?>">
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-5">
                <label for="pname" class="form-label">비밀번호 확인</label><span class="pil">*</span>
                <input type="password" class="form-control" id="upw2" name="upw2" oninput="chkRegPw();" onchange="chkSpaceFe(this);chkLength(2,this);"
                  value="<?= $item_name ?>">
              </div>
            </div>
            <? endif; ?>
          </div>          




          <div class="text-center regbtn_div">
            <button type="button" class="btn btn-primary" onclick="regAdmin()">등록</button>
            <? if ($reg_type == "E"): ?>
              <button type="button" class="btn btn-danger" onclick="delItem(<?= $iidx ?>)">삭제</button>
            <? endif; ?>
            <button type="button" class="btn btn-secondary" onclick="cancelReturn()">취소</button>
          </div>
        </form><!-- End Multi Columns Form -->

      </div> <!-- end of card-body -->
    </div> <!-- end of middle_div -->

  </div>
</div>

<?
include "./admin_footer.php";
?>