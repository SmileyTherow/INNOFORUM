<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <!-- Hubungkan ke file CSS -->
    <link rel="stylesheet" href="/css/login_admin.css">
  </head>
  <body>
    <div class="main-container centered-flex">
      <div class="form-container">
        <div class="icon fa fa-user"></div>
        <form class="centered-flex" method="POST" action="{{ route('login.admin') }}">
          @csrf
          <div class="title">LOGIN</div>
          <div class="msg"></div>
          <div class="field">
            <input type="text" placeholder="Username" id="uname" name="username" required>
            <span class="fa fa-user"></span>
          </div>
          <div class="field">
            <input type="password" placeholder="Password" id="pass" name="password" required>
            <span class="fa fa-lock"></span>
          </div>
          <div class="action centered-flex">
            <label for="remember" class="centered-flex">
              <input type="checkbox" id="remember" name="remember"> Remember me
            </label>
            <a href="#">Forget Password?</a>
          </div>
          <div class="btn-container">
            <button type="submit" id="login-btn">Login</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Hubungkan ke file JS -->
    <script src="/js/login_admin.js"></script>
  </body>
</html>