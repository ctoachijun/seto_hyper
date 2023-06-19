<?
include "./admin_header.php";
?>
<div class="container">
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
              <th scope="col">No.</th>
              <th scope="col">제품</th>
              <th scope="col">메일 주소</th>
              <th scope="col">등록일</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row"></th>
              <td>아톨</td>
              <td>atollatoll@atoll.com</td>
              <td>어제</td>
            </tr>
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