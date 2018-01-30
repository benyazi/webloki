@extends('layouts.admin')

@section('content')
    <admin-website-page-add page-id="{{$page->id}}" website-id="{{$editWebsiteFactory->website->id}}"></admin-website-page-add>
@endsection
