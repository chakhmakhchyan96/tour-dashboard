<style>
    .menu-color {
        background-color: #293846;
        color: white;
    }
</style>
<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

<li class="menu-color">
    <a href="#"><i class="fa fa-globe" aria-hidden="true"></i><span class="nav-label">{{trans('dashboard_navbar.tour_info')}}</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse" style="height: 0;">

        <li @if(Request::is('dashboard/facilities') || Request::is('dashboard/facilities/*') ) class="active"
            @else class="menu-color" @endif>
            <a href="/dashboard/facilities"><i class="fa fa-bath" aria-hidden="true"></i> <span class="nav-label">{{trans('dashboard_navbar.facilities')}}</span> </a>
        </li>
        <li @if(Request::is('dashboard/categories/tour') || Request::is('dashboard/categories/tour*') ) class="active"
            @else class="menu-color" @endif>
            <a href="/dashboard/categories/tour"><i class="fa fa-bar-chart" aria-hidden="true"></i>  <span class="nav-label">{{trans('dashboard_navbar.category_tour')}}</span> </a>
        </li>
        <li @if(Request::is('dashboard/tours') || Request::is('dashboard/tours/*') ) class="active"
            @else class="menu-color" @endif>
            <a href="/dashboard/tours"><i class="fa fa-plane" aria-hidden="true"></i> <span class="nav-label">{{trans('dashboard_navbar.tours')}}</span> </a>
        </li>
    </ul>
</li>
