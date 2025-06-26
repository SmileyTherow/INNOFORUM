<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registrasi Dosen</title>
    <link rel="stylesheet" href="/css/login_register_dosen.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,600" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.11.3/paper-full.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <div id="back">
      <canvas id="canvas" class="canvas-back"></canvas>
      <div class="backRight"></div>
      <div class="backLeft"></div>
    </div>
    <div id="slideBox">
      <div class="topLayer">
        {{-- Alert digantikan oleh SweetAlert2 --}}
        <div class="left">
          <div class="content">
            <h2>Registrasi</h2>
            <form id="form-signup" method="post" action="{{ route('register.process') }}" enctype="multipart/form-data">
              @csrf
              <div class="form-element form-stack">
                <label for="username-signup" class="form-label">Nama</label>
                <input id="username-signup" type="text" name="name" required>
              </div>
              <div class="form-element form-stack">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" required>
              </div>
              <div class="form-element form-stack">
                <label for="password-signup" class="form-label">Password</label>
                <input id="password-signup" type="password" name="password" required>
              </div>
              <div class="form-element form-stack">
                <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                <input id="password-confirmation" type="password" name="password_confirmation" required>
              </div>
              <div class="form-element form-stack">
                <label for="prodi" class="form-label">Mata kuliah yang diampu</label>
                <input id="prodi" type="text" name="prodi" required>
              </div>
              <div class="form-group">
                <label for="photo">Foto Profil</label>
                <input id="photo" type="file" class="form-control" name="photo">
              </div>
              <div class="form-element form-submit">
                <button id="signUp" class="signup" type="submit">Registrasi</button>
                <button id="goLeft" class="signup off" type="button">Log In</button>
              </div>
            </form>
          </div>
        </div>
        <div class="right">
          <div class="content">
            <h2>Login</h2>
            <form id="form-login" method="post" action="{{ route('login.process') }}">
              @csrf
              <div class="form-element form-stack">
                <label for="username-login" class="form-label">Email</label>
                <input id="username-login" type="email" name="email" required>
              </div>
              <div class="form-element form-stack">
                <label for="password-login" class="form-label">Password</label>
                <input id="password-login" type="password" name="password" required>
              </div>
              <div class="form-element form-submit">
                <button id="logIn" class="login" type="submit">Log In</button>
                <button id="goRight" class="login off" type="button">Registrasi</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function () {
        $("#goLeft").click(function () {
          $("#slideBox").animate({ marginLeft: "0" });
        });
        $("#goRight").click(function () {
          $("#slideBox").animate({ marginLeft: "50%" });
        });

        // SweetAlert2 flash message
        @if (session('success'))
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        @endif

        @if (session('error'))
          Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Coba Lagi'
          });
        @endif

        @if ($errors->any())
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
          });
        @endif
      });
    </script>
    <script src="/js/login_register_dosen.js"></script>
  </body>
</html>