@extends('layouts.admin')

@section('content')
    <admin-website-page-add website-id="{{$editWebsiteFactory->website->id}}"></admin-website-page-add>
@endsection
