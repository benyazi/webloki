<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                {!! $websiteFactory->menu->renderLogoBlock() !!}
            </a>
        </div>
        <div class="">
            <ul class="nav navbar-nav">
                @foreach($websiteFactory->page->getList() as $page)
                <li><a href="/{{$page->slug}}">{{$page->title}}</a></li>
                @endforeach
            </ul>
            <ul class="nav navbar-nav navbar-right">
            </ul>
        </div>
    </div>
</nav>