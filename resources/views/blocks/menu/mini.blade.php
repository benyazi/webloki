<ul class="{{$config['navClass']}}">
    @foreach($websiteFactory->page->getList() as $page)
        <li class="{{$config['itemClass']}}"><a class="{{$config['linkClass']}}" href="/{{$page->slug}}">{{$page->title}}</a></li>
    @endforeach
</ul>