<?
include "./admin_header.php";


// 문의 관련 내용
$mooni = getMooniInfo($moonidx);
$tclass = $mooni['mnc_class'];
$subject = $mooni['mn_subject'];
$cont = preg_replace("/\n/","<br>",$mooni['mn_cont']);
$mdate = $mooni['mn_mdate'];
$tcname = $mooni['mnc_name'];
$tclass == "S" ? $tclass_txt = "사이트" : $tclass_txt = "상품";
$aidx = $mooni['mn_aidx'];
$adate = $mooni['mn_adate'];
$acont = $mooni['mn_answer'];

if(empty($aidx)){
  $answer = "<span class='noans'>미답변</span>";
  $aidx = $admin_idx;
}else{
  $answer = "<span class='yans'>답변 완료</span>";
  $readonly = "readonly";
} 


// 첨부파일 세팅
$fbox = explode("|",$mooni['mn_attach']);
$path = "../img/mooni/";
$f1 = $fbox[0];
$f2 = $fbox[1];
if(!empty($f1)){
  $f1_link = "<a href='{$path}{$f1}' target='_blank'>{$f1}</a>";
}
if(!empty($f2)){
  $f2_link = "<a href='{$path}{$f2}' target='_blank'>{$f2}</a>";
}


// 작성자 정보
$midx = $mooni['mn_midx'];
$mem = getMemberInfo($midx);
$mem_name = $mem['m_name'];
$mem_id = $mem['m_id'];

// 상품문의인 경우에는 상품명.
$iidx = $mooni['mn_iidx'];
$item = getItemInfo($iidx);
$item_name = $item['i_name'];

// 답변자 데이터
// 답변자가 없으면 현재 로그인 되어있는 계정의 이름으로, 답변자가 있으면 해당 계정의 이름
$admin = getAdminInfoIdx($aidx);
$ans_name = $admin['a_name'];


?>

<div class="container moonidetail">
   <div class="pagetitle">
      <h1>문의 상세</h1>
      <nav>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="main.php">Home</a></li>
            <li class="breadcrumb-item">문의 관리</li>
            <li class="breadcrumb-item active">문의 상세</li>
         </ol>
        </nav>
      </div><!-- End Page Title -->
      
      <div class="cont col-lg-12">
        <div class="middle_div card">
          <input type="hidden" name="answeridx" value="<?=$aidx?>">
          <input type="hidden" name="moonidx" value="<?=$moonidx?>">
          <div class="card-body">
            <h5 class="card-title">문의 상세 내역</h5>
            
                <section class="box">
                  <div class="box_row"><h4>문의 정보</h4></div>
                  <div class="box_row d-flex">
                    <div class="row_cont">
                      <div>분류</div><div><?=$tclass_txt?> - <?=$tcname?></div>
                    </div>
                    <div class="row_cont">
                      <div>작성자</div><div><?=$mem_name?> (<?=$mem_id?>)</div>
                    </div>
                  </div>
                  <div class="box_row d-flex">
                    <div class="row_cont">
                      <div>작성일</div><div><?=$mdate?></div>
                    </div>
                    <div class="row_cont">
                      <div>답변여부</div><div><?=$answer?></div>
                    </div>
                  </div>
                </section>
                <section class="box">
                  <div class="box_row"><h4>문의 내용</h4></div>
                  <div class="box_row d-flex">
                    <div class="row_cont">
                      <div>제목</div><div class="subject"><?=$subject?></div>
                    </div>
                  </div>
                  <div class="box_row d-flex">
                    <div class="row_cont cont">
                      <div>내용</div><div><?=$cont?></div>
                    </div>
                  </div>
                  <? if($tclass=="S" && (!empty($f1_link) || !empty($f2_link))) : ?>
                  <div class="box_row d-flex">
                    <div class="row_cont">
                      <div>첨부파일</div><div><?=$f1_link?><?=$f2_link?></div>
                    </div>
                  </div>
                  <? endif; ?>
                </section>

                <section class="box">
                  <div class="box_row"><h4>답변</h4></div>
                  <div class="box_row d-flex">
                    <div class="row_cont">
                      <div>담당자</div><div><?=$ans_name?> <span>('담당자' 라고 표시됨)</span></div>
                    </div>
                    <div class="row_cont">
                      <div>답변일</div><div><?=$adate?></div>
                    </div>
                  </div>
                  <div class="box_row d-flex">
                    <div class="row_cont">
                      <div>답변</div><div><textarea id="cont" class='form-control mooni_answer' onchange="chkSpaceFe(this)" <?=$readonly?>><?=$acont?></textarea></div>
                    </div>
                  </div>
                </section>
                <div class="box_row d-flex">
                  <div class="btn_div d-flex justify-content-end">
                    <? if($readonly != "readonly"): ?>
                    <div><input type="button" class="btn btn-primary" value="등록"/></div>
                    <? endif; ?>
                    <div><input type="button" class="btn btn-secondary" value="취소" /></div>
                  </div>
                </div>
                
         </div>   <!-- end of card-body -->
      </div>   <!-- end of middle_div -->
      
   </div>
</div>

<?
include "./admin_footer.php";
?>

<script>
  $(".btn-primary").on("click",regMoonAns);
  $(".btn-secondary").on("click",function(){
    history.go(-1);
  });
</script>