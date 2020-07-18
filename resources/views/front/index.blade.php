@extends('layouts.app')
@section('content')
<div class="container" >
	<front-component :all-albums="{{$albums}}"></front-component>
</div>

@endsection