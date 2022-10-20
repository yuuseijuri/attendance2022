<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance</title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <style>
  .container {
    width: 100vw;
    height: 100vh;
    position: relative;
  }
  .main {
    width: 100vw;
    height: 85vh;
    position: absolute;
    top: 10vh;
    background-color: #DCDCDC;
  }
  </style>
</head>
<body class="container">
  <div class="header">
    <h1 class="title">勤怠管理システム</h1>
    <ul class="list">
      <li><a href="/home">ホーム</a></li>
      <li><a href="/date">日付一覧</a></li>
      <li><a href="/logout">ログアウト</a></li>
    </ul>
  </div>
  <main class="main">
    @yield('main')
  </main>
  <div class="footer">
    <span class="bottom">Attendance,inc.</span>
  </div>
</body>
</html>