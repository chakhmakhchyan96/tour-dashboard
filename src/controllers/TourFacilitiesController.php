<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TourFacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities = Facilities::with('data')->get();
        return view('tour-views::tour.facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = LaravelLocalization::getSupportedLocales();
        return view('tour-views::tour.facilities.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AmenitiesRequest $request)
    {
        $data = $request->all();

        $facility = Facilities::create($data);

        if (isset($data['icon']) && $data['icon']) {
            Image::saveData($data['icon'], 'image', 'facility', $facility->id, 'icon');
        }

        (new DataService())->saveData($data, $facility->id, new FacilityData());

        return redirect()->route('facilities.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $languages = LaravelLocalization::getSupportedLocales();

        $facility = Facilities::with('images')->findOrFail($id);
        $facility->data = $facility->allData->keyBy('language');

        return view('tour-views::tour.facilities.edit', compact('facility', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AmenitiesRequest $request, $id)
    {
        $facility = Facilities::find($id);
        $data = $request->all();

        $facility->update($data);

        if (isset($data['icon']) && $data['icon']) {
            Image::saveData($data['icon'], 'image', 'facilities', $facility->id, 'icon');
        }

        (new DataService())->updateData($data, $facility->id, new FacilityData());

        return redirect()->route('facilities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Facilities::destroy($id);

        return redirect()->route('facilities.index');
    }
}
