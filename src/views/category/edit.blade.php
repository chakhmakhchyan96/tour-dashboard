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
    <div class="card">
        <div class="card-header white-bg border-bottom-0 mb-3">

            <a  href="/dashboard/categories/{{$category->type}}" title="Back" class="btn btn-outline-primary"> <i class="fa fa-arrow-left mr-1" aria-hidden="true"></i> {{trans('dashboard_forms.back')}}</a>
        </div>
        <h2 class="text-center">{{trans('dashboard_categories.update_' . $category->type . '_category')}} {{$category->id}}</h2>
        <div class="card-body">
            <form action="{{route('categories.update',$category->id)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input name="_method" type="hidden" value="PATCH">
                @include('tour-views::category.form')

            </form>
        </div>
    </div>
@endsection
