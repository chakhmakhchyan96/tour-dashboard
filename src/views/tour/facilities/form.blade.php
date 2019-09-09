
<div class="form-group row">
    <div class="col-lg-12">
        <h3>{{trans('dashboard_amenities.amenities_detail')}}</h3>
        <div class="row">
            <div class="col-xl-6">
                <div>
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
                     id="title{{$key}}" aria-labelledby="profile-tab">
                    <div class="row">
                        <div class="col-sm-12 input-field">
                            <input class="form-control animated-input {{$errors->has("name_$key")? "is-invalid" : ""}}"
                                   type="text" name="name_{{$key}}"
                                   value="{{old("name_$key") ? old("name_$key") : (isset($facility->data[$key]['name']) ?  $facility->data[$key]['name'] : '')}}">
                            <label class="animated-label">{{trans('dashboard_forms.name')}}</label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
    </div>
</div>
</div>
<hr>
<div class="form-group row">
    <div class="col-sm-6">
        <div class="d-flex">
            <input class="f-input form-control animated-input" id="image" disabled>
            <label class="animated-label">  {{trans('dashboard_forms.image')}}</label>
            <div class="fileUpload btn btn--browse">
                <span><i class="fa fa-paperclip"></i></span>
                <input id="uploadBtn" type="file" name="icon" accept="image/x-png, image/jpeg" class="upload" />
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <label>{{trans('dashboard_forms.status')}}</label>
        <div class="radio">
            <input name="status" type="radio" id="active" class="animated-radio"
                   value="1" @if(isset($facility) && $facility->status) checked
                   @elseif(old('status') && old('status')==1) checked @endif>
            <label for="active" class="animated-radio-label">{{trans('dashboard_forms.active')}}</label>

            <input name="status" type="radio" id="inactive" class="animated-radio"
                   value="0" @if(isset($facility) && $facility->status != 1) checked
                   @elseif((old('status') && old('status')== 0) || (!isset($facility) && !old('status'))) checked @endif>
            <label for="inactive" class="animated-radio-label">   {{trans('dashboard_forms.inactive')}}</label>
        </div>
    </div>
</div>
@if(isset($facility->images[0]->path))
    <img src="{{$facility->images[0]->path}}">
@endif


<div class="text-right">
    <input type="submit" class="btn btn-blue"
           value="{{trans('dashboard_forms.submit')}}">
</div>
