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
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{trans('dashboard_tours.update_tour')}} {{$tour->id}}
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @include('dashboard.tour.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

