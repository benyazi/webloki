@extends('layouts.website')

@section('body')
<div id="app">
    {!! $websiteFactory->menu->render() !!}
    @yield('content')
</div>
@endsection