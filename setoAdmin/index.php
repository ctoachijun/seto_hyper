<!doctype html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.79.0">
  <title>Signin Template · Bootstrap v5.0</title>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>




  <!-- Bootstrap core CSS -->
  <link href="tpl/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    html,
    body {
      height: 100%;
    }

    body {
      display: flex;
      align-items: center;
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
    }

    .form-signin {
      width: 100%;
      max-width: 330px;
      padding: 15px;
      margin: auto;
    }

    .form-signin .checkbox {
      font-weight: 400;
    }

    .form-signin .form-floating:focus-within {
      z-index: 2;
    }

    .form-signin input[type="email"] {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }
  </style>


  <script>
      function chkAccnt(){
          if (!$('#id').val()) {
            alert("ID를 입력 해 주세요.");
            $("#id").focus();
            return false;
          }
          if (!$("#pw").val()) {
            alert("비밀번호를 입력 해 주세요");
            $("#pw").focus();
            return false;
          }

          let id = $("#id").val();
          let pw = $("#pw").val();
          let jud = true;

          $.ajax({
            url: "../ajax_hyper.php",
            type: "post",
            async: false,
            data: { "w_mode": "adminChk", "id": id, "pw": pw }
          }).done(function (result) {
            let json = JSON.parse(result);
            console.log(json);

            if (json.state == "N") {
              alert("계정정보를 확인 해 주세요");
              jud = false;
            }
          })
          
          if(jud){
            return true;
          }
          
          return false;
      }

  </script>


</head>

<body class="text-center">


  <main class="form-signin">
    <form method="post" id="accnt" onsubmit="return chkAccnt();" action="./main.html">
      <img class="mb-4" src="./tpl/assets/img/logo.png" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
      <input type="text" id="id" name="id" class="form-control" placeholder="ID" required autofocus>
      <input type="password" id="pw" name="pw" class="form-control" placeholder="Password" required>
      <button class="w-100 btn btn-lg btn-primary" id='sbtn' type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; Setoworks Co., Ltd.</p>
    </form>
  </main>



</body>

</html>