<?
include "./admin_header.php";

// for($i=1;$i<13;$i++){
//   $email = "jhj{$i}@setoworks.com";
//   $sql = "INSERT INTO st_smail SET s_aidx = 1, s_iidx = 1, s_email = '{$email}', s_wdate = now()";
//   sql_exec($sql);
//   sleep(1);
// }

$mail_box = getMailListAll($aid);
// 최초값 설정
$total_cnt = count($mail_box);


?>

<div class="container maillist">
  <div class="pagetitle">
    <h1>General Tables</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active">General</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="cont col-lg-12 card">
    <div class="top_div card-body">
      <h5 class="card-title">수집 된 메일 목록</h5>

    </div>
    <div class="middle_div card-body">

      <div class="table_div">
        <table clss="table table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>브랜드</th>
              <th>제품</th>
              <th>메일 주소</th>
              <th>등록일</th>
            </tr>
          </thead>
          <tbody>
<?
          foreach($mail_box as $v) :
?>            
            <tr>
              <th><?=$total_cnt?></th>
              <td></td>
              <td>아톨</td>
              <td>atollatoll@atoll.com</td>
              <td>어제</td>
            </tr>
<?
            $total_cnt--;
          endforeach;
?>

          </tbody>
        </table>
      </div>
      <div class="paging_div">
      </div>

    </div>

  </div>
</div>

<?
include "./admin_footer.php";
?>