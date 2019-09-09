<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AmenitiesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['icon'] = 'mimes:jpeg,jpg,png|max:4096';

        $langs = LaravelLocalization::getSupportedLocales();
        foreach ($langs as $key => $value) {

            $rules['name_' . $key] = 'required|max:255';
        }

        return $rules;
    }
}
