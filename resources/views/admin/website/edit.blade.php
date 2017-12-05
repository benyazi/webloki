@extends('layouts.admin')

@section('content')
    <admin-website-edit website-id="{{$website->id}}"></admin-website-edit>
@endsection
