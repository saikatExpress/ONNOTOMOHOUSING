<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        if(!Auth::check()){
            return redirect()->route('logout.us');
        }
    }

    public function index()
    {
        $categories = Category::all();

        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'category_head' => ['required']
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $name = Str::title($request->input('category_head'));
            $slug = Str::slug($request->input('category_head'), '-');

            $catgeoryObj = new Category();

            $catgeoryObj->name       = $name;
            $catgeoryObj->slug       = $slug;
            $catgeoryObj->cost_head  = $name;
            $catgeoryObj->created_by = Auth::id();

            $res = $catgeoryObj->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Category created successfuly');
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'cat_head' => ['required']
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
            $categoryId = $request->input('cat_id');
            $category = Category::findOrFail($categoryId);

            $name = Str::title($request->input('cat_head'));
            $slug = Str::slug($request->input('cat_head'), '-');


            $category->name       = $name;
            $category->slug       = $slug;
            $category->cost_head  = $name;
            $category->created_by = Auth::id();

            $res = $category->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Category updated successfuly');
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Category not found.']);
        }
    }
}
