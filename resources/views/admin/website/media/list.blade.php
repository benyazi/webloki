@extends('layouts.admin')

@section('content')
    <admin-website-media website-id="{{$editWebsiteFactory->website->id}}"></admin-website-media>
@endsection
