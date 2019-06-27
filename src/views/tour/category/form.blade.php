
<hr>
<div class="form-group row">
    <div class="col-sm-12">
        <h3>{{trans('dashboard_categories.category_detail')}}</h3>

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
                    <div class="row" style="margin-top: 10px">
                        <div class="col-sm-2 text-left" style="font-weight: bold">
                            {{trans('dashboard_forms.name')}}
                        </div>
                        <div class="col-sm-10">

                            <input class="form-control {{$errors->has("name_$key")? "is-invalid" : ""}}" type="text" name="name_{{$key}}"
                                   value="{{old("name_$key") ? old("name_$key") : (isset($category->data[$key]['name']) ?  $category->data[$key]['name'] : '')}}">
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
<hr>
<div class="form-group row">
    <div class="col-sm-2 text-left" style="font-weight: bold">{{trans('dashboard_forms.status')}}</div>
    <div class="col-sm-10">
        <div class="radio" style="float:left">
            <label><input name="status" type="radio"
                          value="1" @if(isset($category) && $category->status) checked @elseif(old('tour.status') && old('tour.status')==1) checked @endif> {{trans('dashboard_forms.active')}}</label>
        </div>
        <div class="radio" style="float:left;margin-left:20px">
            <label><input name="status" type="radio"
                          value="0" @if(isset($category) && $category->status != 1) checked @elseif((old('tour.status') && old('tour.status')== 0) || (!isset($category) && !old('tour.status'))) checked @endif>
                {{trans('dashboard_forms.inactive')}}</label>
        </div>
    </div>
</div>





<div class="form-group">
    <input type="submit" style="float: right;background-color:green;" class="btn-success" value="{{trans('dashboard_forms.submit')}}">
</div>

@section('scripts')
    <script>
        $(document).ready(function(){

            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                errorPlacement: function (error, element)
                {
                    element.before(error);
                },
                rules: {
                    confirm: {
                        equalTo: "#password"
                    }
                }
            });
        });
    </script>
@endsection