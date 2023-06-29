<?
include "./admin_header.php";

if (!$reg_type)
   $reg_type = "I";
$reg_type == "I" ? $type_name = "등록" : $type_name = "수정";

$bidx = $brand_index;


// 배송회사 셀렉트 만들기위한 데이터
$deli_arr = getDeliveryCompany();

// 키워드 html 
$key_html = setKeywordHtml($keyword);

$return_page = "admin_itemList.php?".$_SERVER['QUERY_STRING'];

?>

<script>
   $(function () {
      
      // 기본값 세팅
      $("#now1").css("background","#198754");
      $(".btn-now1").css("color","#fff");
      
      
      // 대표 이미지 세팅
      $('.thumbsnail').css({"background": "url('<?=$noimg_url?>') 50% 50%"});
      $('.thumbsnail').css({'background-repeat': 'no-repeat'});
      $('.thumbsnail').css({'background-size': 'contain'});
      
      $(".iupload").click(function(){
         $(".thumbimg").click();
      })
      
      $(".idelete").click(function(){
         $('.thumbsnail').css({"background": "url('<?=$noimg_url?>') 50% 50%"});
         $('.thumbsnail').css({'background-repeat': 'no-repeat'});
         $('.thumbsnail').css({'background-size': 'contain'});
         $(".thumbimg").val("");
      })
      
      // 호버시 아이콘 색상 정상작동 되도록 처리
      $(".btn-outline-success").hover(function () {
         $(".nocheck").css("color", "#fff");
      }, function () {

         for(let i=1; i<4; i++){
            if( $("#writeNow"+i).attr("checked") ){
               $("#now"+i).css("background","#198754");
               $(".btn-now"+i).css("color","#fff");
            }else{
               $("#now"+i).css("background","");
               $(".btn-now"+i).css("color","#198754");
            }
         }         
      });

      // 즉시적용 라디오버튼 처리
      $(".btn-outline-success").click(function () {
         let btnid = this.id;
         let radid = ciid = btnid = "";
         
         for(let i=1; i<=3; i++){
            
            // 버튼과 라디오버튼 선택자 세팅
            radid = "writeNow"+i;
            ciid = "cicon"+i;
            btnid = "now"+i;
            
            // 탭 옆의 아이콘 초기화
            $("."+ciid).hide(); 
            
            // 클릭한 버튼의 id와 일치할때
            if(btnid == this.id){
               
               // 체크 되어있으면 해제, 색상도 초기화.
               if( $("#"+radid).attr("checked") ){
                  $("#"+radid).attr("checked",false);
                  $("#"+btnid).css("background","");
                  $("#"+btnid).css("color","#198754");
                  $("."+ciid).hide();
               }else{
                  // 체크 되어있지않으면 체크 후 색상 세팅.
                  $("#"+radid).attr("checked",true);
                  $("#"+btnid).css("background","#198754");
                  $("#"+btnid).css("color","#fff");
                  $("."+ciid).show();
               }
            }else{
               // 클릭한 버튼 이외에는 체크 해제 및 색상 초기화
               $("#"+radid).attr("checked",false);
               $("#"+btnid).css("background","#fff");
               $("#"+btnid).css("color","#198754");
               // console.log(btnid+" "+$("#"+btnid).css("background"));
            }
         }
       
      });
   });


</script>


<div class="container itemdetail">
   <div class="pagetitle">
      <h1>상품
         <?= $type_name ?>
      </h1>
      <nav>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="main.php">Home</a></li>
            <li class="breadcrumb-item active">상품
               <?= $type_name ?>
            </li>
         </ol>
      </nav>
   </div><!-- End Page Title -->

   <div class="cont col-lg-12">
      <div class="middle_div card">
         <div class="card-body">
            <h5 class="card-title">상품 <?= $type_name ?> 폼</h5>

            <!-- Multi Columns Form -->
            <form class="row g-3" method="post" id="itemForm">
               <input type='hidden' name="return_page" value="<?=$return_page?>" />
               <input type="hidden" name="keyword_txt" value="<?=$keyword?>" />
               <input type='hidden' name='brand_index' value="<?=$bidx?>" />
               <input type='hidden' name='opt_cnt' value="1" />
               
               <div class="col-md-12">
                  <label for="pname" class="form-label">상품명</label>
                  <input type="text" class="form-control" id="pname" name="product_name" onchange="chkSpaceFe(this)">
               </div>
               <div class="col-md-3">
                  <div class="thumbsnail" id="thumbsimg">
                     <div class="thumbbtn_div">
                        <a class="btn btn-primary btn-sm iupload" title="대표 이미지 업로드"><i class="bi bi-upload"></i></a>
                        <a class="btn btn-danger btn-sm idelete" title="삭제"><i class="bi bi-trash"></i></a>
                        <input type="file" name="thumbsnail_img" class="thumbimg" onchange="setThumbnail(event,'thumbsimg')" />
                     </div>
                  </div>
               </div>
               <div class="col-md-9">
                  <div class="chg_page">
                     <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                           <li class="nav-item flex-fill" role="presentation">
                              <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                                 data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home"
                                 aria-selected="true">랜딩</button>
                                 <i class="bi bi-check-circle me-1 nowcheck-icon cicon1"></i>
                           </li>
                           <li class="nav-item flex-fill" role="presentation">
                              <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab"
                                 data-bs-target="#bordered-justified-profile" type="button" role="tab"
                                 aria-controls="profile" aria-selected="false">오픈중</button>
                                 <i class="bi bi-check-circle me-1 nowcheck-icon cicon2"></i>
                           </li>
                           <li class="nav-item flex-fill" role="presentation">
                              <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                 data-bs-target="#bordered-justified-contact" type="button" role="tab"
                                 aria-controls="contact" aria-selected="false">프리오더</button>
                                 <i class="bi bi-check-circle me-1 nowcheck-icon cicon3"></i>
                           </li>
                        </ul>
                        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                           <div class="tab-pane fade show active" id="bordered-justified-home" role="tabpanel"
                              aria-labelledby="home-tab">

                              <div class="col-12 d-flex">
                                 <div class="col-md-6 col-sm-6">
                                    <div class="colwrap">
                                       <label for="orderStart" class="form-label">표시 기간</label>
                                       <div class="d-flex">
                                          <div class="col-sm-6">
                                             <input type="date" name="land_start" class="form-control " id="orderStartLand" />
                                          </div>
                                          <div class="col-sm-1"><span>~</span></div>
                                          <div class="col-sm-5">
                                             <input type="date" name="land_end" class="form-control " />
                                          </div>
                                       </div>
                                    </div>
                                    <? if($reg_type == "E"): ?>
                                    <div class="colwrap setbtn">
                                       <input type="button" id="setDate1" class="btn btn-primary" value="지정" />
                                    </div>
                                    <? endif; ?>
                                 </div>
                                 <div class="col-md-1 col-sm-1"></div>
                                 <div class="col-md-4 col-sm-4 now_div">
                                    <label for="writeNow" class="form-label">즉시 적용</label>
                                    <div class="col-sm-6">
                                       <input type="radio" name="write_now" class="nowval" id="writeNow1" value="Y1" checked/>
                                       <button type="button" class="btn btn-outline-success" id="now1"><i
                                             class="bi bi-check-circle nocheck btn-now1"></i></button>
                                    </div>
                                 </div>
                              </div>

                           </div>
                           <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel"
                              aria-labelledby="profile-tab">

                              <div class="col-12 d-flex">
                                 <div class="col-md-6 col-sm-6">
                                    <div class="colwrap">
                                          <label for="orderStart" class="form-label">표시 기간</label>
                                          <div class="d-flex">
                                             <div class="col-sm-6">
                                                <input type="date" name="open_start" class="form-control " id="orderStartO" />
                                             </div>
                                             <div class="col-sm-1"><span>~</span></div>
                                             <div class="col-sm-5">
                                                <input type="date" name="open_end" class="form-control " />
                                             </div>
                                          </div>
                                    </div>
                                    <? if($reg_type == "E"): ?>
                                    <div class="colwrap setbtn">
                                       <input type="button" id="setDate1" class="btn btn-primary" value="지정" />
                                    </div>
                                    <? endif; ?>
                                 </div>
                                 <div class="col-md-1 col-sm-1"></div>
                                 <div class="col-md-4 col-sm-4 now_div">
                                       <label for="writeNow" class="form-label">즉시 적용</label>
                                       <div class="col-sm-6">
                                          <input type="radio" name="write_now" class="nowval" id="writeNow2" value="Y2" />
                                          <button type="button" class="btn btn-outline-success" id="now2"><i
                                                class="bi bi-check-circle nocheck btn-now2"></i></button>
                                       </div>
                                 </div>
                              </div>                           
                              
                           </div>
                           <div class="tab-pane fade" id="bordered-justified-contact" role="tabpanel"
                              aria-labelledby="contact-tab">

                              <div class="col-12 d-flex">
                                 <div class="col-md-6 col-sm-6">
                                    <div class="colwrap">
                                          <label for="orderStart" class="form-label">표시 기간</label>
                                          <div class="d-flex">
                                             <div class="col-sm-6">
                                                <input type="date" name="pre_start" class="form-control " id="orderStartP" />
                                             </div>
                                             <div class="col-sm-1"><span>~</span></div>
                                             <div class="col-sm-5">
                                                <input type="date" name="pre_end" class="form-control " />
                                             </div>
                                          </div>
                                    </div>
                                    <? if($reg_type == "E"): ?>
                                    <div class="colwrap setbtn">
                                       <input type="button" id="setDate1" class="btn btn-primary" value="지정" />
                                    </div>
                                    <? endif; ?>
                                 </div>
                                 <div class="col-md-1 col-sm-1"></div>
                                 <div class="col-md-4 col-sm-4 now_div">
                                       <label for="writeNow" class="form-label">즉시 적용</label>
                                       <div class="col-sm-6">
                                          <input type="radio" name="write_now" class="nowval" id="writeNow3" value="Y3" />
                                          <button type="button" class="btn btn-outline-success" id="now3"><i
                                                class="bi bi-check-circle nocheck btn-now3"></i></button>
                                       </div>
                                 </div>
                              </div>    
                              
                           </div>
                        </div>
                        
                     </div> <!-- end of card_body -->
                  </div> <!-- end of chg_page -->
               </div>
               

               <div class="col-12 d-flex">
                  <div class="col-md-6 col-sm-6">
                     <label for="price" class="form-label">가격</label>
                     <div class="col-sm-11 d-flex">
                        <input type="number" id="price" name="product_price" class="form-control " maxlength="12"
                           oninput="maxLengthCheck(this)"  onchange="chkSpaceFe(this)"/>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                     <label for="odate" class="form-label">주문 기간</label>
                     <div class="d-flex">
                        <div class="col-sm-6 d-flex">
                           <input id="odate" type="date" name="order_start" class="form-control " />
                        </div>
                        <div class="col-sm-1"><span>~</span></div>
                        <div class="col-sm-5">
                           <input id="edate" type="date" name="order_end" class="form-control " />
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12 d-flex">
                  <div class="col-md-6 col-sm-6">
                     <label for="quan" class="form-label">수량</label>
                     <div class="col-sm-11 d-flex">
                        <input type="number" id="quan" name="product_quantity" class="form-control " onchange="chkSpaceFe(this)"/>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                     <label for="moq" class="form-label">최소 수량(미입력시 1 )</label>
                     <div class="col-sm-11 d-flex">
                        <input type="number" id="moq" name="product_moq" class="form-control " onchange="chkSpaceFe(this)"/>
                     </div>
                  </div>
               </div>
               <div class="col-12 d-flex">
                  <div class="col-md-6 col-sm-6">
                     <label for="dcomp" class="form-label">배송업체</label>
                     <div class="col-sm-11 d-flex">
                        <select class="form-select" name="delivery_comp" id="dcomp">
                           <option value="ALL">업체를 선택 해 주세요.</option>
                           <? foreach ($deli_arr as $v): ?>
                              <option value="<?= $v ?>"><?= $v ?></option>
                           <? endforeach; ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                     <label for="dydate" class="form-label">배송예정일</label>
                     <div class="col-sm-11 d-flex">
                        <input type="date" id="dydate" name="delivery_maybe" class="form-control " maxlength="12"
                           oninput="maxLengthCheck(this)" />
                     </div>
                  </div>
               </div>
               <div class="col-12 d-flex">
                  <div class="col-md-6 col-sm-6">
                     <label for="dval" class="form-label">배송비</label>
                     <div class="col-sm-11 d-flex">
                        <input type="number" id="dval" name="delivery_coast" class="form-control " maxlength="12"
                           oninput="maxLengthCheck(this)" onchange="chkSpaceFe(this)" />
                     </div>
                  </div>
               </div>
               <div class="col-12 d-flex">
                  <div class="col-sm-1 d-flex align-items-center justify-content-center">키워드 : <br>(10개 까지)</div>
                  <div class="col-sm-4 d-flex align-items-center">
                     <input type="text" name="kw" id="kw" class="form-control " onchange="chkSpaceFe(this)" />
                  </div>
                  <div class="col-sm-1 d-flex align-items-center justify-content-center">
                     <input type="button" class="btn btn-outline-primary" value="추가" onclick="setKeyWord(this)" />
                  </div>
                  <div class="col-sm-6 key_div">
                     <div class="key_box d-flex flex-column">
                        <?=$key_html?>
                     </div>
                  </div>
               </div>



               <div class="col-12">
                  <div class="radio_div d-flex justify-content-center">
                     <input class="form-radio-input" type="radio" id="radioDh" name='sale_type' value="D" checked>
                     <label class="form-check-label" for="radioDh">
                        대행형
                     </label>
                     <input class="form-radio-input" type="radio" id="radioCp" name='sale_type' value="C">
                     <label class="form-check-label" for="radioCp">
                        총판형
                     </label>
                  </div>
               </div>

               <div class="col-12">
                  <div class="opt_row col-lg-12 d-flex">
                     <div class="col-lg-12 opt_title d-flex">
                        <div class="col-md-3">
                           <label class="form-label">옵션명</label>
                        </div>
                        <div class="col-md-8">
                           <label class="form-label">옵션값</label>
                        </div>
                     </div>
                  </div>
                  <div class="opt_show_div col-lg-12">
                     <div class="opt_row d-flex opt_div1">
                        <div class="opt_name col-md-3">
                           <input type="text" class="form-control" id="optname1" name="optname1" placeholder="ex) 색상, 종류, 사이즈"/>
                        </div>
                        <div class="opt_value col-md-8 d-flex">
                           <div class="input_div col-md-8">
                              <input type="text" class="form-control" id="optvalue1" name="optvalue1" placeholder="ex) XS,S,M,L - ,로 구분" onchange="chkSpaceFe(this)"; />
                           </div>
                           <div class="btn_div bd1 col-md-2 d-flex align-items-center">
                              <i class="bi bi-plus-square cpointer" onclick="addOpt()"></i>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row_div col-lg-12">
                     <div class="showbtn_div col-md-3"><input type="button" class="btn btn-secondary" value="옵션 세팅" onclick="setOptTable()" />
                  </div>
               
                  <div class="row_div col-lg-12">
                     <div class="table_div">
                        <table class="table table-bordered">
                        </table>

                     </div>
                  </div>   
                  
               </div>


               <div class="text-center regbtn_div">
                  <button type="button" class="btn btn-primary" onclick="regItem('<?=$reg_type?>')"><?=$type_name?></button>
                  <button type="button" class="btn btn-secondary" onclick="cancelReturn()">취소</button>
               </div>
         </form><!-- End Multi Columns Form -->
         
         </div>   <!-- end of card-body -->
      </div>   <!-- end of middle_div -->
      
   </div>
</div>

<?
include "./admin_footer.php";
?>