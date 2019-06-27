<?php

namespace AISTGlobal\TourDashboard;

use AISTGlobal\TourDashboard\Category;
use AISTGlobal\TourDashboard\CategoryData;
use App\Http\Requests\TourCategoryRequest;
use AISTGlobal\TourDashboard\Services\DataService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class TourCategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $user = Auth::user();
//        $check = Auth::check();
        $categories = Category::with('data')->get();
//        dd($categories);
        return view('tour-views::tour.category.index',compact('categories'));
    }

    public function create()
    {
        $languages = LaravelLocalization::getSupportedLocales();
        return view('tour-views::tour.category.create', compact('languages'));
    }


    public function edit($id)
    {
        $languages = LaravelLocalization::getSupportedLocales();

        $category =  Category::find($id);
        $category->data = $category->allData->keyBy('language');

        if (!$category) {
            abort(404);
        }

        return view('tour-views::tour.category.edit',compact('category','languages'));
    }

    public function store(Request $request)
    {
        $rules = [];
        $langs = LaravelLocalization::getSupportedLocales();
        foreach ($langs as $key => $value) {

            $rules['name_' . $key] = 'required|max:255';
        }
        $request->validate($rules);

        $data = $request->all();

        $category = Category::create($data);

        (new DataService())->saveData($data, $category->id, new CategoryData());

        return redirect()->route('categories.index');
    }

    public function update(Request $request,$id)
    {
        $rules = [];
        $langs = LaravelLocalization::getSupportedLocales();
        foreach ($langs as $key => $value) {

            $rules['name_' . $key] = 'required|max:255';
        }
        $request->validate($rules);

        $category = Category::find($id);
        $data = $request->all();

        $category->update($data);

        (new DataService())->updateData($data, $category->id, new CategoryData());

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return redirect()->route('categories.index');
    }
}
