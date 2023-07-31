<?
include "./admin_header.php";

// HTML 세팅
$left_moon = getMooniListHtml('S');
$right_moon = getMooniListHtml('P');


// 문의 데이터 더미 입력
// for($i=0; $i<27; $i++){
//   $midx = rand(1,3);
//   $iidx = rand(1,5);
//   $mncidx = rand(1,10);
  
//   $sub_arr = array("이거 뭔가요?","언제와요?","취소해주세요","상품 왜이런가요?","사이트가 불편해요","이거 사기꾼아닌가요?","살다살닼ㅋㅋ이런사이트 처음봄 ㅋㅋㅋ","취소 좀 해줘요","환불요. 빨리요.","언제오나요. 1년뒤??");
//   $cont_arr = array("뭐하자는건지 알수가 없음.","천년만년..목빠지겠다.","빠른취소! 무브무브!!","이걸 쓰라고 만든건가요?\n양심도 없나요?\n개념 좀..","어떻게 써야할지 모르겠음요.","고소할꺼임. 사기꾼쉐이들 ㅉ","무슨 부귀영화를 누리려고 만들었냐 ㅋㅋㅋㅋㅋ\n접어라 빨리 ㅋㅋㅋㅋ","제발 좀..부탁드립니다 ㅠㅠ","돈 돌려줘!!!! 이씽~!!~!~~","배송은 거북이택배를 쓰냐.. ㅋㅋㅋㅋ 배송예정일을 300일 이후로 재설정 하자 ㅋㅋㅋ","아오.......아오!!!!!!! 속터지네 !!! ");
 
//   $term = $i * 3;
//   $tstamp = strtotime("+{$term} seconds");
//   $now = date("Y-m-d H:i:s", $tstamp);

//   $subject = $sub_arr[array_rand($sub_arr)];
//   $cont = $cont_arr[array_rand($cont_arr)];

//   $sql = "INSERT INTO st_mooni SET mn_midx = {$midx}, mn_iidx = {$iidx}, mn_mncidx = {$mncidx}, mn_subject = '{$subject}', mn_cont = '{$cont}', mn_mdate = '{$now}'";
//   $re = sql_exec($sql);  
  
//   echo "$sql <br>";
//   // if($i==2) break;
  
// }



?>


<div class="container mooniClass">
  <div class="pagetitle">
    <h1>문의 유형 관리</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item">문의 관리</li>
        <li class="breadcrumb-item active">문의 유형 관리</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  
  <div class="cont col-lg-12 card">
    <div class="top_div card-body">
      <h5 class="card-title">문의 유형 설정</h5>
      <div class="brand_div">
      </div>
    </div>

    <div class="middle_div d-flex justify-content-start">
        <div class="col-lg-6 col-md-6">
          <div class="left_div card-body d-flex justify-content-center">
            <div class="left_cont col-md-8">
                <div class="cont_title">사이트 문의 유형</div>
                <div class="cont_top d-flex">
                  <input type="text" class="form-control" name="sname" />
                  <input type="button" class="btn btn-primary" value="+" onclick="setMcHtml('l')" />
                </div>
                <div class="cont_body"><?=$left_moon?></div>
                <div class="cont_bottom d-flex justify-content-center">
                  <!-- <input type="button" class="btn btn-primary" value="적용" /> -->
                </div>
            </div>
          </div>
        </div>
        
        
        <div class="col-lg-6 col-md-6">
          <div class="right_div card-body d-flex justify-content-center">
            <div class="right_cont col-md-8">
                <div class="cont_title">상품 문의 유형</div>
                <div class="cont_top d-flex">
                  <input type="text" class="form-control" name="pname" />
                  <input type="button" class="btn btn-primary" value="+" onclick="setMcHtml('p')" />
                </div>
                <div class="cont_body"><?=$right_moon?></div>
                <div class="cont_bottom d-flex justify-content-center">
                </div>
            </div>
          </div>
        </div>
    
    </div>      
    
    
  </div>
</div>





<? include "./admin_footer.php"; ?>