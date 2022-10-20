<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance</title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/default.css') }}">
</head>
<body class="container">
  <div class="header">
    @yield('header')
  </div>
  <main class="main">
    @yield('main')
  </main>
  <div class="footer">
    @yield('footer')
  </div>
</body>
</html>