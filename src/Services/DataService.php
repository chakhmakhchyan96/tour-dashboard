<?php

namespace AISTGlobal\TourDashboard\Services;

use function dump;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DataService {

    public static function getSlug($title, $modelName)
    {
        $slug = Str::slug($title, '-');

        $oldDbItem = $modelName::where('slug', $slug)->first();

        $i = 1;
        $slugTemp = $slug;
        while ($oldDbItem) {

            $slug = $slugTemp . "-" . $i;
            $i++;
            $oldDbItem = $modelName::where('slug', $slug)->first();
        }

        return $slug;
    }

    /**
     * @param $requestData
     * @param $object
     * @param $dataObject
     * @return array
     */
    public static function saveData($requestData, $object_id, $dataObject)
    {
        $fillableArray = array_flip($dataObject->getFillable());
        $langs = LaravelLocalization::getSupportedLocales();

        foreach ($langs as $localeCode => $properties) {
            $data = [];
            foreach ($fillableArray as $key => $value) {
                if ($key == $dataObject->foreignKey) {

                    $data[$key] = $object_id;
                } elseif ($key == 'language') {

                    $data[$key] = $localeCode;
                } else {
                    $requestDataKey = $key . '_' . $localeCode;

                    if (array_key_exists($requestDataKey, $requestData)) {

                        $data[$key] = $requestData[$requestDataKey];
                    }
                }
            }

            $dataObject::create($data);
        }
        return $data;
    }


    /**
     * @param $requestData
     * @param $object
     * @param $dataObject
     * @return array
     */
    public static function updateData($requestData, $object_id, $dataObject)
    {
        $fillableArray = array_flip($dataObject->getFillable());
        $langs = LaravelLocalization::getSupportedLocales();
        foreach ($langs as $localeCode => $properties) {
            $dataToFind = [];
            $data = [];
            foreach ($fillableArray as $key => $value) {
                if ($key == $dataObject->foreignKey) {
                    $dataToFind[$key] = $object_id;
                } elseif ($key == 'language') {
                    $dataToFind[$key] = $localeCode;
                } else {
                    $requestDataKey = $key . '_' . $localeCode;
                    if (array_key_exists($requestDataKey, $requestData)) {
                        $data[$key] = $requestData[$requestDataKey];
                    }
                }
            }
            $dataObject::updateOrCreate($dataToFind, $data);
        }
        return $data;
    }
}