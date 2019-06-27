@extends('dashboard.layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a style="float: right" href="{{route('tours.create')}}" class="btn btn-sm btn-primary pull-right m-t-n-xs">
                            <i class="fa fa-plus" aria-hidden="true"></i>  {{trans('dashboard_forms.create')}}</a>

                        {{trans('dashboard_tours.tours')}}
                        @if(\Illuminate\Support\Facades\Session::has('message'))
                        <div>
                            {{trans('dashboard_tours.' . \Illuminate\Support\Facades\Session::get('message'))}}
                        </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{trans('dashboard_forms.name')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tours as $tour)
                                    <tr>
                                        <td>{{$tour->data->title ?? ''}}</td>
                                        <td>
                                            <a href="{{route('tours.edit',$tour->id)}}" class="btn-info btn btn-xs">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{trans('dashboard_forms.edit')}}</a>
                                            <form method="POST" action="{{ route('tours.destroy',  $tour->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn-danger btn btn-xs" title="Delete Article" onclick="return confirm('{{trans('dashboard_tours.confirm_delete')}}')">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> {{trans('dashboard_forms.delete')}}</button>
                                            </form>
                                        </td>
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
