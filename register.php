<?php include ".LoginRedirect.php"; ?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
  <meta charset=" UTF-8">
  <meta http-equiv="Cache-Control" content="no-store" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>註冊</title>
  <?php include '.Style.php' ?>
  <?php include '.LinkSql.php' ?>
</head>
<?php include '.Theme.php'; ?>
<!-- 新增使用者, 將新用戶的資料家入 -->
<?php
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $passwordCheck = $_POST['passwordCheck'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
}
?>

<body class=<?php echo $theme ?>>
  <!-- 標題橫條 + 切換按鈕 -->
  <?php include '.Header.php'; ?>
  <!-- 主要頁面內容開始 -->
  <main class="logincontainer">
    <div class="wrapper">
      <form id="RegisterForm" action="register.php" method='post'>
        <h1>註冊</h1>
        <div>
          <div class="input-box">
            <input type="text" name="username" id="username" placeholder="使用者名稱">
            <!-- 左邊圖示 (人頭)-->
            <i class='bx bxs-user icon-left'></i>
            <p class='ms-1 mt-1 text-danger' id="username-err"></p>
          </div>
          <div class="input-box">
            <input type="password" name="password" id="password" placeholder="密碼">
            <!-- 左邊圖示 (鎖頭) -->
            <i class=' bx bxs-lock-alt icon-left'></i>
            <!-- 右邊圖示 (眼睛) -->
            <i class='bx bx-hide icon-right' id="passwordIcon"></i>
            <p class='ms-1 mt-1 text-danger' id="password-err"></p>
          </div>
          <div class="input-box">
            <input type="password" name="passwordCheck" id="passwordCheck" placeholder="密碼確認">
            <!-- 左邊圖示 (鎖頭) -->
            <i class='bx bx-x icon-left' id="check-icon"></i>
            <p class='ms-1 mt-1 text-danger ' id="passwordCheck-err"></p>
          </div>
          <div class="input-box">
            <input type="email" name="email" id="email" placeholder="電子信箱">
            <!-- 左邊圖示 (信箱) -->
            <i class='bx bxs-envelope icon-left'></i>
            <p class='ms-1 mt-1 text-danger' id='email-err'></p>
          </div>
          <div class="input-box">
            <input type="number" name="phone" id="phone" placeholder="手機號碼">
            <!-- 左邊圖示 (手機) -->
            <i class='bx bxs-phone icon-left'></i>
            <p class='ms-1 mt-1 text-danger' id='phone-err'></p>
          </div>
        </div>
        <!-- 密碼要求列表, 待編輯 -->
        <button type="submit" class="btn" id="submitButton">註冊</button>
        <div class="link-out">
          <p>已有帳戶?<a href="login.php">登入</a></p>
          <div class='text-danger' id="message"></div>
        </div>
      </form>
    </div>
  </main>
  <!-- footer 開始 -->
  <?php include '.Footer.php'; ?>
  <!-- footer結束 -->
</body>
<?php include '.Script.php' ?>
<script>
  // if #message == "註冊成功", Redirect to login.php
  $(document).ready(function() {
    $("#RegisterForm").validate({
      rules: {
        username: {
          required: true,
          minlength: 3,
          maxlength: 20
        },
        password: {
          required: true,
          minlength: 8,
          maxlength: 20
        },
        passwordCheck: {
          required: true,
          equalTo: "#password"
        },
        email: {
          required: true,
          email: true
        },
        phone: {
          required: true,
          minlength: 10,
          maxlength: 10
        }
      },
      messages: {
        username: {
          required: "請輸入使用者名稱",
          minlength: "使用者名稱至少要有3個字元",
          maxlength: "使用者名稱最多20個字元"
        },
        password: {
          required: "請輸入密碼",
          minlength: "密碼至少要有8個字元",
          maxlength: "密碼最多20個字元"
        },
        passwordCheck: {
          required: "請再次輸入密碼",
          equalTo: "兩次密碼輸入不一致"
        },
        email: {
          required: "請輸入電子信箱",
          email: "請輸入正確的電子信箱"
        },
        phone: {
          required: "請輸入手機號碼",
          minlength: "手機號碼至少要有10個字元",
          maxlength: "手機號碼最多10個字元"
        }
      },
      submitHandler: function(form) {
        $.ajax({
          url: 'register_action.php',
          type: 'POST',
          data: $('#RegisterForm').serialize(),
          success: function(response) {
            if (response == '註冊成功') {
              window.location.href = 'login.php';
            } else {
              $('#message').html(response);
            }
          }
        });
      }
    });
  });
</script>
</html>