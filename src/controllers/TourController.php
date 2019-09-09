<?php

namespace AISTGlobal\TourDashboard;

use App\Hotel; // need to fix
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with('data', 'category.data')->get();
        return view('tour-views::tour.index', compact('tours'));
    }

    public function create()
    {
        $languages = LaravelLocalization::getSupportedLocales();
        $categories = Category::where('status', 1)->where('type', 'tour')->with('data')->get();
        $facilities = Facilities::where('status', 1)->with('data')->get();

        $hotelsGrouped = [];
        if(config('tour.include_hotels')){
            $hotels = Hotel::where('status', 1)->with('data')->get();
            $hotelsGrouped = $hotels->groupBy('stars');
        }

        return view('tour-views::tour.create', compact('languages', 'categories', 'facilities', 'hotelsGrouped'));
    }

    public function edit($id)
    {
        $languages = LaravelLocalization::getSupportedLocales();

        $tour = Tour::with('allIncluded', 'allPlans', 'allData', 'allPlanDays.allData', 'hotels', 'facilities',
            'allPlanDays.allFeatures', 'images', 'prices', 'allLocations', 'category.data')->findOrFail($id);

        $tour->included = $tour->allIncluded->groupBy('mirror');
        foreach ($tour->included as $item){
            $item->data = $item->keyBy('language');
        }

        $tour->data = $tour->allData->keyBy('language');
        $tour->feature = $tour->allFeatures->groupBy('language');
        $tour->plan = $tour->allPlans->keyBy('language');
        $tour->location = $tour->allLocations->keyBy('language');
        $tour->prices = $tour->prices->keyBy('type');
        $tour->facilities = $tour->facilities->keyBy('id');
        foreach ($tour->allPlanDays as $item) {
            $item->data = $item->allData->keyBy('language');
            $item->feature = $item->allFeatures->groupBy('language');
            foreach ($item->data as $key => $data) {
                $data['feature'] = $item->feature[$key] ?? '';
            }
        }

        $categories = Category::where('status', 1)->where('type', 'tour')->with('data')->get();
        $facilities = Facilities::where('status', 1)->with('data')->get();

        $hotelsGrouped = [];
        if(config('tour.include_hotels')) {
            $hotels = Hotel::where('status', 1)->with('data')->get();
            $hotelsGrouped = $hotels->groupBy('stars');
        }

        return view('tour-views::tour.edit', compact('tour', 'languages', 'categories', 'facilities', 'hotelsGrouped'));
    }

    public function store(TourRequest $request)
    {
        $data = $request->all();
        $data['price'] = $request->get('price') ?? 0;
        $data['start_date'] = $request->get('start_date') ? Carbon::createFromFormat('m/d/Y', $request->get('start_date')) : null;
        $data['end_date'] = $request->get('end_date') ? Carbon::createFromFormat('m/d/Y', $request->get('end_date')) : null;
        $tour_id = Tour::saveData($data);
        return response()->json(['tour_id' => $tour_id]);
    }


    public function update(TourRequest $request, $id)
    {
        $this->data($request, $id);
        return redirect()->back();
    }

    public function storeFacilities(Request $request)
    {
        if ($request->has('tour_id')) {
            $requestData = $request->all();

            $tour = Tour::find($requestData['tour_id']);

            $tour->facilities()->sync([]);
            if (array_key_exists('facilities', $requestData) && count($requestData['facilities'])) {

                foreach ($requestData['facilities'] as $item) {
                    TourFacility::create([
                        'tour_id' => $tour->id,
                        'facility_id' => $item,
                        'type' => $requestData['facilitiesType'][$item],
                    ]);
                }
            }

            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false], 400);
    }

    public function storeHotels(Request $request)
    {
        if ($request->has('tour_id')) {
            $requestData = $request->all();

            $tour = Tour::find($requestData['tour_id']);

            if (array_key_exists('hotels', $requestData) && count($requestData['hotels'])) {
                $tour->hotels()->sync($requestData['hotels']);
            } else {
                $tour->hotels()->sync([]);
            }

            return response()->json(['success' => true], 200);
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
        $request->validate(['gallery_images.*'=>'mimes:jpeg,jpg,png|max:4096']);
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
        $request->validate(['meta_image'=>'mimes:jpeg,jpg,png|max:4096']);
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
        TourIncluded::where('mirror', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function deleteTourPlanDay($id)
    {
        TourPlanDay::destroy($id);
        TourPlanDayData::where('tour_plan_day_id', $id)->delete();
        TourPlanDayFeature::where('tour_plan_day_id', $id)->delete();

        return response()->json(['success' => true]);
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
