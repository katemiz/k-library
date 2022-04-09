<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use Inertia\Inertia;



class SkillController extends Controller
{


    public function slevels()
    {
        return Inertia::render('Skill/SkillLevels');
    }

    public function index()
    {
        return Inertia::render('Skill/Skills',[
            "item" => false,
            "paction" => 'index',
            "notification" => false,
            "treedata" => Skill::getTreeData()
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
        Skill::create([
            'parent_id' => $attributes['parent_id'],
            'title_en' => ucfirst($attributes['title_en']),
            'title_tr' => ucfirst($attributes['title_tr']),
            'desc_en' => ucfirst($request['desc_en']['html']),
            'desc_tr' => ucfirst($request['desc_tr']['text']),
        ]);

        return Inertia::render('Skill/Skills',[
            "treedata" => Skill::getTreeData(),
            "item" => Skill::getLatestItem(),
            "paction" => 'show',
            "notification" =>  [
                "type" =>'success',
                "message" => 'New skill has been added successfully.'
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
        Skill::find($attributes['id'])
        ->update([
            'parent_id' => $attributes['parent_id'],
            'title_en' => ucfirst($attributes['title_en']),
            'title_tr' => ucfirst($attributes['title_tr']),
            'desc_en' => ucfirst($request['desc_en']['html']),
            'desc_tr' => ucfirst($request['desc_tr']['text'])
        ]);

        return Inertia::render('Skill/Skills',[
            "treedata" => Skill::getTreeData(),
            "item" =>  Skill::getItemById($attributes['id']),
            "paction" => 'show',
            "notification" =>  [
                "type" =>'success',
                "message" => 'Skill has been updated successfully.'
            ]
        ]); 
    }



    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Skill::find($request->id)->delete();
        }

        return Inertia::render('Skill/Skills',[
            "treedata" => Skill::getTreeData(),
            "id" => false,
            "item" => false,
            "paction" => 'index',
            "notification" =>  [
                "type" =>'success',
                "message" => 'Skill has been deleted successfully.'
            ]
        ]); 
    }
}