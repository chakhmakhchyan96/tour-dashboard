@extends('dashboard.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header white-bg border-bottom-0 mb-3">
            <a style="float: right" href="{{route('facilities.create')}}"
               class="btn btn-blue">
                <i class="fa fa-plus mr-1" aria-hidden="true"></i> {{trans('dashboard_forms.create')}}</a>

            <h2>  {{trans('dashboard_facilities.facilities')}}</h2>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 50px" class="text-center">#</th>
                        <th>{{trans('dashboard_forms.name')}}</th>
                        <th>{{trans('dashboard_forms.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($facilities as $item)
                        <tr>
                            <td class="text-center">{{$item->id}}</td>
                            <td>{{$item->data->name ?? ''}}</td>
                            <td>
                                <a href="{{route('facilities.edit',$item->id)}}" class="btn"><i
                                            class="fa fa-pencil-square-o text-dark"
                                            aria-hidden="true"></i> </a>

                                <form method="POST" action="{{ route('facilities.destroy',  $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="bg-transparent btn" title="Delete Amenities"
                                            onclick="return confirm('{{trans('dashboard_facilities.confirm_delete')}}')">
                                        <i class="fa fa-trash-o"
                                           aria-hidden="true"></i> </button>
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
