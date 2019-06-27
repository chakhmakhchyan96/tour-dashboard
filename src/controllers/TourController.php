<?php

namespace AISTGlobal\TourDashboard;

use AISTGlobal\TourDashboard\Category;
use AISTGlobal\TourDashboard\Image;
use AISTGlobal\TourDashboard\Services\DataService;
use AISTGlobal\TourDashboard\TourData;
use AISTGlobal\TourDashboard\TourIncluded;
use AISTGlobal\TourDashboard\TourLocation;
use AISTGlobal\TourDashboard\TourPlan;
use AISTGlobal\TourDashboard\TourPlanDay;
use AISTGlobal\TourDashboard\TourPlanDayData;
use AISTGlobal\TourDashboard\TourPlanDayFeature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AISTGlobal\TourDashboard\Tour;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TourController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tours = Tour::all();
        return view('dashboard.tour.index', compact('tours'));
    }

    public function create()
    {
        $languages = LaravelLocalization::getSupportedLocales();
        $categories = Category::where('status', 1)->with('data')->get();
        return view('dashboard.tour.create', compact('languages', 'categories'));
    }

    public function edit($id)
    {
        $languages = LaravelLocalization::getSupportedLocales();

        $tour = Tour::with('allIncluded', 'allPlans', 'allData', 'allPlanDays.allData',
            'allPlanDays.allFeatures', 'images', 'allLocations', 'category.data')->find($id);

        $tour->data = $tour->allData->keyBy('language');
        $tour->feature = $tour->allFeatures->groupBy('language');
        $tour->plan = $tour->allPlans->keyBy('language');
        $tour->location = $tour->allLocations->keyBy('language');
        foreach ($tour->allPlanDays as $item) {
            $item->data = $item->allData->keyBy('language');
            $item->feature = $item->allFeatures->groupBy('language');
            foreach ($item->data as $key => $data) {
                $data['feature'] = $item->feature[$key] ?? '';
            }
        }

        if (!$tour) {
            abort(404);
        }

        $categories = Category::where('status', 1)->with('data')->get();

        return view('dashboard.tour.edit', compact('tour', 'languages', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [];
        $langs = LaravelLocalization::getSupportedLocales();
        foreach ($langs as $key => $value) {

            $rules['title_' . $key] = 'required|max:255';
        }

        $request->validate($rules);
        $data = $request->all();
        $data['price'] = $request->get('price') ?? 0;
        $tour_id = Tour::saveData($data);
        return response()->json(['tour_id' => $tour_id]);
    }


    public function update(Request $request, $id)
    {
        $rules = [];
        $langs = LaravelLocalization::getSupportedLocales();
        foreach ($langs as $key => $value) {

            $rules['title_' . $key] = 'required|max:255';
        }

        $request->validate($rules);

        $this->data($request, $id);
        return redirect()->back();
    }

    public function storeTourIncluded(Request $request)
    {
        if ($request->has('tour_id')) {
            $requestData = $request->all();
            $response = [];

            $langs = LaravelLocalization::getSupportedLocales();

            foreach ($langs as $localeCode => $properties) {
                if ($requestData['text_' . $localeCode]) {

                    $included = TourIncluded::create(['text' => $requestData['text_' . $localeCode],
                        'tour_id' => $requestData['tour_id'], 'language' => $localeCode]);
                    $included['languageDisplayName'] = trans('dashboard_forms.' . $localeCode);
                    $response[$included->id] = $included;
                }
            }
            return response()->json($response);
        }

        return response()->json(['success' => false], 400);
    }

    public function updateTourIncluded($id, Request $request)
    {
        if ($request->has('text')) {
            $response = [];
            $included = TourIncluded::find($id);
            $included->text = $request->get('text');
            $included->save();
            $response[$included->id] = $included;

            return response()->json($response);
        }

        return response()->json(['success' => false], 400);
    }

    public function storeTourPlan(Request $request)
    {
        if ($request->has('tour_id')) {
            $requestData = $request->all();

            (new DataService())->updateData($requestData, $requestData['tour_id'], new TourPlan());
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function storeTourLocation(Request $request)
    {
        if ($request->has('tour_id')) {
            $requestData = $request->all();
            Tour::where('id', $requestData['tour_id'])->update(['map' => $request->get('map')]);

            (new DataService())->updateData($requestData, $requestData['tour_id'], new TourLocation());
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function storeTourGallery(Request $request)
    {
        if ($request->has('tour_id')) {
            $requestData = $request->all();
            (new DataService())->updateData($requestData, $requestData['tour_id'], new TourData());
            $response = [];

            if(array_key_exists('gallery_images', $requestData)){
                foreach ($requestData['gallery_images'] as $image){
                    $image = Image::saveData($image, 'image', 'tour', $requestData['tour_id'], 'gallery');
                    array_push($response, $image);
                }
            }

            return response()->json($response);
        }

        return response()->json(['success' => false], 400);
    }

    public function storeTourPlanDay(Request $request)
    {
        if ($request->has('tour_id')) {
            $requestData = $request->all();
            $response = collect();
            $isEdit = false;
            if ($request->has('tour_plan_day_id')) {
                $isEdit = true;
            }

            TourPlanDayFeature::where('tour_plan_day_id', $request->get('tour_plan_day_id'))->delete();

            $tourPlanDay = TourPlanDay::updateOrCreate(['id' => $request->get('tour_plan_day_id')], ['tour_id' => $requestData['tour_id']]);
            $langs = LaravelLocalization::getSupportedLocales();

            foreach ($langs as $localeCode => $properties) {

                $tourPlanDayData = TourPlanDayData::updateOrCreate(['tour_plan_day_id' => $request->get('tour_plan_day_id'), 'language' => $localeCode],
                    ['title' => $requestData['title_' . $localeCode], 'description' => $requestData['description_' . $localeCode],
                        'language' => $localeCode, 'tour_plan_day_id' => $tourPlanDay->id]);
                $response[$localeCode] = $tourPlanDayData;
                $response[$localeCode]['feature'] = collect();
                if (array_key_exists("feature_text_$localeCode", $requestData)) {

                    foreach ($requestData["feature_text_$localeCode"] as $text) {
                        if ($text) {
                            $feature = TourPlanDayFeature::create(['tour_plan_day_id' => $tourPlanDay->id, 'text' => $text, 'language' => $localeCode]);

                            $response[$localeCode]['feature'][$feature->id] = $feature;
                        }
                    }
                }
            }

            return response()->json(['data' => $response->toArray(), 'isEdit' => $isEdit]);
        }

        return response()->json(['success' => false], 400);
    }

    public function storeTourMeta(Request $request)
    {
        if ($request->has('tour_id')) {

            $data = $request->all();

            if (isset($data['meta_image']) && $data['meta_image']) {
                Image::saveData($data['meta_image'], 'image', 'tour', $data['tour_id'], 'meta_image');
            }
            (new DataService())->updateData($data, $data['tour_id'], new TourData());

            Session::flash('message', 'tour_updated_successfully');
            if(Str::contains(url()->previous(), 'create')){

                Session::flash('message', 'tour_created_successfully');
            }
            return redirect("/dashboard/tours");
        }

        Session::flash('message', 'tour_error_not_found');

        return redirect("/dashboard/tours");
    }

    public function deleteTourIncluded($id)
    {
        TourIncluded::destroy($id);

        return response()->json(['success' => true]);
    }

    public function deleteTourPlanDay($id)
    {
        TourPlanDay::destroy($id);
        TourPlanDayData::where('tour_plan_day_id', $id)->delete();
        TourPlanDayFeature::where('tour_plan_day_id', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function show($id)
    {

    }

    public function destroy($id)
    {
        $tour = Tour::whereId($id)->first();
        if (!$tour) {
            abort(404);
        }

        $tour->delete();

        return redirect()->back();
    }

}
