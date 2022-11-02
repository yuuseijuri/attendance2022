@extends('layouts.default')

@section('content')
<link rel="stylesheet" href="{{ asset('css/date.css') }}">
  <h1 class="title">日付一覧</h1>
  <ul class="list">
    <li class="list_home"><a href="/home">ホーム</a></li>
    <!-- <li class="list_date"><a href="/date">日付一覧</a></li> -->
    <li class="list_logout"><a href="/logout">ログアウト</a></li>
  </ul>
  <div class="main">
    @if(count($errors) > 0)
    <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
    @endif
    <!-- <p><input type="date" class="date"></p> -->
    <p class="date">{{ $days }}</p>
    <hr>
    <table class="date_text">
      <tr>
        <th class="date_name">名前</th>
        <th class="date_job__start">勤務開始</th>
        <th class="date_job__end">勤務終了</th>
        <th class="date_job__time">勤務時間</th>
        <th class="date_job__rest">休憩時間</th>
      </tr>
      <form action="{{ route('date') }}" method="post">
        
        <tr>
          <td>{{ $users->name }}</td>
          <td>{{ $starts->start_time }}</td>
          <td>{{ $ends->end_time }}</td>
          
        </tr>
        
      </form>
    </table>
    <p class="link">{{ $pages->links() }}</p>
    
  </div>
  <div class="footer">
    <p class="logo">Attendance,inc.</p>
  </div>  
@endsection

