<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <div id="formTourInfo" class="wizard-big">
                    <h1>{{trans('dashboard_tours.tour_information')}}</h1>
                    <fieldset>
                        <p class="text">{{trans('dashboard_tours.tour_information_help')}}</p>
                        <div class="row">
                            <div class="col-lg-12">
                                <form  action="{{route('tours.store')}}" id="tourInfoForm" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div>
                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        @foreach($languages as $key => $value)
                                                            <li class="nav-item">
                                                                <a class="nav-link @if($key=='en') active @endif"
                                                                   data-toggle="tab"
                                                                   href="#title{{$key}}" aria-controls="title{{$key}}"
                                                                   aria-selected="true">{{trans('dashboard_forms.' . $key)}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content">
                                                        @foreach($languages as $key => $value)
                                                            <div class="tab-pane fade @if($key=='en') show active @endif"
                                                                 role="tabpanel"
                                                                 id="title{{$key}}" aria-labelledby="profile-tab">
                                                                <div class="row">
                                                                    <div class="col-xl-12 input-field">
                                                                        <input class="form-control required animated-input {{$errors->has("title_$key")? "is-invalid" : ""}}"
                                                                               type="text" name="title_{{$key}}"
                                                                               value="{{old("title_$key") ? old("title_$key") : (isset($tour->data[$key]['title']) ?  $tour->data[$key]['title'] : '')}}">
                                                                        <label class="animated-label"> {{trans('dashboard_forms.title')}}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        {{trans('dashboard_forms.content')}}
                                                                        <textarea class="form-control {{$errors->has("content_$key")? "is-invalid" : ""}}"
                                                                                type="text" id="content_{{$key}}"
                                                                                name="content_{{$key}}"
                                                                        >{{old("content_$key") ? old("content_$key") : (isset($tour->data[$key]['content']) ?  $tour->data[$key]['content'] : '')}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 margin">
                                                <div class="row">
                                                    <div class="col-xl-12 input-field">

                                                <select id="categories" class="form-control categories animated-input"
                                                        name="category[]" multiple="multiple" placeholder="Mode of enquiry">

                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}"
                                                                @if(isset($tour) && count($tour->category) > 0 && in_array($category->id, $tour->category()->pluck('category_id')->toArray()))
                                                                selected
                                                                @elseif(old('category') &&  in_array($category->id,old('category'))) selected @endif>{{$category->data->name ?? ''}}</option>
                                                    @endforeach
                                                    </select>

                                                        <label class="animated-select-label"> {{trans('dashboard_forms.category')}}</label>
                                                        <span class="question tool"
                                                              data-tip="{{trans('dashboard_tours.category_help')}}"
                                                              tabindex="1">&quest;</span>
                                                    </div>

                                                    <div class="col-xl-12 input-field">
                                                        <input class="form-control animated-input" type="number" name="price"
                                                               value="{{old("price") ? old("price") : (isset($tour->price) ?  $tour->price : '')}}">
                                                        <label class="animated-label">  {{trans('dashboard_forms.price')}}</label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-12 input-field">
                                                       <input class="form-control animated-input" type="number" name="age_from"
                                                              value="{{old("age_from") ? old("age_from") : (isset($tour->age_from) ?  $tour->age_from : '')}}">
                                                        <label class="animated-label">{{trans('dashboard_forms.age_from')}}</label>
                                                         <span class="question tool"
                                                               data-tip="{{trans('dashboard_tours.age_from_help')}}"
                                                               tabindex="1">&quest;</span>
                                                    </div>

                                                    <div class="col-4">
                                                        <label class="position-relative">{{trans('dashboard_forms.status')}}<span class="question tool question-status"
                                                            data-tip="{{trans('dashboard_forms.status_help')}}"
                                                            tabindex="1">&quest;</span></label>

                                            <div class="radio">
                                                <input name="status" type="radio" id="active" class="animated-radio"
                                                       value="1" @if(isset($tour) && $tour->status) checked
                                                       @elseif(old('tour.status') && old('tour.status')==1) checked @endif>
                                                <label for="active"
                                                       class="animated-radio-label">{{trans('dashboard_forms.active')}}</label>

                                                <input name="status" type="radio" id="inactive" class="animated-radio"
                                                       value="0" @if(isset($tour) && $tour->status != 1) checked
                                                       @elseif((old('tour.status') && old('tour.status')== 0) || (!isset($tour) && !old('tour.status'))) checked @endif>
                                                <label for="inactive"
                                                       class="animated-radio-label"> {{trans('dashboard_forms.inactive')}}</label>
                                            </div>

                                            </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <div class='input-group date' id='start_date_datepicker'>
                                                                <input type='text' class="form-control animated-input" name="start_date"
                                                                       value="{{old("start_date") ? old("start_date") : (isset($tour->start_date) ? \Carbon\Carbon::parse($tour->start_date)->format('m/d/Y') : '')}}" />
                                                                <label class="animated-label">{{trans('dashboard_forms.start_date')}}</label>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <div class='input-group date' id='start_time_datepicker'>
                                                                <input type='text' class="form-control animated-input" name="start_time"
                                                                       value="{{old("start_time") ? old("start_time") : (isset($tour->start_time) ? $tour->start_time : '')}}" />
                                                                <label class="animated-label">{{trans('dashboard_forms.start_time')}}</label>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <div class='input-group date' id='end_date_datepicker'>
                                                                <input type='text' class="form-control animated-input" name="end_date"
                                                                       value="{{old("end_date") ? old("end_date") : (isset($tour->end_date) ? \Carbon\Carbon::parse($tour->end_date)->format('m/d/Y') : '')}}" />
                                                                <label class="animated-label">{{trans('dashboard_forms.end_date')}}</label>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <div class='input-group date' id='end_time_datepicker'>
                                                                <input type='text' class="form-control animated-input" name="end_time"
                                                                       value="{{old("end_time") ? old("end_time") : (isset($tour->end_time) ? $tour->end_time : '')}}" />
                                                                <label class="animated-label">{{trans('dashboard_forms.end_time')}}</label>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <input class="form-control animated-input" type="number" name="breakfast_price"
                                                                   value="{{isset($tour->prices['breakfast']->price) ?  $tour->prices['breakfast']->price : ''}}">
                                                            <label class="animated-label">{{trans('dashboard_forms.breakfast_price')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <div class="check">
                                                                <input type="checkbox" class="form-control" id="breakfast_can_refuse" value="1"
                                                                       @if(isset($tour->prices['breakfast']->can_refuse) && $tour->prices['breakfast']->can_refuse)
                                                                       checked @endif name="breakfast_can_refuse">
                                                                <label for="breakfast_can_refuse">{{trans('dashboard_forms.breakfast_can_refuse')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <input class="form-control animated-input" type="number" name="lunch_price"
                                                                   value="{{isset($tour->prices['lunch']->price) ?  $tour->prices['lunch']->price : ''}}">
                                                            <label class="animated-label">{{trans('dashboard_forms.lunch_price')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <div class="check">
                                                                <input type="checkbox" class="form-control" id="lunch_can_refuse" value="1"
                                                                       @if(isset($tour->prices['lunch']->can_refuse) && $tour->prices['lunch']->can_refuse)
                                                                       checked @endif name="lunch_can_refuse">
                                                                <label for="lunch_can_refuse">{{trans('dashboard_forms.lunch_can_refuse')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <input class="form-control animated-input" type="number" name="dinner_price"
                                                                   value="{{(isset($tour->prices['dinner']->price) ? $tour->prices['dinner']->price : '')}}">
                                                            <label class="animated-label">{{trans('dashboard_forms.dinner_price')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 input-field">
                                                        <div class="form-group">
                                                            <div class="check">
                                                                <input type="checkbox" class="form-control" id="dinner_can_refuse" value="1"
                                                                       @if(isset($tour->prices['dinner']->can_refuse) && $tour->prices['dinner']->can_refuse)
                                                                       checked @endif name="dinner_can_refuse">
                                                                <label for="dinner_can_refuse">{{trans('dashboard_forms.dinner_can_refuse')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-12 input-field">
                                                        <div class="custom-file-upload">
                                                            <input type="file" class="form-control animated-input" name="image"
                                                                   id="image" accept="image/x-png, image/jpeg">
                                                        </div>
                                                        @if(isset($tour->images['image'][0]->path))
                                                            <img class="mt-2" src="{{$tour->images['image'][0]->path}}"
                                                                 width="250">
                                                        @endif
                                                    </div>
                                                    <div class="col-xl-12 input-field">
                                                        <div class="custom-file-upload">
                                                            <input type="file" class="form-control animated-input" accept="image/x-png, image/jpeg"
                                                                   name="background_image" id="background_image">
                                                        </div>
                                                        @if(isset($tour->images['background_image'][0]->path))
                                                            <img class="mt-2"
                                                                 src="{{$tour->images['background_image'][0]->path}}"
                                                                 width="250">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>

                    </fieldset>

                    <h1>{{trans('dashboard_tours.tour_included')}}</h1>
                    <fieldset>
                        <p class="text">{{trans('dashboard_tours.facilities_help')}}</p>
                        <form id="tourFacilitiesForm">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            @foreach($facilities as $item)
                                <div class="col-xl-6 input-field">
                                    <div class="check">
                                        <input type="checkbox" class="form-control facilities-checkbox" value="{{$item->id}}"
                                               @if(isset($tour) && count($tour->facilities) > 0 && in_array($item->id, $tour->facilities()->pluck('facility_id')->toArray()))
                                               checked @endif id="facilitiesInput{{$item->id}}" name="facilities[{{$item->id}}]" multiple="multiple">
                                        <label for="facilitiesInput{{$item->id}}">{{$item->data->name ?? ''}}</label>
                                        <select @if(!isset($tour->facilities[$item->id])) style="display: none" @endif name="facilitiesType[{{$item->id}}]" class="animated-input">
                                            <option value="included" @if(isset($tour->facilities[$item->id]->pivot->type) && $tour->facilities[$item->id]->pivot->type == 'included') selected @endif>{{trans('dashboard_tours.included')}}</option>
                                            <option value="not_included" @if(isset($tour->facilities[$item->id]->pivot->type) && $tour->facilities[$item->id]->pivot->type == 'not_included') selected @endif>{{trans('dashboard_tours.not_included')}}</option>
                                            <option value="important" @if(isset($tour->facilities[$item->id]->pivot->type) && $tour->facilities[$item->id]->pivot->type == 'important') selected @endif>{{trans('dashboard_tours.important')}}</option>
                                            <option value="you_need" @if(isset($tour->facilities[$item->id]->pivot->type) && $tour->facilities[$item->id]->pivot->type == 'you_need') selected @endif>{{trans('dashboard_tours.you_need')}}</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </fieldset>

                    <h1>{{trans('dashboard_tours.tour_plan')}}</h1>
                    <fieldset>
                        <p class="text">{{trans('dashboard_tours.tour_plan_help_1')}}<br>
                            {{trans('dashboard_tours.tour_plan_help_2')}}</p>

                        <form id="tourPlanForm" class="form-horizontal" enctype="multipart/form-data">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            <div class="form-group row">
                                <div class="col-xl-6">
                                    <ul class="nav nav-tabs" id="tourPlanTab" role="tablist">
                                        @foreach($languages as $key => $value)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key=='en') active @endif" data-toggle="tab"
                                                   href="#tourPlan{{$key}}" aria-controls="title{{$key}}"
                                                   aria-selected="true">{{trans('dashboard_forms.' . $key)}}</a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content mt-3">
                                        @foreach($languages as $key => $value)
                                            <div class="tab-pane fade @if($key=='en') show active @endif" role="tabpanel"
                                                 id="tourPlan{{$key}}" aria-labelledby="profile-tab">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                       <div class="mb-3">{{trans('dashboard_forms.description')}}</div>
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
                            <div class="col-xl-6">
                                <h3>{{trans('dashboard_tours.tour_daily_plan')}}</h3>
                                <div class="table-responsive">
                                    <table id="tour-days-table" class="table table-hover table-bordered table-striped">
                                        <tbody>
                                        @if(isset($tour->allPlanDays))
                                            @foreach($tour->allPlanDays as $item)
                                                <tr>
                                                    <td id=editTourPlanDayTd{{$item->id}}> {{$item->data['en']->title ?? ""}}</td>
                                                    <td class='text-right'>
                                                        <button class='bg-transparent btn' id = "editTourPlanDayButton{{$item->id}}" onclick='editTourPlanDay(this)'  data-info='{{json_encode($item->data)}}'>
                                                            <i class='fa fa-pencil-square-o text-dark' aria-hidden='true'></i>
                                                        </button>
                                                        <button type='button' class='bg-transparent btn' title='Delete' onclick='deletePlanDay(this)' data-id='{{$item->id}}'>
                                                            <i class='fa fa-trash-o text-danger' aria-hidden='true'></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>

                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-blue" style="width: 200px"  onclick="clearTourPlanPopupFields()"
                                            data-toggle="modal" data-target="#addTourPlanDayModal"><i class="fa fa-plus mr-1" aria-hidden="true"></i> {{trans('dashboard_tours.add_tour_plan_day')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xl-12 text-center">

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
                                                        <div class="col-xl-12">

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

                                                                        <div class="row">
                                                                            <div class="col-xl-12 input-field">
                                                                                <input  class="form-control animated-input" id="tourPlanDayFeatureTitle{{$key}}" type="text" name="title_{{$key}}">
                                                                                <label class="animated-label">  {{trans('dashboard_forms.title')}}</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-xl-12 input-field">
                                                                                <textarea class="form-control animated-input" type="text" id="tourPlanDayFeatureDescription{{$key}}" name="description_{{$key}}"></textarea>
                                                                                <label class="animated-label">  {{trans('dashboard_forms.description')}} </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row tourPlanDayFeatureDiv">
                                                                            <div class="col-xl-12 input-field">
                                                                                <input class="form-control animated-input" type="text" name="feature_text_{{$key}}[]">
                                                                                <label class="animated-label">  {{trans('dashboard_forms.feature')}}</label>
                                                                                <button class='btn-danger btn btn-xs delete-feature delete-small' onclick="removeTourPlanDayFeatureRow(this)"> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-xl-4 text-left">
                                                            <button type="button"
                                                                   class="btn btn-blue"
                                                                    onclick="addTourPlanDayFeature()"> <i class="fa fa-plus mr-1" aria-hidden="true"></i> {{trans('dashboard_tours.add_tour_day_feature')}}</button>
                                                        </div>
                                                        <div class="col-xl-8">
                                                            <input type="button" style="float: right;" id="storeTourPlanDayButton"
                                                                   class="btn btn-blue" value="{{trans('dashboard_forms.submit')}}"
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
                        <p class="text">{{trans('dashboard_tours.tour_location_help')}}</p>
                        <form id="tourLocationForm">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                                <div class="d-flex row">

                                    <div class="col-xl-6">
                                        <div class="row">
                                        <div class="col-xl-12">
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
                                                    <div class="tab-pane fade @if($key=='en') show active @endif"
                                                         role="tabpanel"
                                                         id="titleLocation{{$key}}" aria-labelledby="profile-tab">
                                                        <div class="row">
                                                            <div class="col-xl-12 input-field ">

                                                        <textarea class="form-control animated-input" type="text"
                                                                  name="short_description_{{$key}}">{{ $tour->location[$key]['short_description'] ?? '' }}</textarea>
                                                                <label class="animated-label"> {{trans('dashboard_forms.short_description')}}</label>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                {{trans('dashboard_forms.description')}}
                                                                <textarea class="form-control {{$errors->has("description_$key")? "is-invalid" : ""}}"
                                                                        type="text" id="location_description_{{$key}}"
                                                                        name="description_{{$key}}">{{ $tour->location[$key]['description'] ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 margin">
                                        <div class="row">
                                        <div class="col-xl-12 input-field">
                                            <input class="form-control animated-input {{$errors->has("map")? "is-invalid" : ""}}"
                                                   type="text" name="map"
                                                   value="{{ $tour->map ?? '' }}">
                                            <label class="animated-label"> {{trans('dashboard_forms.map')}}</label>
                                            <span data-toggle="tooltip" data-html="true" title="{{trans('dashboard_tours.map_help')}}" class="question"
                                                  tabindex="1">&quest;</span>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </fieldset>

                    @if(config('tour.include_hotels'))
                    <h1>{{trans('dashboard_tours.tour_hotels')}}</h1>
                    <fieldset>
                        <p class="text">{{trans('dashboard_tours.hotels_help')}}</p>
                        <form id="tourHotelsForm">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            @foreach($hotelsGrouped as $star => $hotel)
                                <div class="row">
                                    <div class="col-xl-12 input-field">
                                        <label>{{$star . ' *'}}</label>
                                        <select name="hotels[]" multiple class="form-control hotels-select animated-input">
                                            @foreach($hotel as $item)
                                                <option value="{{$item->id}}"
                                                        @if(isset($tour) && count($tour->hotels) && in_array($item->id, $tour->hotels()->pluck('hotel_id')->toArray()))
                                                        selected
                                                        @endif>{{$item->data->title ?? ''}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                    </form>
                    </fieldset>
                    @endif
                    <h1>{{trans('dashboard_tours.tour_gallery')}}</h1>
                    <fieldset>
                        <p class="text">{{trans('dashboard_tours.tour_gallery_help')}}</p>
                        <form id="tourGalleryForm">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            <div class="form-group row">
                                <div class="col-xl-12">
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
                                                <div class="row">
                                                    <div class="col-xl-6 input-field">

                                                <textarea class="form-control animated-input" type="text" name="gallery_text_{{$key}}"
                                                >{{$tour->data[$key]['gallery_text'] ?? ''}}</textarea>
                                                        <label class="animated-label">  {{trans('dashboard_forms.gallery_description')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                                <hr>
                            <div class="form-group row">
                                <div class="col-xl-6 input-field">
                                    <div class="custom-file-upload">
                                        <input type="file" class="form-control animated-input" accept="image/x-png, image/jpeg"
                                               id="galleryImagesInput" name="gallery_images[]" multiple="multiple">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div  class="col-xl-12 d-flex flex-wrap" id="galleryContainerDiv">
                                    @if(isset($tour['images']['gallery']))
                                        @foreach($tour['images']['gallery'] as $item)
                                            <div class="position-relative image-box">
                                                <img src="{{$item->path}}" class="image-gallery">
                                                <button type='button' onclick='deleteImage(this)'
                                                        data-id="{{$item->id}}" class="btn btn-danger delete-img"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </form>
                    </fieldset>
                    <h1>{{trans('dashboard_tours.tour_meta')}}</h1>
                    <fieldset>
                        <form action="/dashboard/tour-meta" id="tourMetaForm" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @if(isset($tour)) <input type="hidden" name="tour_id" value="{{$tour->id}}"> @endif
                            @csrf
                                <div class="form-group row">
                                    <div class="col-xl-12">
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
                                                    <div class="d-flex row">

                                                        <div class="col-xl-6">
                                                            <div class="row">

                                                            <div class="col-xl-12 input-field">
                                                                <input class="form-control animated-input {{$errors->has("meta_title_$key")? "is-invalid" : ""}}"
                                                                       type="text" name="meta_title_{{$key}}"
                                                                       value="{{$tour->data[$key]['meta_title'] ??  ''}}">
                                                                <label class="animated-label"> {{trans('dashboard_forms.meta_title')}}</label>
                                                            </div>
                                                            </div>
                                                            <div class="row">
                                                            <div class="col-xl-12 input-field">
                                                                  <textarea
                                                                          class="form-control animated-input {{$errors->has("meta_keywords_$key") ? "is-invalid" : ""}}"
                                                                          type="text" name="meta_keywords_{{$key}}"
                                                                  >{{$tour->data[$key]['meta_keywords'] ?? ''}}</textarea>
                                                                <label class="animated-label">    {{trans('dashboard_forms.meta_keywords')}}</label>
                                                            </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-12 input-field">
                                                            <textarea
                                                                    class="form-control animated-input{{$errors->has("meta_description_$key")? "is-invalid" : ""}}"
                                                                    type="text" name="meta_description_{{$key}}"
                                                            >{{$tour->data[$key]['meta_description'] ?? ''}}</textarea>
                                                                    <label class="animated-label">  {{trans('dashboard_forms.meta_description')}}</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">

                                                <div class="row">
                                                    <div class="col-xl-12 input-field">
                                                        <div class="custom-file-upload">
                                                            <input type="file" accept="image/x-png, image/jpeg"
                                                                   class="form-control animated-input"
                                                                   name="meta_image" id="meta_image">
                                                        </div>
                                                        @if(isset($tour->images['meta_image'][0]->path) && $tour->images['meta_image'][0]->path)
                                                            <img class="mt-2"
                                                                 src="{{$tour->images['meta_image'][0]->path}}"
                                                                 width="250">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
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

    <link href="{{ asset('vendor/tour-dashboard/css/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/tour-dashboard/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/tour-dashboard/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

    {{--<link href="/css/jquery.steps.css" rel="stylesheet">--}}
    {{--<link href="/css/bootstrap-datepicker.min.css" rel="stylesheet">--}}
    {{--<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">--}}
@endsection

@section('scripts')

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>--}}
    <script src="{{ asset('vendor/tour-dashboard/js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('vendor/tour-dashboard/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendor/tour-dashboard/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/tour-dashboard/js/bootstrap-datetimepicker.min.js') }}"></script>

    {{--<script src="/js/jquery.steps.min.js"></script>--}}
    {{--<script src="/js/jquery.validate.min.js"></script>--}}
    {{--<script src="/js/bootstrap-datepicker.min.js"></script>--}}
    {{--<script src="/js/bootstrap-datetimepicker.min.js"></script>--}}
    <script src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
    <script>

        $(document).ready(function(){

            $(function () {

                $('#start_time_datepicker, #end_time_datepicker').datetimepicker({
                    pickDate: false,
                    pickerPosition: 'bottom-right',
                    format: 'hh:ii',
                    autoclose: true,
                    startView: 1
                });

                $(".datetimepicker").find('thead th').remove();
                $(".datetimepicker").find('thead').append($('<th class="switch">'));
                $('.switch').css('width','190px');

                $('#end_date_datepicker, #start_date_datepicker').datepicker({
                    autoclose: true,
                });

                $('#start_date_datepicker, #end_date_datepicker, #start_time_datepicker, #end_time_datepicker').on('change', function() {
                    console.log($(this).find("input").val());
                    $(this).addClass('active-input');
                    if ($(this).find("input").val() == '') {
                        $(this).removeClass('active-input');
                    }
                });
            });

            $(document).on('click', '.file-upload-button', function () {

                $(this).prev().prev().prev().focus().click();
            });

            $(document).on('change', '.custom-file-upload-hidden',function () {

                var files = [], fileArr, filename;
                var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
                    isIE = /msie/i.test(navigator.userAgent);

                if (multipleSupport) {
                    fileArr = $(this)[0].files;
                    for (var i = 0, len = fileArr.length; i < len; i++) {
                        files.push(fileArr[i].name);
                    }
                    filename = files.join(', ');

                } else {
                    filename = $(this).val().split('\\').pop();
                }

                $(this).next().val(filename)
                    .attr('title', filename)
                    .focus();

            });

            $(document).on('blur', '.file-upload-input', function () {

                $(this).prev().prev().prev().trigger('blur');
            });

            $("#formTourInfo").steps({
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
                            storeTourFacilities();
                            break;
                        case 2:
                            submitTourPlan(true);
                            break;
                        case 3:
                            submitTourLocation();
                            break;
                        case 4:
                            @if(config('tour.include_hotels'))
                                storeHotels();
                            @else
                                storeTourGallery(true);
                            @endif
                            break;
                        case 5:

                            @if(config('tour.include_hotels'))
                                storeTourGallery(true);
                            @else
                                storeTourMeta();
                            @endif
                            break;
                        case 6:
                            storeTourMeta();
                            break;
                    }
                    if (currentIndex < newIndex)
                    {
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }
                    var result = $('ul[aria-label=Pagination]').children().find('a');
                    $(result).each(function ()  {
                        if ($(this).text() == 'Finish') {
                            $(this).attr('disabled', true);
                            $(this).css('background', '#446588');
                        }
                    });
                    return true;

                },
                onFinished: function (event, currentIndex)
                {
                    $('.se-pre-con').show();
                    var form = $("#tourMetaForm");
                    form.submit();
                }
            });

            $('.hotels-select').select2({
                minimumSelectionLength: 1,
                placeholder: "{{trans('dashboard_tours.hotels_placeholder')}}"

            });

            $('.categories').select2({
                minimumSelectionLength: 1,
                placeholder: "{{trans('dashboard_tours.category_placeholder')}}"

            });

            $("#tourInfoForm").validate({
                ignore: "",
                rules: {
                    @foreach($languages as $key => $value)
                        title_{{$key}}: "required",
                    @endforeach
                },
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

            $('.facilities-checkbox').on('change', function(){
                console.log($(this).is(':checked'));
                if($(this).is(':checked')){
                    $(this).next().next().show();
                } else {
                    $(this).next().next().hide();
                }
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

                        url = '/dashboard/tours/' + data.tour_id + '/edit';

                        @foreach($languages as $key => $value)
                            $('#changeSiteLanguageLink{{$key}}').attr('href', '/{{$key}}' + url);
                        @endforeach

                        history.pushState('', '', url);

                        $('.nav-tabs a small').remove();
                        var el = '<input type="hidden" name="tour_id" value="' + data.tour_id + '">';
                        $('#dynamic-form').append(el);
                        var myforms = $("form");
                        myforms.each(function (i) {
                            myforms.eq(i).append(el);
                        });
                        $('.se-pre-con').hide();
                    },
                    error: function (error) {

                        $('.se-pre-con').hide();
                    }
                });
            }

            function submitTourPlan(isNextButton) {

                $('.se-pre-con').show();
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

                        $('.se-pre-con').hide();
                    },
                    error: function (error) {

                        $('.se-pre-con').hide();
                    }
                });
            }

            function submitTourLocation() {

                $('.se-pre-con').show();
                @foreach($languages as $key => $value)
                    $('#location_description_{{$key}}').val(locationDescriptionEditor{{$key}}.getData());
                @endforeach

                $('.nav-tabs a[href="#tourGallery"]').tab('show');
                $.ajax({
                    type: "POST",
                    url: "/dashboard/tour-location",
                    data: $("#tourLocationForm").serialize(),
                    success: function (data) {

                        $('.se-pre-con').hide();
                    },
                    error: function (error) {

                        $('.se-pre-con').hide();
                    }
                });
            }
        });

        (function ($) {

            var isIE = /msie/i.test(navigator.userAgent);

            $.fn.customFile = function () {

                return this.each(function (key, value) {

                    var text = '{{trans('dashboard_forms.image')}}';
                    if(value.id == 'galleryImagesInput'){

                        text = '{{trans('dashboard_forms.images')}}';
                    } else if(value.id == 'background_image') {

                        text = '{{trans('dashboard_forms.background_image')}}';
                    } else if(value.id == 'meta_image') {

                        text = '{{trans('dashboard_forms.meta_image')}}';
                    }

                    var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input
                        $wrap = $('<div class="file-upload-wrapper">'),
                        $input = $('<input type="text" class="file-upload-input animated-input form-control" /> <label class="animated-label">' + text + '</label>'),
                        $button = $('<button type="button" class="file-upload-button"><i class="fa fa-paperclip"></i></button>'),
                        $label = $('<label class="file-upload-button" for="' + $file[0].id + '"><i class="fa fa-paperclip"></i></label>');

                    $file.css({
                        position: 'absolute',
                        left: '-9999px'
                    });

                    $wrap.insertAfter($file)
                        .append($file, $input, ( isIE ? $label : $button ));

                    // Prevent focus
                    $file.attr('tabIndex', -1);
                    $button.attr('tabIndex', -1);

                });
            };

        }(jQuery));

        $('input[type=file]').customFile();
        function addTourPlanDayFeature() {
            var code;
            @foreach($languages as $key => $val)
                code = '<div class="row tourPlanDayFeatureDiv">' +
                '<div class="col-xl-12 input-field">' +
                '<input class="form-control animated-input used" type="text" name="feature_text_{{$key}}[]"><label class="animated-label">{{trans('dashboard_forms.feature')}}</label>' +
                '<button class="btn-danger btn btn-xs delete-feature delete-small" onclick="removeTourPlanDayFeatureRow(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>' +
                '</div>';
            $('#sectionTourPlanDay{{$key}}').append(code);
            @endforeach
        }

        function editTourPlanDay(thisButton) {

            var data = JSON.parse($(thisButton).attr('data-info'));
            $(".tourPlanDayFeatureDiv").remove();
            $("#tourPlanDayFormIdInput").remove();
            var featureHtml = '';
            $("#tourPlanDayForm").append("<input type='hidden' id='tourPlanDayFormIdInput' name='tour_plan_day_id' value='" + data.en.tour_plan_day_id + "'>");
            $.each(data, function (index, value) {
                $('.animated-input').blur(function () {
                    var $this = $(this);
                    if ($this.val())
                        $this.addClass('used');

                    else
                        $this.removeClass('used');
                });
                $('.animated-input').each(function () {
                    if ($(this).val()) {
                        $(this).addClass('used');
                    }
                });
                $('#tourPlanDayFeatureTitle' + index).val(value.title);
                $('#tourPlanDayFeatureDescription' + index).val(value.description);
                $.each(value.feature, function (indexFeature, valueFeature) {
                    featureHtml = "<div class='row tourPlanDayFeatureDiv'>" +
                        "<div class='col-xl-12 input-field'>" +
                        "<input class='form-control animated-input used' type='text' value='" + valueFeature.text + "' name='feature_text_" + index + "[]'><label class='animated-label'>{{trans('dashboard_forms.feature')}}</label>" +
                        "<button class='btn-danger btn btn-xs delete-feature delete-small' onclick='removeTourPlanDayFeatureRow(this)'> <i class='fa fa-trash' aria-hidden='true'></i></button>" +
                        "</div>";
                    $('#sectionTourPlanDay' + index).append(featureHtml);

                });
            });

            $('#addTourPlanDayModal').modal('show');
        }

        function clearTourPlanPopupFields() {

            $("#tourPlanDayForm").find('input[type=text], textarea').val('');
            $("#tourPlanDayFormIdInput").remove();
        }

        function storeTourPlanDay() {

            $('.se-pre-con').show();
            $.ajax({
                type: 'POST',
                url: '/dashboard/tour-plan-day',
                data: $("#tourPlanDayForm").serialize(),
                success: function (data) {

                    if (data.isEdit) {

                        $('#editTourPlanDayButton' + data.data.en.tour_plan_day_id).attr('data-info', JSON.stringify(data.data));
                        $('#editTourPlanDayTd' + data.data.en.tour_plan_day_id).text(data.data.en.title);
                    } else {

                        var code = "<tr>" +
                            "<td id='editTourPlanDayTd" + data.data.en.tour_plan_day_id + "'>" + data.data.en.title + "</td>" +
                            "<td class='text-right'>" +
                            "<button class='btn bg-transparent' id='editTourPlanDayButton" + data.data.en.tour_plan_day_id +
                            "' onclick='editTourPlanDay(this)'  data-info='" + JSON.stringify(data.data) + "'>" +
                            "<i class='fa fa-pencil-square-o text-dark' aria-hidden='true'></i> " +
                            "</button>" +
                            "<button type='button' class='btn bg-transparent delete-feature' title='Delete' onclick='deletePlanDay(this)' data-id='" + data.data.en.tour_plan_day_id + "'>" +
                            "<i class='fa fa-trash-o text-danger' aria-hidden='true'></i> " +
                            "</button>" +
                            "</td>" +
                            "</tr>";

                        $('#tour-days-table tbody').append(code);
                        $('.se-pre-con').hide();
                    }

                    $('#addTourPlanDayModal').modal('hide');
                    $('.se-pre-con').hide();


                },
                error: function (error) {

                }
            });
        }

        function storeTourFacilities( ) {

            $('.se-pre-con').show();

            var formData = new FormData(document.getElementById('tourFacilitiesForm'));

            $.ajax({
                type: "POST",
                url: "/dashboard/tour-facilities",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {

                    $('.se-pre-con').hide();
                },
                error: function (error) {

                    $('.se-pre-con').hide();
                }
            });
        }

        function storeHotels( ) {

            $('.se-pre-con').show();

            var formData = new FormData(document.getElementById('tourHotelsForm'));

            $.ajax({
                type: "POST",
                url: "/dashboard/tour-hotels",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {

                    $('.se-pre-con').hide();
                },
                error: function (error) {

                    $('.se-pre-con').hide();
                }
            });
        }

        function storeTourGallery(isNextButton) {

            $('.se-pre-con').show();
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

                        html = html + '<div class="position-relative image-box">' +
                            '<img src="' + value.path +'" class="image-gallery">' +
                            "<button type='button' onclick='deleteImage(this)'" +
                            'data-id="' + value.id + '" class="btn btn-danger delete-img"><i class="fa fa-trash" aria-hidden="true"></i></button>' +
                            '</div>'
                    });

                    $('#galleryContainerDiv').append(html);
                    $('.se-pre-con').hide();
                },
                error: function (error) {

                    $('.se-pre-con').hide();
                }
            });
        }

        function storeTourMeta() {

            $('.se-pre-con').show();
            var formData = new FormData(document.getElementById('tourMetaForm'));

            $.ajax({
                type: "POST",
                url: "/dashboard/tour-meta",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {

                    $('.se-pre-con').hide();
                },
                error: function (error) {

                    $('.se-pre-con').hide();
                }
            });
        }

        function deleteImage(thisButton) {

            $('.se-pre-con').show();
            $.ajax({
                type: "DELETE",
                url: "/dashboard/image/" + thisButton.getAttribute("data-id"),
                success: function (data) {

                    $(thisButton).parent().remove();
                    $('.se-pre-con').hide();
                },
                error: function (error) {

                    $('.se-pre-con').hide();
                }
            });
        }

        function deletePlanDay(thisButton) {

            $('.se-pre-con').show();
            $.ajax({
                type: "DELETE",
                url: "/dashboard/tour-plan-day/" + thisButton.getAttribute("data-id"),
                success: function (data) {

                    $(thisButton).parent().parent().remove();
                    $('.se-pre-con').hide();
                },
                error: function (error) {

                    $('.se-pre-con').hide();
                }
            });
        }

        function removeTourPlanDayFeatureRow(thisButton) {

            $(thisButton).parent().parent().remove();
        }

    </script>
@endsection