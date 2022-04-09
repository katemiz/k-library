<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Models\Role;
use App\Models\Category;
use App\Models\Skill;
use App\Models\Language;
use App\Models\Diploma;
use App\Models\Profession;



class RoleController extends Controller
{
    public function index () {
        return Inertia::render('Roles/Roles');
    }


    public function list(Request $request)
    {             
        $sortcolumn = 'title_en';
        $sortorder = 'asc';

        if ($request->input('sortcolumn')) {
            $sortcolumn = $request->input('sortcolumn');
        }

        if ($request->input('sortorder')) {
            $sortorder = $request->input('sortorder');
        }

        $params = false;

        if ( $request->input('search') ) {
            $params["search"] = $request->input('search');
        }

        if ($request->input('category')) {
            $params["category"] = $request->input('category');
        }

        if ($request->input('userid')) {
            $params["userid"] = $request->input('userid');
        }


        return Inertia::render('Roles/List',[
            // "paction" => 'index',
            // "categorytree" =>Category::getTreeData(),
            "roles" => Role::query()
                ->orderBy($sortcolumn,$sortorder)
                ->when($params,function($query,$params) {

                    if (isset($params['search']) && !empty($params['search'])) {
                        $query->where('title_en','like','%'.$params['search'].'%');
                    }

                    if (isset($params['category']) && !empty($params['category'])) {
                        $query->where('category','=',$params['category']);
                    }

                    if (isset($params['userid']) && !empty($params['userid'])) {
                        $query->where('created_by','=',$params['userid']);
                    }

                })
                ->paginate(Config::get('constants.table.no_of_results'))
                ->through(fn($item) =>Role::processItem($item))
                ->withQueryString(),
            "filters" => $request->only(["search","category"]),
            "notification" => false
        ]);
    }



    public function form (Request $request) {

        $categorytree = Category::getTreeData();


        if (is_numeric($request->id) && is_numeric($request->id) > 0 ) {
            $item = Role::find($request->id);
        } else {
            $item = false;
        }

        return Inertia::render('Roles/Form',[
            "categorytree" => $categorytree,
            "item" => $item
        ]);
    }


    public function show($id)
    {
        $role = Role::getItemById($id);

        return Inertia::render('Roles/Show',[
            "item" => $role,
            "notification" => false,
            "skills" => $role->skills()->get(),
            "languages" => $role->languages()->get(),
            "diplomas" =>  $role->diplomas()->get(),
            "professions" =>  $role->professions()->get(),
        ]);
    }


    public function create(Request $request)
    {
        // validate
        $attributes = $request->validate([
            'category' => 'required',
            'title_en'=>'required'
        ]);

        // Add new record
        Role::create([
            'category' => ucfirst($attributes['category']),
            'title_en' => ucfirst($attributes['title_en']),
            'title_tr' => ucfirst($request['title_tr']),
            'desc_en' => ucfirst($request['desc_en']['html']),
            'desc_en_text' => ucfirst($request['desc_en']['text']),
            'desc_tr' => ucfirst($request['desc_tr']['html']),
            'desc_tr_text' => ucfirst($request['desc_tr']['text'])
        ]);

        $item = Role::getLatestItem();

        return Inertia::render('Roles/Show',[
            "item" => $item,
            "skills" => [],
            "languages" => [],
            "notification" =>  [
                "type" =>'success',
                "message" => 'New role has been created successfully.'
            ]
        ]); 
    }


    public function update(Request $request)
    {
        // validate
        $attributes = $request->validate([
            'category' => 'required',
            'id'=>'required',
            'title_en'=>'required'
        ]);

        // Update record
        Role::find($attributes['id'])
        ->update([
            'category' => ucfirst($attributes['category']),
            'title_en' => ucfirst($attributes['title_en']),
            'title_tr' => ucfirst($request['title_tr']),
            'desc_en' => ucfirst($request['desc_en']['html']),
            'desc_en_text' => ucfirst($request['desc_en']['text']),
            'desc_tr' => ucfirst($request['desc_tr']['html']),
            'desc_tr_text' => ucfirst($request['desc_tr']['text'])
        ]);

        $item = Role::getItemById($attributes['id']);

        return Inertia::render('Roles/Show',[
            "item" =>  $item,
            "skills" => Role::getItemById($request->id)->skills()->get(),
            "notification" =>  [
                "type" =>'success',
                "message" => 'Role has been updated successfully.'
            ]
        ]); 
    }


    public function getskills(Request $request)
    {
        $role = Role::find($request->id);

        return Inertia::render('Roles/SelectSkills',[
            "id" => $request->id,
            "role" =>  $role,
            "skilltree" =>  Skill::getTreeData(),
            "roleSkills" => Role::getItemById($request->id)->skills()->get()
        ]); 
    }


    public function setskills(Request $request)
    {
        $role = Role::find($request->id);

        $role->skills()->detach();

        foreach ($request->skills as $record) {
            $role->skills()->attach($record["skill"],['level' => $record["level"]]);
        }

        return Inertia::render('Roles/Show',[
            "item" => $role,
            "notification" => false,
            "skills" => $role->skills()->get(),
            "languages" =>  $role->languages()->get(),
            "diplomas" =>  $role->diplomas()->get(),
            "professions" =>  $role->professions()->get(),
            "notification" =>  [
                "type" =>'success',
                "message" => 'Required skills have been updated successfully.'
            ]
        ]);
    }

    // LANGUAGE

    public function  getlang(Request $request)
    {
        $role = Role::find($request->id);

        return Inertia::render('Roles/Language',[
            "id" => $request->id,
            "role" =>  $role,
            "alllangs" => Language::orderBy("title")->get(),
            "rolelangs" =>  $role->languages()->get()
        ]); 
    }

    public function  setlang(Request $request)
    {
        $role = Role::find($request->id);
        $role->languages()->detach();

        foreach ($request->langs as $record) {
            $role->languages()->attach($record["id"],['level' => $record["level"]]);
        }

        return Inertia::render('Roles/Show',[
            "item" => $role,
            "notification" => false,
            "skills" => $role->skills()->get(),
            "languages" =>  $role->languages()->get(),
            "notification" =>  [
                "type" =>'success',
                "message" => 'Foreign language requirement has been set successfully.'
            ]
        ]);
    }

    // DIPLOMA

    public function  getdiploma(Request $request)
    {
        $role = Role::find($request->id);

        return Inertia::render('Roles/Diploma',[
            "id" => $request->id,
            "role" =>  $role,
            "alldiplomas" => Diploma::orderBy("title")->get(),
            "rolediplomas" =>  $role->diplomas()->get()
        ]); 
    }

    public function  setdiploma(Request $request)
    {
        $role = Role::find($request->id);
        $role->diplomas()->detach();

        foreach ($request->diplomas as $record) {
            $role->diplomas()->attach($record["id"],['status' => $record["status"]]);
        }

        return Inertia::render('Roles/Show',[
            "item" => $role,
            "notification" => false,
            "skills" => $role->skills()->get(),
            "languages" =>  $role->languages()->get(),
            "diplomas" =>  $role->diplomas()->get(),
            "professions" =>  $role->professions()->get(),
            "notification" =>  [
                "type" =>'success',
                "message" => 'Diploma requirement has been set successfully.'
            ]
        ]);
    }



    // PROFESSION
    public function  getprofession(Request $request)
    {
        $role = Role::find($request->id);

        return Inertia::render('Roles/Profession',[
            "id" => $request->id,
            "role" =>  $role,
            "allprofessions" => Profession::orderBy("title")->get(),
            "roleprofessions" =>  $role->professions()->get()
        ]); 
    }


    public function  setprofession(Request $request)
    {
        $role = Role::find($request->id);
        $role->professions()->detach();

        foreach ($request->professions as $record) {
            $role->professions()->attach($record["id"],['provision' => $record["provision"]]);
        }

        return Inertia::render('Roles/Show',[
            "item" => $role,
            "notification" => false,
            "skills" => $role->skills()->get(),
            "languages" =>  $role->languages()->get(),
            "diplomas" =>  $role->diplomas()->get(),
            "professions" =>  $role->professions()->get(),
            "notification" =>  [
                "type" =>'success',
                "message" => 'Profession has been added successfully.'
            ]
        ]);
    }




    // EXPERIENCE
    public function  getexperience(Request $request)
    {
        return Inertia::render('Roles/Experience',[
            "role" =>  Role::find($request->id)
        ]); 
    }


    public function  setexperience(Request $request)
    {
        // validate
        $attributes = $request->validate([
            'id'=>'required',
        ]);

        // Update record
        Role::find($attributes['id'])
        ->update([
            'experience' => ucfirst($request['experience']['html']),
            'experience_text' => ucfirst($request['experience']['text']),
        ]);

        $role = Role::find($request->id);

        return Inertia::render('Roles/Show',[
            "item" => $role,
            "notification" => false,
            "skills" => $role->skills()->get(),
            "languages" =>  $role->languages()->get(),
            "diplomas" =>  $role->diplomas()->get(),
            "professions" =>  $role->professions()->get(),
            "notification" =>  [
                "type" =>'success',
                "message" => 'Experience has been added successfully.'
            ]
        ]);
    }





    // DOCX

    public function docx(Request $request) {

        $role = Role::find($request->id);


    }




    
}


