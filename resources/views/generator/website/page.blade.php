@extends('layouts.templates.' . $websiteFactory->getTemplateName() . '.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$websiteFactory->page->activePage->title}}</div>

                    <div class="panel-body">
                        {!! $websiteFactory->page->getActiveHtmlContent() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
