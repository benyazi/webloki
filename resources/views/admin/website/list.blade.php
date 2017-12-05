@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{__("messages.WEBSITE_LIST_TITLE")}}</div>
                    <div class="panel-body">
                        <table class="table table-bordered table-responsive table-hovered">
                            <thead>
                            <tr>
                                <th>{{__("messages.WEBSITE_ID")}}</th>
                                <th>{{__("messages.WEBSITE_NAME")}}</th>
                                <th>{{__("messages.WEBSITE_DOMAIN")}}</th>
                                <th>{{__("messages.WEBSITE_ACTIONS")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($websites as $website)
                                <tr>
                                    <td>{{$website->id}}</td>
                                    <td>{{$website->name}}</td>
                                    <td>{{$website->domain}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{route('admin.website.edit', ['websiteId'=>$website->id])}}">
                                            {{__("messages.WEBSITE_EDIT")}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <a href="{{route('admin.website.add')}}" class="btn btn-info btn-sm">Добавить новый сайт</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
