<h3>{{trans('dashboard_categories.category_detail')}}</h3>
<div class="d-flex row">

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
                            <div class="col-xl-12 input-field">

                                <input class="form-control animated-input {{$errors->has("name_$key")? "is-invalid" : ""}}"
                                       type="text" name="name_{{$key}}"
                                       value="{{old("name_$key") ? old("name_$key") : (isset($category->data[$key]['name']) ?  $category->data[$key]['name'] : '')}}">
                                <label class="animated-label">            {{trans('dashboard_forms.name')}}</label>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="margin col-xl-6">
        @if(isset($type))
            <input type="hidden" name="type" value="{{$type}}">
        @else
            <input type="hidden" name="type" value="{{$category->type}}">
        @endif
        <div class="input-field">
                <label>{{trans('dashboard_forms.type')}}</label>

                <div class="radio">

                    <input name="status" type="radio" id="active" class="animated-radio"
                           value="1" @if(isset($category) && $category->status) checked
                           @elseif(old('tour.status') && old('tour.status')==1) checked @endif>
                    <label for="active" class="animated-radio-label">{{trans('dashboard_forms.active')}}</label>

                    <input name="status" type="radio" id="inactive" class="animated-radio"
                           value="0" @if(isset($category) && $category->status != 1) checked
                           @elseif((old('tour.status') && old('tour.status')== 0) || (!isset($category) && !old('tour.status'))) checked @endif>
                    <label for="inactive" class="animated-radio-label">   {{trans('dashboard_forms.inactive')}}</label>

                </div>
            </div>

    </div>
</div>

<div class="text-right">
    <input type="submit" class="btn btn-blue"
           value="{{trans('dashboard_forms.submit')}}">
</div>

@section('scripts')
    <script>
        $(document).ready(function () {
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
        });
    </script>
@endsection