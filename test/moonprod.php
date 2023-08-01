<?
include "../lib/hyper.php";

// 문의유형
$tclass = "P";
$mtype = getMooniList($tclass);
$midx = rand(1,3);
$iidx = rand(1,4);
$item = getIteminfo($iidx);

$item_name = $item['i_name'];


?>


<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Setoworks Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="../css/hyper.css" rel="stylesheet">
  
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="../js/common.js"></script>
  <script src="../js/hyper.js"></script>
 
</head>

<body>

  <div id="main">
    <div class="container">


      <div class="moonsite teduri">
        <form method="post" id="moonForm">
          <input type="hidden" name="memberid" value="<?=$midx?>" />
          <input type="hidden" name="tclass" value="<?=$tclass?>" />
          <input type="hidden" name="productid" value="<?=$iidx?>" />
          <div class="top_div">
            <div class="top_title">상품 문의</div>
          </div>
          <div class="middle_div">
            <div class="line_6 d-flex a-center">
              <p>상품 : </p><b><?=$item_name?></b>
            </div>

            <div class="line_1 d-flex">
              <p>분류 : </p>
            <? 
              $cnt = 0;
              foreach($mtype as $v) : 
                $mt_name = $v['mnc_name'];
                $mt_idx = $v['mnc_idx'];
                $cnt++;
            ?>
                <input type='radio' id="mt<?=$mt_idx?>" name="moontype" value="<?=$mt_idx?>" <? if($cnt==1) echo "checked"; ?>><label for="mt<?=$mt_idx?>"><?=$mt_name?></label>
            <? endforeach; ?>
            </div>
            <div class="line_2 d-flex a-center">
              <label for="subject">제목 : </label><input type="text" class="txt-input" name="subject" id="subject" />
            </div>
            <div class="line_3 d-flex">
              <label for="cont">내용 : </label><textarea id="cont" class="txt-area" name="cont"></textarea>
            </div>
            <div class="line_5 d-flex a-center">
              <input type="button" class="btn btn-primary" value="등록"/>
              <input type="button" class="btn btn-cancel" value="취소"/>
            </div>
          </div>
        </form>
      </div>
    
       
      <script>
        
        $(".btn-primary").click(function(){
          // 빈값 체크는 안함 ㅋ
          
          if( confirm("문의를 등록하시겠습니까?") ){
            let f = new FormData($("#moonForm")[0]);
            f.append("w_mode","regMooni");
            
            $.ajax({
              url : "../ajax_hyper.php",
              type: "post",
              processData: false,
              contentType: false,
              data: f,
              success: function(result){
                let json = JSON.parse(result);
                console.log(json);
                
                if(json.state == "Y"){
                  alert("등록되었습니당");
                  history.go(0);
                }else{
                  alert("에러입니당 ;;");
                }
              }
            })
          }
        })
        
      </script>
      
      
    
    </div>
  </div>
  <!-- end of main -->
  
</body>
</html>
