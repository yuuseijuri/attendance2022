@extends('layouts.default')

@section('main')
@if(count($errors) > 0)
  <ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
@endif
<p class="staff">「{{ $user->name }}」さんお疲れ様です！</p>
<form action="{{ route('home') }}" method="post" class="">
@csrf
  <input type="submit" name="start_time" value="勤務開始">
@csrf
  <input type="submit" name="end_time" value="勤務終了">
@csrf
  <input type="submit" name="start_time" value="休憩開始">
@csrf
  <input type="submit" name="end_time" value="休憩終了">
</form>
@endsection