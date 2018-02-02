@extends('layouts.website')
@push('headCss')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">  <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="{!! $websiteFactory->getAssertPath() !!}css/bootstrap.min.css">                                      <!-- Bootstrap style -->
    <link rel="stylesheet" href="{!! $websiteFactory->getAssertPath() !!}css/templatemo-style.css">                                   <!-- Templatemo style -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
@endpush
@section('body')
    <div class="tm-header">
        <div class="container-fluid">
            <div class="tm-header-inner">
                <a href="#" class="navbar-brand tm-site-name">
                {!! $websiteFactory->menu->renderLogoBlock() !!}
            </a>

            <!-- navbar -->
            <nav class="navbar tm-main-nav">

                <button class="navbar-toggler hidden-md-up" type="button" data-toggle="collapse" data-target="#tmNavbar">
                    &#9776;
                </button>

                <div class="collapse navbar-toggleable-sm" id="tmNavbar">
                    {!! $websiteFactory->menu->render(['template' => 'mini', 'navClass' => 'nav navbar-nav', 'itemClass' => 'nav-item', 'linkClass' => 'nav-link']) !!}
                    </div>

                </nav>

            </div>
        </div>
    </div>

    <div class="tm-home-img-container" style="background-image: url({{$websiteFactory->getMediaUrlFirstFromCollection('mainImage')}});">
        <img src="{{$websiteFactory->getMediaUrlFirstFromCollection('mainImage')}}" alt="Image" class="hidden-lg-up img-fluid">
    </div>

    <section class="tm-section" id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-xs-center">
                    @yield('content')
                    {{--<h2 class="tm-gold-text tm-title">Introduction</h2>--}}
                    {{--<p class="tm-subtitle">Suspendisse ut magna vel velit cursus tempor ut nec nunc. Mauris vehicula, augue in tincidunt porta, purus ipsum blandit massa.</p>--}}
                </div>
            </div>
            <div class="row">
                @foreach($websiteFactory->getServices() as $item)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">

                    <div class="tm-content-box">
                        <img src="{!! $websiteFactory->getMediaUrl($item->media_id) !!}" alt="Image" class="tm-margin-b-20 img-fluid">
                        <h4 class="tm-margin-b-20 tm-gold-text">{{$item->title}}</h4>
                        <p class="tm-margin-b-20">{{$item->description}}</p>
                    </div>

                </div>
                @endforeach
            </div> <!-- row -->

        </div>
    </section>

    <footer class="tm-footer">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="tm-footer-content-box tm-footer-links-container">

                        <h3 class="tm-gold-text tm-title tm-footer-content-box-title">Наши услуги</h3>
                        <nav>
                            <ul class="nav">
                                @foreach($websiteFactory->getServices() as $item)
                                <li><a href="" class="tm-footer-link">{{$item->title}}</a></li>
                                @endforeach
                            </ul>
                        </nav>

                    </div>

                </div>
                <div class="clearfix hidden-lg-up"></div>

                <div class="col-xs-12 col-sm-6 col-md-6">

                    <div class="tm-footer-content-box">
                        <h3 class="tm-gold-text tm-title tm-footer-content-box-title">Последние фотографии</h3>
                        <div class="tm-margin-b-30">
                            @foreach($websiteFactory->getRandomImages() as $item)
                                <div class="tm-footer-content-box-image">
                                    <img src="{{$item->getUrl()}}" alt="Image" class="tm-footer-thumbnail">
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>


            </div>

            <div class="row">
                <div class="col-xs-12 tm-copyright-col">
                    <p class="tm-copyright-text">&copy;{!! date('Y') !!} {{$websiteFactory->website->name}}</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- load JS files -->
    <script src="{!! $websiteFactory->getAssertPath() !!}js/jquery-1.11.3.min.js"></script>             <!-- jQuery (https://jquery.com/download/) -->
    <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script> <!-- Tether for Bootstrap, http://stackoverflow.com/questions/34567939/how-to-fix-the-error-error-bootstrap-tooltips-require-tether-http-github-h -->
    <script src="{!! $websiteFactory->getAssertPath() !!}js/bootstrap.min.js"></script>                 <!-- Bootstrap (http://v4-alpha.getbootstrap.com/) -->
@endsection