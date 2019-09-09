<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{

    public function index($type)
    {
        $categories = Category::where('type', $type)->with('data')->get();
        return view('tour-views::category.index',compact('categories', 'type'));
    }

    public function create($type)
    {
        $languages = LaravelLocalization::getSupportedLocales();
        return view('tour-views::category.create', compact('languages' , 'type'));
    }


    public function edit($id)
    {
        $languages = LaravelLocalization::getSupportedLocales();

        $category =  Category::find($id);
        $category->data = $category->allData->keyBy('language');

        if (!$category) {
            abort(404);
        }

        return view('tour-views::category.edit',compact('category','languages'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        $category = Category::create($data);

        (new DataService())->saveData($data, $category->id, new CategoryData());

        return redirect('/dashboard/categories/' . $data['type']);
    }

    public function update(CategoryRequest $request,$id)
    {
        $category = Category::find($id);
        $data = $request->all();

        $category->update($data);

        (new DataService())->updateData($data, $category->id, new CategoryData());

        return redirect('/dashboard/categories/' . $data['type']);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect('/dashboard/categories/' . $category->type);
    }
}
