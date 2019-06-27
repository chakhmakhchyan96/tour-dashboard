@extends('dashboard.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a style="float: right" href="{{route('categories.create')}}" class="btn btn-sm btn-primary pull-right m-t-n-xs">
                            <i class="fa fa-plus" aria-hidden="true"></i>  {{trans('dashboard_forms.create')}}</a>

                        {{trans('dashboard_categories.tour_categories')}}</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('dashboard_forms.name')}}</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td> <img src="/storage/{{ $category->image }}" alt="" width="50"></td>
                                        <td>{{$category->data->name ?? ''}}</td>
                                        <th>
                                            <a href="{{route('categories.edit',$category->id)}}" class="btn-info btn btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{trans('dashboard_forms.edit')}}</a>

                                            <form method="POST" action="{{ route('categories.destroy',  $category->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn-danger btn btn-xs" title="Delete Category" onclick="return confirm('{{trans('dashboard_categories.confirm_delete')}}')">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> {{trans('dashboard_forms.delete')}}</button>
                                            </form>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
