<?
include "./admin_header.php";

$admin = getAdminInfo($admin_id);
// var_dump($admin);

    
$group = $admin['a_group'];
$aid = $admin['a_id'];
$aidx = $admin['a_idx'];
$comp = $admin['a_comp'];
$logo = $admin['a_logo'];
$manager = $admin['a_name'];
$part = $admin['a_part'];
$title = $admin['a_title'];
$tel = $admin['a_tel'];
$site = $admin['a_site'];
$email = $admin['a_email'];

if($group == "SK"){
  $logo = "../img/seto_emb.png";
}else{
  $logo = "../img/maker/{$aidx}_{$aid}/{$logo}";
}




?>

<script>
  $(function () {

    // 대표 이미지 세팅
    $('#thumbsimg').css({ "background": "url('<?= $logo ?>') 50% 50%" });
    $('#thumbsimg').css({ 'background-repeat': 'no-repeat' });
    $('#thumbsimg').css({ 'background-size': 'contain' });
    
    $(".iupload").click(function () {
      $(".thumbimg").click();
    })

  });
</script>



<div class="container adminProfile">
    <div class="pagetitle">
      <h1>프로필</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">프로필</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="<?=$logo?>" alt="Profile" class="rounded-circle">
              <h2><?=$admin_id?></h2>
              <h3><?=$so?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">정보 수정</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">비밀번호 변경</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade profile-edit pt-3 show active" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="<?=$PHPSELF?>" method="POST" id="profile">
                    <input type='hidden' name='emailjud' />
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">로고</label>
                      <div class="col-md-2 col-lg-3">
                       
                        <div class="thumbsnail" id="thumbsimg">
                          <div class="thumbbtn_div">
                            <a class="btn btn-primary btn-sm iupload" title="대표 이미지 업로드"><i class="bi bi-upload"></i></a>
                            <input type="file" name="thumbsnail_img" class="thumbimg" onchange="setThumbnail(event,'thumbsimg')" accept="image/gif, image/jpeg, image/png"/>
                          </div>
                        </div>
                        
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">담당자<span class="pil">*</span></label>
                      <div class="col-md-8 col-lg-9">
                        <input name="manager" type="text" class="form-control" id="manager" onchange="chkSpaceFe(this)" value="<?=$manager?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">부서</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="part" type="text" class="form-control" id="part" onchange="chkSpaceFe(this)" value="<?=$part?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">직함</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="title" type="text" class="form-control" id="title" onchange="chkSpaceFe(this)" value="<?=$title?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">연락처<span class="pil">*</span></label>
                      <div class="col-md-8 col-lg-9">
                        <input name="tel" type="text" class="form-control" id="tel" oninput="maxLengthCheck(this); onlyNum(this)" onchange="chkSpaceFe(this)" value="<?=$tel?>" maxlength="13">
                      </div>
                    </div>

                    <div class="row mb-3">
                    <span class='error'></span>
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">이메일<span class="pil">*</span></label>
                      <div class="col-md-8 col-lg-9">
                        <span class='error error_email'></span>
                        <input name="email" type="text" class="form-control" id="email" oninput="chkEmail(this)" onchange="chkSpaceFe(this)" value="<?=$email?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">회사 홈페이지</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="site" type="text" class="form-control" id="site" onchange="chkSpaceFe(this)" value="<?=$site?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <input type="button" class="btn btn-primary savebtn" value="저장" onclick="saveProfile(<?=$aidx?>)">
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form id='pwForm'>
                    <input type='hidden' name='lengjud' />
                    <input type='hidden' name='pwjud' />

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">현재 비밀번호</label>
                      <div class="col-md-8 col-lg-9">
                        <span class='error error_pw'></span>
                        <input name="password" type="password" class="form-control" id="currentPassword" onchange="chkSpaceFe(this);chkCurPw(this,<?=$aidx?>);">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">새 비밀번호</label>
                      <div class="col-md-8 col-lg-9">
                        <span class='error error_npw'></span>
                        <input name="newpassword" type="password" class="form-control" id="newPassword" oninput="chkPwLength(1,this);" onchange="chkSpaceFe(this);" >
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">새 비밀번호 확인</label>
                      <div class="col-md-8 col-lg-9">
                        <span class='error error_rnpw'></span>
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" oninput="chkPwLength(2,this);" onchange="chkSpaceFe(this);" >
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="button" class="btn btn-primary" onclick="chgPw(<?=$aidx?>)">비밀번호 변경</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>
    
    
</div>
<?
include "./admin_footer.php";
?>