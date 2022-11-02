@extends('layouts.default')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <h1 class="title">勤怠管理システム</h1>
  <ul class="list">
    <li class="list_date"><a href="/date">日付一覧</a></li>
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
    <p class="staff">「{{ $users->name }}」さんお疲れ様です！</p>
    <div class="btn_area__job">
      <form action="{{ route('home/jobIn') }}" method="post">
      @csrf
        <input type="submit" name="start_time" value="勤務開始" class="btn_job__start">
      </form>
      <form action="{{ route('home/jobOut') }}" method="post">
      @csrf
        <input type="submit" name="end_time" value="勤務終了" class="btn_job__end">
      </form>
    </div>
    <div class="btn_area__rest">
      <form action="{{ route('home/restIn') }}" method="post">
      @csrf
        <input type="submit" name="start_time" value="休憩開始" class="btn_rest__start">
      </form>
      <form action="{{ route('home/restOut') }}" method="post">
      @csrf
        <input type="submit" name="end_time" value="休憩終了" class="btn_rest__end">
      </form>
    </div>
  </div>
  <div class="footer">
    <p class="logo">Attendance,inc.</p>
  </div>
@endsection