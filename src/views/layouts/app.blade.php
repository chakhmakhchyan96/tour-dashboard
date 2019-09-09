<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Travel dashboard - AIST Global</title>

    <link href="/css/all.css" rel="stylesheet">
    <link href="{{ asset('vendor/tour-dashboard/css/all.css') }}" rel="stylesheet">
    @yield('css')
    {{--<link href="/css/dashboard.css" rel="stylesheet">--}}
    <link href="{{ asset('vendor/tour-dashboard/css/dashboard.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

</head>

<body class="fixed-sidebar">

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">

        <div class="sidebar-collapse">
            <div class="close-btn d-md-none d-block text-white">&#10005;</div>

            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <h3>
                        <a href="/">Travel Dashboard</a>
                    </h3>

                </li>
                @include('dashboard.layouts.menu')
            </ul>

        </div>
    </nav>
    <div class="se-pre-con">
        <img src="/img/load.gif" alt="">
    </div>
    <div id="page-wrapper" class="gray-bg">

        <div class="border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation">
                <div class="navbar-header d-md-none d-block mr-auto">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>

                </div>
                <div class="nav-item dropdown language-dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{--{{ trans('dashboard_navbar.change_language') }}--}}
                        <img src="/img/eng-flag.svg" alt="">
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localCode => $langItem)
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() != $localCode)
                                <a class="dropdown-item hidden-lang" id="changeSiteLanguageLink{{$localCode}}"
                                   href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localCode, null, [], true) }}">
                                    <img src="/img/eng-flag.svg" alt=""
                                         class="mr-1"> {{trans('dashboard_navbar.' . $localCode)}}</a>
                            @endif
                        @endforeach

                    </div>
                </div>

                <div class="nav-item dropdown navbar-top-links">
                    <div class="">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block font-bold">{{Auth::user()->name}}</span>
                                {{--<span class="text-muted text-xs block">Menu <b class="caret"></b></span>--}}
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out mr-1"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="animated fadeInRight ">
            @include('flash::message')
            @yield('content')

        </div>
        <div class="footer">
        </div>

    </div>
</div>

<script src="{{ asset('vendor/tour-dashboard/js/app.js') }}"></script>
{{--<script src="/js/app.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="{{ asset('vendor/tour-dashboard/js/dashboard.js') }}"></script>
<script src="{{ asset('vendor/tour-dashboard/js/mix.js') }}"></script>
{{--<script src="/js/dashboard.js"></script>--}}
{{--<script src="/js/mix.js"></script>--}}

@yield('scripts')
<script>

    jQuery(function() {

        $('.se-pre-con').hide();
        $('body').css('overflow', 'inherit');
//        $(window).on('load', function () {
//
//            $('.se-pre-con').hide();
//            $('body').css('overflow', 'inherit');
//        });
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $(document).ready(function () {
        $('.animated-input').blur(function () {

            var $this = $(this);
            if ($this.val())
                $this.addClass('used');

            else
                $this.removeClass('used');
        });
        $('.animated-input').each(function () {
            if ($(this).val()) {
                $(this).addClass('used');

            }
        });
    });

    $('.close-btn').click(function () {

        $('body').removeClass('mini-navbar');
    });


</script>
</body>

</html>
