@extends('layouts.app')
@section('content')
<div class="container" >
	<show-front :all-albums="{{$albumImages}}"></show-front>
</div>

@endsection