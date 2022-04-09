<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;



class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('BusinessCategory/Category',[
            "item" => false,
            "paction" => 'index',
            "notification" => false,
            "treedata" => Category::getTreeData()
        ]);
    }



    public function create(Request $request)
    {
        // validate
        $attributes = $request->validate([
            'parent_id'=>'required',
            'title_en'=>'required',
            'title_tr'=>'required'
        ]);

        // Add new record
        Category::create([
            'parent_id' => $attributes['parent_id'],
            'title_en' => ucfirst($attributes['title_en']),
            'title_tr' => ucfirst($attributes['title_tr']),
            'desc_en' => ucfirst($request['desc_en']['html']),
            'desc_tr' => ucfirst($request['desc_tr']['html']),
            'desc_en_text' => ucfirst($request['desc_en']['text']),
            'desc_tr_text' => ucfirst($request['desc_tr']['text']),
        ]);

        return Inertia::render('BusinessCategory/Category',[
            "treedata" => Category::getTreeData(),
            "item" => Category::getLatestItem(),
            "paction" => 'show',
            "notification" =>  [
                "type" =>'success',
                "message" => 'New business category has been added successfully.'
            ]
        ]); 
    }




    public function update(Request $request)
    {
        // validate
        $attributes = $request->validate([
            'id'=>'required',
            'parent_id'=>'required',
            'title_en'=>'required',
            'title_tr'=>'required'
        ]);

        // Update record
        Category::find($attributes['id'])
        ->update([
            'parent_id' => $attributes['parent_id'],
            'title_en' => ucfirst($attributes['title_en']),
            'title_tr' => ucfirst($attributes['title_tr']),
            'desc_en' => ucfirst($request['desc_en']['html']),
            'desc_tr' => ucfirst($request['desc_tr']['html']),
            'desc_en_text' => ucfirst($request['desc_en']['text']),
            'desc_tr_text' => ucfirst($request['desc_tr']['text']),
        ]);

        return Inertia::render('BusinessCategory/Category',[
            "treedata" => Category::getTreeData(),
            "item" =>  Category::getItemById($attributes['id']),
            "paction" => 'show',
            "notification" =>  [
                "type" =>'success',
                "message" => 'Business category has been updated successfully.'
            ]
        ]); 
    }



    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Category::find($request->id)->delete();
        }

        return Inertia::render('BusinessCategory/Category',[
            "treedata" => Category::getTreeData(),
            "id" => false,
            "item" => false,
            "paction" => 'index',
            "notification" =>  [
                "type" =>'success',
                "message" => 'Business category has been deleted successfully.'
            ]
        ]); 

    }



}

