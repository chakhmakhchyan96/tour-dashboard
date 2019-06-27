
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <h2>
                    {{trans('dashboard_tours.create_tour')}}
                </h2>
                <div id="form" action="#" class="wizard-big">
                    <h1>{{trans('dashboard_tours.tour_information')}}</h1>
                    <fieldset>
                        <h2>{{trans('dashboard_tours.tour_information')}}</h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <form  action="{{route('tours.store')}}" id="tourInfoForm" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <hr>
                                    @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h3>{{trans('dashboard_tours.tour')}}</h3>

                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                @foreach($languages as $key => $value)
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($key=='en') active @endif" data-toggle="tab"
                                                           href="#title{{$key}}" aria-controls="title{{$key}}"
                                                           aria-selected="true">{{trans('dashboard_forms.' . $key)}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach($languages as $key => $value)
                                                    <div class="tab-pane fade @if($key=='en') show active @endif" role="tabpanel"
                                                         id="title{{$key}}" aria-labelledby="profile-tab" >
                                                        <div class="row" style="margin-top: 10px">
                                                            <div class="col-sm-2 text-left" style="font-weight: bold">
                                                                {{trans('dashboard_forms.title')}}
                                                            </div>
                                                            <div class="col-sm-10">

                                                                <input class="form-control required {{$errors->has("title_$key")? "is-invalid" : ""}}" type="text" name="title_{{$key}}"
                                                                       value="{{old("title_$key") ? old("title_$key") : (isset($tour->data[$key]['title']) ?  $tour->data[$key]['title'] : '')}}">
                                                            </div>
                                                        </div>

                                                        <div class="row" style="margin-top: 10px">
                                                            <div class="col-sm-2 text-left" style="font-weight: bold">
                                                                {{trans('dashboard_forms.content')}}
                                                            </div>
                                                            <div class="col-sm-10">

                                            <textarea class="form-control {{$errors->has("content_$key")? "is-invalid" : ""}}" type="text" id="content_{{$key}}" name="content_{{$key}}"
                                            >{{old("content_$key") ? old("content_$key") : (isset($tour->data[$key]['content']) ?  $tour->data[$key]['content'] : '')}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-2 text-left" style="font-weight: bold">{{trans('dashboard_forms.category')}}</div>
                                        <div class="col-sm-10">
                                            <select class="form-control categories" name="category[]" multiple="multiple">
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}"
                                                            @if(isset($tour) && count($tour->category) > 0 && in_array($category->id, $tour->category()->pluck('category_id')->toArray()))
                                                            selected @elseif(old('category') &&  in_array($category->id,old('category'))) selected @endif>{{$category->data->name ?? ''}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-top: 10px">
                                        <div class="col-sm-2 text-left" style="font-weight: bold">
                                            {{trans('dashboard_forms.price')}}
                                        </div>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="number" name="price" value="{{old("price") ? old("price") : (isset($tour->price) ?  $tour->price : '')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-top: 10px">
                                        <div class="col-sm-2 text-left" style="font-weight: bold">
                                            {{trans('dashboard_forms.age_from')}}
                                        </div>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="number" name="age_from" value="{{old("age_from") ? old("age_from") : (isset($tour->age_from) ?  $tour->age_from : '')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 text-left" style="font-weight: bold">{{trans('dashboard_forms.status')}}</div>
                                        <div class="col-sm-10">
                                            <div class="radio" style="float:left">
                                                <label><input name="status" type="radio"
                                                              value="1" @if(isset($tour) && $tour->status) checked @elseif(old('tour.status') && old('tour.status')==1) checked @endif> {{trans('dashboard_forms.active')}}</label>
                                            </div>
                                            <div class="radio" style="float:left;margin-left:20px">
                                                <label><input name="status" type="radio"
                                                              value="0" @if(isset($tour) && $tour->status != 1) checked @elseif((old('tour.status') && old('tour.status')== 0) || (!isset($tour) && !old('tour.status'))) checked @endif>
                                                    {{trans('dashboard_forms.inactive')}}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 text-left" style="font-weight: bold">{{trans('dashboard_forms.image')}}</div>
                                        <div class="col-sm-10 text-right">
                                            <input class="form-control" type="file" name="image" id="image">
                                            @if(isset($tour->images['image'][0]->path))
                                                <img class="mt-2" src="{{$tour->images['image'][0]->path}}" width="100">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 text-left" style="font-weight: bold">{{trans('dashboard_forms.background_image')}}</div>
                                        <div class="col-sm-10 text-right">
                                            <input class="form-control" type="file" name="background_image" id="background_image">
                                            @if(isset($tour->images['background_image'][0]->path))
                                                <img class="mt-2" src="{{$tour->images['background_image'][0]->path}}" width="100">
                                            @endif
                                        </div>
                                    </div>

                                    {{--<div class="form-group">--}}
                                        {{--<input type="submit" style="float: right;background-color:green;" class="btn-success" value="{{trans('dashboard_forms.next')}}">--}}
                                    {{--</div>--}}
                                </form>
                            </div>
                        </div>

                    </fieldset>
                    <h1>{{trans('dashboard_tours.tour_included')}}</h1>
                    <fieldset>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h3>{{trans('dashboard_forms.tour_included')}}</h3>
                                <table id="included-table" class="table table-hover">
                                    <tbody>
                                    @if(isset($tour->allIncluded))
                                        @foreach($tour->allIncluded as $included)
                                            <tr>
                                                <td id="editTourIncludedTd{{$included->id}}">{{$included->text}}</td>
                                                <td>{{trans('dashboard_forms.' . $included->language) ?? ''}}</td>
                                                <td class="text-right">
                                                    <button class='btn-info btn btn-xs' id='editTourIncludedButton{{$included->id}}' onclick='editTourIncluded(this)'
                                                            data-value='{{$included->text}}' data-id='{{$included->id}}'>
                                                        <i class='fa fa-pencil-square-o' aria-hidden='true'></i> {{trans('dashboard_forms.edit')}}
                                                    </button>
                                                    <button type="button" class="btn-danger btn btn-xs delete-included" onclick="deleteIncluded(this)"
                                                            title="Delete" data-id="{{$included->id}}">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i> {{trans('dashboard_forms.delete')}}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h3>{{trans('dashboard_tours.add_tour_included')}}</h3>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-outline-success btn-lg" style="width: 200px"
                                        data-toggle="modal" data-target="#addTourIncludedModal">{{trans('dashboard_forms.add')}}
                                </button>
                                <div class="modal" id="addTourIncludedModal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{trans('dashboard_tours.add_tour_included')}}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form class="form-horizontal" id="tourIncludedForm">
                                                    @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">

                                                            @foreach($languages as $key => $val)
                                                                <div id="titleIncluded{{$key}}" aria-labelledby="profile-tab">

                                                                    <div class="row" style="margin-top: 10px">
                                                                        <div class="col-sm-2 text-left" style="font-weight: bold">
                                                                            {{trans('dashboard_forms.text')}} {{trans('dashboard_forms.' . $key)}}
                                                                        </div>
                                                                        <div class="col-sm-10">
                                                                            <input class="form-control" type="text" name="text_{{$key}}">
                                                                        </div>
                                                                    </div>
                                                                    <hr>

                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="button" style="float: right;"
                                                                   class="btn btn-outline-success" value="{{trans('dashboard_forms.submit')}}"
                                                                   onclick="storeTourIncluded()">

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal" id="editTourIncludedModal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{trans('dashboard_tours.add_tour_included')}}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form class="form-horizontal" id="editTourIncludedForm">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">

                                                            <div id="titleIncludedEdit" aria-labelledby="profile-tab">

                                                                <div class="row" style="margin-top: 10px">
                                                                    <div class="col-sm-2 text-left" style="font-weight: bold">
                                                                        {{trans('dashboard_forms.text')}}
                                                                    </div>
                                                                    <div class="col-sm-10">
                                                                        <input class="form-control" id="editTourIncludedTextInput" type="text" name="text">
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="button" style="float: right;" id="editTourIncludedSubmitButton"
                                                                   class="btn btn-outline-success" value="{{trans('dashboard_forms.submit')}}"
                                                                   onclick="updateTourIncluded(this)">

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <h1>{{trans('dashboard_tours.tour_plan')}}</h1>
                    <fieldset>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h3>Tour Days</h3>
                                <table id="tour-days-table" class="table table-hover">
                                    <tbody>
                                    @if(isset($tour->allPlanDays))
                                        @foreach($tour->allPlanDays as $item)
                                            <tr>
                                                <td> {{$item->data['en']->title ?? ""}}</td>
                                                <td class='text-right'>
                                                    <button class='btn-info btn btn-xs' id = "editTourPlanDayButton{{$item->id}}" onclick='editTourPlanDay(this)'  data-info='{{json_encode($item->data)}}'>
                                                        <i class='fa fa-pencil-square-o' aria-hidden='true'></i> {{trans('dashboard_forms.edit')}}
                                                    </button>
                                                    <button type='button' class='btn-danger btn btn-xs delete-feature' title='Delete' onclick='deletePlanDay(this)' data-id='{{$item->id}}'>
                                                        <i class='fa fa-trash-o' aria-hidden='true'></i> {{trans('dashboard_forms.delete')}}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <form id="tourPlanForm" class="form-horizontal" enctype="multipart/form-data">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <ul class="nav nav-tabs" id="tourPlanTab" role="tablist">
                                        @foreach($languages as $key => $value)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key=='en') active @endif" data-toggle="tab"
                                                   href="#tourPlan{{$key}}" aria-controls="title{{$key}}"
                                                   aria-selected="true">{{trans('dashboard_forms.' . $key)}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach($languages as $key => $value)
                                            <div class="tab-pane fade @if($key=='en') show active @endif" role="tabpanel"
                                                 id="tourPlan{{$key}}" aria-labelledby="profile-tab">
                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-sm-2 text-left" style="font-weight: bold">
                                                        {{trans('dashboard_forms.description')}}
                                                    </div>
                                                    <div class="col-sm-10">

                                            <textarea class="form-control {{$errors->has("description_$key")? "is-invalid" : ""}}"  id="plan_description_{{$key}}"  rows="4" type="text" name="description_{{$key}}"
                                            >{{$tour->plan[$key]['description'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-outline-success btn-lg" style="width: 200px" onclick="submitTourPlan(false)"
                                        data-toggle="modal" data-target="#addTourPlanDayModal">{{trans('dashboard_tours.add_tour_plan_day')}}
                                </button>
                                <div class="modal" id="addTourPlanDayModal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{trans('dashboard_tours.add_tour_plan_day')}}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form class="form-horizontal" id="tourPlanDayForm">
                                                    @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">

                                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                @foreach($languages as $key => $val)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link @if($key == 'en') active @endif" data-toggle="tab"
                                                                           href="#sectionTourPlanDay{{$key}}" aria-controls="titleIncluded{{$key}}"
                                                                           aria-selected="true">{{trans('dashboard_forms.' . $key)}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach($languages as $key => $val)
                                                                    <div class="tab-pane fade @if($key == 'en') show active @endif" role="tabpanel"
                                                                         id="sectionTourPlanDay{{$key}}" aria-labelledby="profile-tab">

                                                                        <div class="row" style="margin-top: 10px">
                                                                            <div class="col-sm-2 text-left" style="font-weight: bold">
                                                                                {{trans('dashboard_forms.title')}}
                                                                            </div>
                                                                            <div class="col-sm-10">
                                                                                <input class="form-control" id="tourPlanDayFeatureTitle{{$key}}" type="text" name="title_{{$key}}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="row" style="margin-top: 10px">
                                                                            <div class="col-sm-2 text-left" style="font-weight: bold">
                                                                                {{trans('dashboard_forms.description')}}
                                                                            </div>
                                                                            <div class="col-sm-10">
                                                                                <textarea class="form-control" type="text" id="tourPlanDayFeatureDescription{{$key}}" name="description_{{$key}}"></textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row tourPlanDayFeatureDiv" style="margin-top: 10px">
                                                                            <div class="col-sm-2 text-left" style="font-weight: bold">
                                                                                {{trans('dashboard_forms.feature')}}
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <input class="form-control" type="text" name="feature_text_{{$key}}[]">
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <button class='btn-danger btn btn-xs delete-feature' onclick="removeTourPlanDayFeatureRow(this)"> {{trans('dashboard_forms.delete_row')}} </button>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <input type="button" style="float: right;"
                                                                   class="btn btn-outline-success" value="{{trans('dashboard_tours.add_tour_day_feature')}}"
                                                                   onclick="addTourPlanDayFeature()">

                                                        </div><div class="col-sm-8">
                                                            <input type="button" style="float: right;" id="storeTourPlanDayButton"
                                                                   class="btn btn-outline-success" value="{{trans('dashboard_forms.submit')}}"
                                                                   onclick="storeTourPlanDay()">

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <h1>{{trans('dashboard_tours.tour_location')}}</h1>
                    <fieldset>
                        <hr>
                        <form id="tourLocationForm">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <h3>{{trans('dashboard_tours.tour_location')}}</h3>

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach($languages as $key => $value)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key=='en') active @endif" data-toggle="tab"
                                                   href="#titleLocation{{$key}}" aria-controls="title{{$key}}"
                                                   aria-selected="true">{{trans('dashboard_forms.' . $key)}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach($languages as $key => $value)
                                            <div class="tab-pane fade @if($key=='en') show active @endif" role="tabpanel"
                                                 id="titleLocation{{$key}}" aria-labelledby="profile-tab">
                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-sm-2 text-left" style="font-weight: bold">
                                                        {{trans('dashboard_forms.short_description')}}
                                                    </div>
                                                    <div class="col-sm-10">
                                        <textarea class="form-control" type="text" name="short_description_{{$key}}"
                                        >{{ $tour->location[$key]['short_description'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-sm-2 text-left" style="font-weight: bold">
                                                        {{trans('dashboard_forms.description')}}
                                                    </div>
                                                    <div class="col-sm-10">
                                        <textarea class="form-control {{$errors->has("description_$key")? "is-invalid" : ""}}" type="text" id="location_description_{{$key}}"
                                                  name="description_{{$key}}">{{ $tour->location[$key]['description'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-2 text-left" style="font-weight: bold">
                                    {{trans('dashboard_forms.map')}}
                                </div>
                                <div class="col-sm-10">

                                    <input class="form-control {{$errors->has("map")? "is-invalid" : ""}}" type="text" name="map"
                                           value="{{ $tour->map ?? '' }}">
                                </div>
                            </div>
                        </form>
                    </fieldset>
                    <h1>{{trans('dashboard_tours.tour_gallery')}}</h1>
                    <fieldset>

                        <hr>
                        <form id="tourGalleryForm">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <h3>{{trans('dashboard_tours.tour_gallery')}}</h3>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach($languages as $key => $value)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key=='en') active @endif" data-toggle="tab"
                                                   href="#titleGallery{{$key}}" aria-controls="title{{$key}}"
                                                   aria-selected="true">{{trans('dashboard_forms.' . $key)}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach($languages as $key => $value)
                                            <div class="tab-pane fade @if($key=='en') show active @endif" role="tabpanel"
                                                 id="titleGallery{{$key}}" aria-labelledby="profile-tab">
                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-sm-2 text-left" style="font-weight: bold">
                                                        {{trans('dashboard_forms.text')}}
                                                    </div>
                                                    <div class="col-sm-10">
                                                <textarea class="form-control" type="text" name="gallery_text_{{$key}}"
                                                >{{$tour->data[$key]['gallery_text'] ?? ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-2 text-left" style="font-weight: bold">{{ trans('dashboard_forms.images') }}</div>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="galleryImagesInput" name="gallery_images[]" multiple="multiple">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div  class="col-sm-12" id="galleryContainerDiv">
                                    @if(isset($tour['images']['gallery']))
                                        @foreach($tour['images']['gallery'] as $item)
                                            <span>
                                <img src="{{$item->path}}" height='200'>
                                <button type='button' onclick='deleteImage(this)' data-id = "{{$item->id}}">{{trans('dashboard_forms.delete')}}</button>
                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </form>
                    </fieldset>
                    <h1>{{trans('dashboard_tours.tour_meta')}}</h1>
                    <fieldset>
                        <hr>
                        <form action="/dashboard/tour-meta" id="tourMetaForm" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-2 text-left" style="font-weight: bold">{{trans('dashboard_forms.meta_image')}}</div>
                                <div class="col-sm-10 text-right">
                                    <input class="form-control" type="file" name="meta_image" id="image">
                                    @if(isset($tour->images['meta_image'][0]->path) && $tour->images['meta_image'][0]->path)
                                        <img class="mt-2" src="{{$tour->images['meta_image'][0]->path}}" width="100">
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach($languages as $key => $value)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key=='en') active @endif" data-toggle="tab"
                                                   href="#meta{{$key}}" aria-controls="meta{{$key}}"
                                                   aria-selected="true">{{trans('dashboard_forms.' . $key)}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach($languages as $key => $value)
                                            <div class="tab-pane fade @if($key=='en') show active @endif" role="tabpanel"
                                                 id="meta{{$key}}" aria-labelledby="profile-tab">

                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-sm-2 text-left" style="font-weight: bold">
                                                        {{trans('dashboard_forms.meta_title')}}
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <input class="form-control {{$errors->has("meta_title_$key")? "is-invalid" : ""}}" type="text" name="meta_title_{{$key}}"
                                                               value="{{$tour->data[$key]['meta_title'] ??  ''}}">
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-sm-2 text-left" style="font-weight: bold">
                                                        {{trans('dashboard_forms.meta_description')}}
                                                    </div>
                                                    <div class="col-sm-10">
                                        <textarea class="form-control {{$errors->has("meta_description_$key")? "is-invalid" : ""}}" type="text" name="meta_description_{{$key}}"
                                        >{{$tour->data[$key]['meta_description'] ?? ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-sm-2 text-left" style="font-weight: bold">
                                                        {{trans('dashboard_forms.meta_keywords')}}
                                                    </div>
                                                    <div class="col-sm-10">
                                        <textarea class="form-control {{$errors->has("meta_keywords_$key") ? "is-invalid" : ""}}" type="text" name="meta_keywords_{{$key}}"
                                        >{{$tour->data[$key]['meta_keywords'] ?? ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

</div>

@section('css')

    <link href="/css/jquery.steps.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="/js/jquery.steps.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
    <script>

        $(document).ready(function(){

            $("#form").steps({
                bodyTag: "fieldset",
                @if(isset($tour))
                    enableAllSteps: true,
                @endif
                labels: {
                    finish: "{{trans('dashboard_forms.finish')}}",
                    next: "{{trans('dashboard_forms.next')}}",
                    previous: "{{trans('dashboard_forms.previous')}}"
                },
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    switch (currentIndex) {
                        case 0:
                            var form = $('#tourInfoForm');
                            if (form.valid()) {
                                submitTourInformation();
                            }
                            return form.valid();
                            break;
                        case 1:

                        case 2:
                            submitTourPlan(true);
                            break;
                        case 3:
                            submitTourLocation();
                            break;
                        case 4:
                            storeTourGallery(true);
                            break;
                        case 5:
                            storeTourMeta();
                            break;
                    }
                    if (currentIndex < newIndex)
                    {
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    return true;

                },
                onFinished: function (event, currentIndex)
                {
                    $('.loader').show();
                    var form = $("#tourMetaForm");
                    form.submit();
                }
            }).validate({
                errorPlacement: function (error, element) {
                    element.before(error);
                },
                rules: {
                    confirm: {
                        equalTo: "#password"
                    }
                }
            });

            $('.categories').select2({
                minimumSelectionLength: 1

            });

            $("#tourInfoForm").validate({
                ignore: "",
                rules: {
                    @foreach($languages as $key => $value)
                        title_{{$key}}: "required",
                    @endforeach
                },
                {{--messages: {--}}
                        {{--@foreach($languages as $key => $value)--}}
                        {{--title_{{$key}}: "Test is Required",--}}
                        {{--@endforeach--}}
                        {{--},--}}
                invalidHandler: function() {
                    setTimeout(function() {
                        $('.nav-tabs a small').remove();

                        var validatePane = $('.tab-content .tab-pane:has(input.error)').each(function() {
                            var id = $(this).attr('id');
                            $('.nav-tabs').find('a[href^="#' + id + '"]').append('<small style="color:#f00;">***</small>');
                        });
                    });
                },
                submitHandler: function (form) {
                    submitTourInformation();
                }
            });
            $('#galleryImagesInput').on('change', function(){
                storeTourGallery(false);
            });

            @foreach($languages as $key => $value)

                var contentEditor{{$key}};
                var planDescriptionEditor{{$key}};
                var locationDescriptionEditor{{$key}};

                    ClassicEditor.create( document.querySelector('#content_' + '{{$key}}')).then( editor => {
                        contentEditor{{$key}} = editor;
                });
                    ClassicEditor.create( document.querySelector('#plan_description_' + '{{$key}}')).then( editor => {
                        planDescriptionEditor{{$key}} = editor;
                });
                    ClassicEditor.create( document.querySelector('#location_description_' + '{{$key}}')).then( editor => {
                        locationDescriptionEditor{{$key}} = editor;
                });
            @endforeach

            function submitTourInformation() {

                $('.loader').show();
                @foreach($languages as $key => $value)
                $('#content_{{$key}}').val(contentEditor{{$key}}.getData());
                        @endforeach

                var formData = new FormData(document.getElementById('tourInfoForm'));

                $('.nav-tabs a[href="#tourIncluded"]').tab('show');
                $.ajax({
                    type: "POST",
                    url: "{{route('tours.store')}}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (data) {

                        $('.nav-tabs a small').remove();
                        var el = '<input type="hidden" name="tour_id" value="' + data.tour_id + '">';
                        $('#dynamic-form').append(el);
                        var myforms = $("form");
                        myforms.each(function (i) {
                            myforms.eq(i).append(el);
                        });
                        $('.loader').hide();
                    },
                    error: function (error) {

                        $('.loader').hide();
                    }
                });
            }

            function submitTourPlan(isNextButton) {

                $('.loader').show();
                $("#tourPlanDayFormIdInput").remove();
                $("#tourPlanDayForm").find('input[type=text], textarea').val('');
                if (isNextButton) {

                    $('.nav-tabs a[href="#tourLocation"]').tab('show');
                }
                @foreach($languages as $key => $value)
                    $('#plan_description_{{$key}}').val(planDescriptionEditor{{$key}}.getData());
                @endforeach

                $.ajax({
                    type: "POST",
                    url: "/dashboard/tour-plan",
                    data: $("#tourPlanForm").serialize(),
                    success: function (data) {

                        $('.loader').hide();
                    },
                    error: function (error) {

                        $('.loader').hide();
                    }
                });
            }
            function submitTourLocation() {

                $('.loader').show();
                @foreach($languages as $key => $value)
                    $('#location_description_{{$key}}').val(locationDescriptionEditor{{$key}}.getData());
                @endforeach

                $('.nav-tabs a[href="#tourGallery"]').tab('show');
                $.ajax({
                    type: "POST",
                    url: "/dashboard/tour-location",
                    data: $("#tourLocationForm").serialize(),
                    success: function (data) {

                        $('.loader').hide();
                    },
                    error: function (error) {

                        $('.loader').hide();
                    }
                });
            }
        });

        function addTourPlanDayFeature() {
            var code;
            @foreach($languages as $key => $val)
                code = '<div class="row tourPlanDayFeatureDiv" style="margin-top:10px">' +
                '<div class="col-sm-2 text-left" style="font-weight: bold">{{trans('dashboard_forms.feature')}}</div> <div class="col-sm-8">' +
                '<input class="form-control" type="text" name="feature_text_{{$key}}[]"> </div> <div class="col-sm-1">' +
                '<button class="btn-danger btn btn-xs delete-feature" onclick="removeTourPlanDayFeatureRow(this)">{{trans('dashboard_forms.delete_row')}}</button>' +
                '</div> </div>';
            $('#sectionTourPlanDay{{$key}}').append(code);
            @endforeach
        }

        function editTourPlanDay(thisButton) {

            var data = JSON.parse($(thisButton).attr('data-info'));
            $( ".tourPlanDayFeatureDiv" ).remove();
            $( "#tourPlanDayFormIdInput" ).remove();
            var featureHtml = '';
            $("#tourPlanDayForm").append("<input type='hidden' id='tourPlanDayFormIdInput' name='tour_plan_day_id' value='"+ data.en.tour_plan_day_id +"'>");
            $.each(data, function (index, value) {

                $('#tourPlanDayFeatureTitle' + index).val(value.title);
                $('#tourPlanDayFeatureDescription' + index).val(value.description);
                $.each(value.feature, function (indexFeature, valueFeature) {
                    featureHtml = "<div class='row tourPlanDayFeatureDiv' style='margin-top:10px'>" +
                        "<div class='col-sm-2 text-left' style='font-weight:bold'>{{trans('dashboard_forms.feature')}}</div>" +
                        "<div class='col-sm-8'>" +
                        "<input class='form-control' type='text' value='" + valueFeature.text + "' name='feature_text_" + index + "[]'>" +
                        "</div>" +
                        "<div class='col-sm-1'>" +
                        "<button class='btn-danger btn btn-xs delete-feature' onclick='removeTourPlanDayFeatureRow(this)'> {{trans('dashboard_forms.delete_row')}} </button>" +
                        "</div> </div>";
                    $('#sectionTourPlanDay' + index).append(featureHtml);
                });
            });

            $('#addTourPlanDayModal').modal('show');
        }

        function editTourIncluded(thisButton) {

            $('#editTourIncludedTextInput').val($(thisButton).attr('data-value'));
            $('#editTourIncludedSubmitButton').attr('data-id', $(thisButton).attr('data-id'));


            $('#editTourIncludedModal').modal('show');
        }

        function updateTourIncluded(thisButton) {

            $('.loader').show();
            $.ajax({
                type: 'PUT',
                url: '/dashboard/tour-included/' + $(thisButton).attr('data-id'),
                data: $("#editTourIncludedForm").serialize(),
                success: function (data) {
                    var code = "";
                    $.each(data, function(index, value) {

                        $('#editTourIncludedButton' + index).attr('data-value', value.text);
                        $('#editTourIncludedTd' + index).text(value.text);
                        $('.loader').hide();
                    });

                    $('#editTourIncludedModal').modal('toggle');
                },
                error: function (error) {
                    $('.loader').hide();
                }
            });

            $('#editTourIncludedModal').modal('show');
        }

        function storeTourIncluded(index) {

            $('.loader').show();
            $.ajax({
                type: 'POST',
                url: '/dashboard/tour-included',
                data: $("#tourIncludedForm").serialize(),
                success: function (data) {
                    var code = "";
                    $.each(data, function(index, value) {

                        code = code + '<tr>' +
                            '<td id="editTourIncludedTd' + index + '">' + value.text + '</td>' +
                            '<td>' + value.languageDisplayName + '</td>' +
                            '<td class="text-right">' +
                            '<button class="btn-info btn btn-xs" id="editTourIncludedButton' + index +
                            '" onclick="editTourIncluded(this)"  data-value="' + value.text + '" data-id="' + value.id + '">' +
                            ' <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  {{trans('dashboard_forms.edit')}}' +
                            '</button> ' +
                            '<button type="button" class="btn-danger btn btn-xs delete-included"  onclick="deleteIncluded(this)" data-id="' + index + '">' +
                            ' <i class="fa fa-trash-o" aria-hidden="true"></i> {{trans('dashboard_forms.delete')}}' +
                            '</button></td></tr>';
                    });

                    $('#included-table tbody').append(code);
                    $('#tourIncludedForm').find('input[type=text]').val('');
                    $('#addTourIncludedModal').modal('toggle');
                    $('.loader').hide();
                },
                error: function (error) {

                    $('.loader').hide();
                }
            });
        }

        function storeTourPlanDay() {

            $('.loader').show();
            $.ajax({
                type: 'POST',
                url: '/dashboard/tour-plan-day',
                data: $("#tourPlanDayForm").serialize(),
                success: function (data) {

                    if (data.isEdit) {

                        $('#editTourPlanDayButton' + data.data.en.tour_plan_day_id).attr('data-info', JSON.stringify(data.data));
                    } else {

                        var code = "<tr>" +
                            "<td>" + data.data.en.title + "</td>" +
                            "<td class='text-right'>" +
                            "<button class='btn-info btn btn-xs' id='editTourPlanDayButton" + data.data.en.tour_plan_day_id +
                            "' onclick='editTourPlanDay(this)'  data-info='" + JSON.stringify(data.data) + "'>" +
                            "<i class='fa fa-pencil-square-o' aria-hidden='true'></i> {{trans('dashboard_forms.edit')}}" +
                            "</button> " +
                            "<button type='button' class='btn-danger btn btn-xs delete-feature' title='Delete' onclick='deletePlanDay(this)' data-id='" + data.data.en.tour_plan_day_id + "'>" +
                            "<i class='fa fa-trash-o' aria-hidden='true'></i> {{trans('dashboard_forms.delete')}}" +
                            "</button>" +
                            "</td>" +
                            "</tr>";

                        $('#tour-days-table tbody').append(code);
                        $('.loader').hide();
                    }

                    $('#addTourPlanDayModal').modal('hide');
                    $('.loader').hide();


                },
                error: function (error) {

                }
            });
        }

        function storeTourGallery(isNextButton) {

            $('.loader').show();
            if (isNextButton) {
                $('.nav-tabs a[href="#tourMeta"]').tab('show');
            }

            var formData = new FormData(document.getElementById('tourGalleryForm'));

            $.ajax({
                type: "POST",
                url: "/dashboard/tour-gallery",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {

                    $('#galleryImagesInput').val('');
                    var html = '';
                    $.each(data, function (index, value) {

                        html = html + "<span>" +
                            "<img src=" + value.path + " height='200'>" +
                            "<button type='button' onclick='deleteImage(this)' data-id = " + value.id + "> {{trans('dashboard_forms.delete')}} </button>" +
                            "</span>"
                    });

                    $('#galleryContainerDiv').append(html);
                    $('.loader').hide();
                },
                error: function (error) {

                    $('.loader').hide();
                }
            });
        }

        function storeTourMeta() {

            $('.loader').show();
            var formData = new FormData(document.getElementById('tourMetaForm'));

            $.ajax({
                type: "POST",
                url: "/dashboard/tour-meta",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {

                    $('.loader').hide();
                },
                error: function (error) {

                    $('.loader').hide();
                }
            });
        }

        function deleteIncluded(thisButton) {

            $('.loader').show();
            $.ajax({
                type: "DELETE",
                url: "/dashboard/tour-included/" + thisButton.getAttribute("data-id"),
                success: function (data) {

                    $('.loader').hide();
                    $(thisButton).parent().parent().remove();
                },
                error: function (error) {

                    $('.loader').hide();
                }
            });
        }

        function deleteImage(thisButton) {

            $('.loader').show();
            $.ajax({
                type: "DELETE",
                url: "/dashboard/image/" + thisButton.getAttribute("data-id"),
                success: function (data) {

                    $(thisButton).parent().remove();
                    $('.loader').hide();
                },
                error: function (error) {

                    $('.loader').hide();
                }
            });
        }

        function deletePlanDay(thisButton) {

            $('.loader').show();
            $.ajax({
                type: "DELETE",
                url: "/dashboard/tour-plan-day/" + thisButton.getAttribute("data-id"),
                success: function (data) {

                    $(thisButton).parent().parent().remove();
                    $('.loader').hide();
                },
                error: function (error) {

                    $('.loader').hide();
                }
            });
        }

        function removeTourPlanDayFeatureRow(thisButton) {

            $(thisButton).parent().parent().remove();
        }
    </script>
@endsection