@extends('dashboard.layouts.app')
<style>
    @media (min-width: 768px) {
        .carousel-multi-item-2 .col-md-3 {
            float: left;
            width: 25%;
            max-width: 100%; } }

    .carousel-multi-item-2 .card img {
        border-radius: 2px; }

</style>
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{trans('dashboard_categories.update_tour_category')}} {{$category->id}}
                        <a style="float: left" href="{{ route('categories.index') }}" title="Back"><button class="btn-white btn btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    </div>

                    <div class="card-body">

                        <form action="{{route('categories.update',$category->id)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="PATCH">
                            @include('dashboard.tour.category.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
