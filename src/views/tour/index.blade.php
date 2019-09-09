@extends('dashboard.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header white-bg border-bottom-0 mb-3">
            <a style="float: right" href="{{route('tours.create')}}" class="btn btn-blue">
                <i class="fa fa-plus mr-1" aria-hidden="true"></i>  {{trans('dashboard_forms.create')}}</a>

            <h2>{{trans('dashboard_tours.tours')}}</h2>
            @if(\Illuminate\Support\Facades\Session::has('message'))
            <div class="success-message">
                {{trans('dashboard_tours.' . \Illuminate\Support\Facades\Session::get('message'))}}
            </div>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-layout">
                    <thead>
                    <tr>
                        <th>{{trans('dashboard_forms.name')}}</th>
                        <th>{{trans('dashboard_forms.category')}}</th>
                        <th>{{trans('dashboard_forms.link')}}</th>
                        <th>{{trans('dashboard_forms.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tours as $tour)
                        <tr>
                            <td>{{$tour->data->title ?? ''}}</td>
                            <td>
                                @foreach($tour->category as $item)
                                    {{$item->data->name ?? ''}}
                                    @if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td></td>
                            <td>
                                <a href="{{route('tours.edit',$tour->id)}}" class="btn">
                                    <i class="fa fa-pencil-square-o text-dark " aria-hidden="true"></i> </a>
                                <form method="POST" action="{{ route('tours.destroy',  $tour->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="bg-transparent btn" title="Delete Article" onclick="return confirm('{{trans('dashboard_tours.confirm_delete')}}')">
                                        <i class="fa fa-trash-o text-dark " aria-hidden="true"></i> </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
