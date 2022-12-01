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
    <p class="date">
      <a href="/date/{{ $days_ye }}"><button type="button">⇦{{ $days_ye }}</button></a>
      <span>{{ $days }}</span>
      <a href="/date/{{ $days_to }}"><button type="button">{{ $days_to }}⇨</button></a>
    </p>
    {{-- <form action="" method="get">
    @csrf
      <p class="date">
        <span><input type="submit" value="<{{ $days_ye }}"></span>
      {{ $days }}
      <span><input type="submit" value="{{ $days_to }}>"></span>
      </p>
    </form> --}}
    <hr>
    <table class="date_text">
      <tr>
        <th class="date_name">名前</th>
        <th class="date_job__start">勤務開始</th>
        <th class="date_job__end">勤務終了</th>
        <th class="date_job__time">勤務時間</th>
        <th class="date_job__rest">休憩時間</th>
      </tr>
      {{-- <form action="{{ route('date') }}" method="post"> --}}
        @csrf
        @foreach($attends as $attend)
        <tr>
          <td>{{ $attend['name'] }}</td>
          <td>{{ $attend['attendance']->start_time}}</td>
          <td>{{ $attend['attendance']->end_time }}</td>
          <td>{{ $attend['all_time'] }}</td>
          <td>{{ $attend['rest_sum_str'] }}</td>
        </tr>
        @endforeach
      {{-- </form> --}}
    </table>
    <div class="link">{{ $pages->links() }}</div>
    
  </div>
  <div class="footer">
    <p class="logo">Attendance,inc.</p>
  </div>  
@endsection

