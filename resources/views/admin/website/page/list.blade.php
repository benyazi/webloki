@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{__("messages.WEBSITE_PAGE_LIST_TITLE")}}</div>
                    <div class="panel-body">
                        <table class="table table-bordered table-responsive table-hovered">
                            <thead>
                            <tr>
                                <th>{{__("messages.WEBSITE_PAGE_ID")}}</th>
                                <th>{{__("messages.WEBSITE_DOMAIN")}}</th>
                                <th>{{__("messages.PAGE_TITLE")}}</th>
                                <th>{{__("messages.PAGE_SLUG")}}</th>
                                <th>{{__("messages.PAGE_ACTIONS")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($editWebsiteFactory->page->getPageData() as $page)
                                <tr>
                                    <td>{{$page['id']}}</td>
                                    <td>{{$editWebsiteFactory->website->domain}}</td>
                                    <td>{{$page['title']}}</td>
                                    <td>{{$page['slug']}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{route('admin.website.page.edit', ['websiteId'=>$editWebsiteFactory->website->id, 'pageId' => $page['id']])}}">
                                            {{__("messages.WEBSITE_PAGE_EDIT")}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <a href="{{route('admin.website.page.add',['websiteid' => $editWebsiteFactory->website->id])}}" class="btn btn-info btn-sm">Добавить новую страницу на сайт</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
