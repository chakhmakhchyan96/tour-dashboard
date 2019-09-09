@extends('dashboard.layouts.app')
<style>
    @media (min-width: 768px) {
        .carousel-multi-item-2 .col-md-3 {
            float: left;
            width: 25%;
            max-width: 100%;
        }
    }

    .carousel-multi-item-2 .card img {
        border-radius: 2px;
    }

</style>
@section('content')

<div class="card">
    <div class="card-header white-bg border-bottom-0 mb-3">
       <h2 class="text-center">{{trans('dashboard_tours.update_tour')}} {{$tour->id}}</h2>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @include('tour-views::tour.form')
    </div>
</div>

@endsection

