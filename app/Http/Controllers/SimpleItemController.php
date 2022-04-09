<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


use App\Models\Language;
use App\Models\Diploma;
use App\Models\Profession;
use App\Models\Project;


class SimpleItemController extends Controller
{

    public function getdata($request) {

        $sortcolumn = 'title';
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

        if ($request->input('userid')) {
            $params["created_by"] = $request->input('userid');
        }

        if ($request->type == 'language') {

            $getdata = Language::query()
                    ->orderBy($sortcolumn,$sortorder)
                    ->when($params,function($query,$params) {

                        if (isset($params['search']) && !empty($params['search'])) {
                            $query->where('title','like','%'.$params['search'].'%');
                        }
            
                        if (isset($params['userid']) && !empty($params['userid'])) {
                            $query->where('created_by','=',$params['userid']);
                        }
                    })
                    ->paginate(Config::get('constants.table.no_of_results'))
                    ->through(fn($item) =>Language::processItem($item))
                    ->withQueryString();
        }

        if ($request->type == 'diploma') {

            $getdata = Diploma::query()
                    ->orderBy($sortcolumn,$sortorder)
                    ->when($params,function($query,$params) {

                        if (isset($params['search']) && !empty($params['search'])) {
                            $query->where('title','like','%'.$params['search'].'%');
                        }
            
                        if (isset($params['userid']) && !empty($params['userid'])) {
                            $query->where('created_by','=',$params['userid']);
                        }
                    })
                    ->paginate(Config::get('constants.table.no_of_results'))
                    ->through(fn($item) =>Diploma::processItem($item))
                    ->withQueryString();
        }

        if ($request->type == 'profession') {

            $getdata = Profession::query()
                    ->orderBy($sortcolumn,$sortorder)
                    ->when($params,function($query,$params) {

                        if (isset($params['search']) && !empty($params['search'])) {
                            $query->where('title','like','%'.$params['search'].'%');
                        }
            
                        if (isset($params['userid']) && !empty($params['userid'])) {
                            $query->where('created_by','=',$params['userid']);
                        }
                    })
                    ->paginate(Config::get('constants.table.no_of_results'))
                    ->through(fn($item) =>Profession::processItem($item))
                    ->withQueryString();
        }

        if ($request->type == 'project') {

            $getdata = Project::query()
                    ->orderBy($sortcolumn,$sortorder)
                    ->when($params,function($query,$params) {

                        if (isset($params['search']) && !empty($params['search'])) {
                            $query->where('title','like','%'.$params['search'].'%');
                        }
            
                        if (isset($params['userid']) && !empty($params['userid'])) {
                            $query->where('created_by','=',$params['userid']);
                        }
                    })
                    ->paginate(Config::get('constants.table.no_of_results'))
                    ->through(fn($item) =>Project::processItem($item))
                    ->withQueryString();
        }


        return $getdata;
    }



    public function list(Request $request)
    {             
        return Inertia::render('SimpleItem/List',[
            "pagetype" => $request->type,
            "tabledata" => $this->getdata($request),
            "filters" => $request->only(["search"]),
            "notification" => false
        ]);
    }



    public function form(Request $request)
    {
        if (is_numeric($request->id) && is_numeric($request->id) > 0 ) {

            if ($request->type == 'language') {
                $item = Language::find($request->id);
            }

            if ($request->type == 'diploma') {
                $item = Diploma::find($request->id);
            }

            if ($request->type == 'profession') {
                $item = Profession::find($request->id);
            }

            if ($request->type == 'project') {
                $item = Project::find($request->id);
            }

        } else {
            $item = false;
        }

        return Inertia::render('SimpleItem/Form',[
            "pagetype" => $request->type,
            "item" => $item
        ]);
    }



    public function create(Request $request)
    {
        // validate
        $attributes = $request->validate([
            'title'=>'required'
        ]);


        if ($request->type == 'language') {
            // Add new record
            Language::create([
                'title' => ucfirst($attributes['title']),
                'remarks' => $request['remarks']['html'],
                'remarks_text' => $request['remarks']['text']
            ]);

            $item = Language::getLatestItem();
            $msg = 'New foreign language has been created successfully.';
        }


        if ($request->type == 'diploma') {

            // Add new record
            Diploma::create([
                'title' => ucfirst($attributes['title']),
                'remarks' => $request['remarks']['html'],
                'remarks_text' => $request['remarks']['text']
            ]);

            $item = Diploma::getLatestItem();
            $msg = 'New education/diploma level has been created successfully.';
        }


        if ($request->type == 'profession') {

            // Add new record
            Profession::create([
                'title' => ucfirst($attributes['title']),
                'remarks' => $request['remarks']['html'],
                'remarks_text' => $request['remarks']['text']
            ]);

            $item = Profession::getLatestItem();
            $msg = 'New profession requirements has been created successfully.';
        }


        if ($request->type == 'project') {

            // Add new record
            Project::create([
                'title' => ucfirst($attributes['title']),
                'remarks' => $request['remarks']['html'],
                'remarks_text' => $request['remarks']['text']
            ]);

            $item = Project::getLatestItem();
            $msg = 'New project has been created successfully.';
        }


        return Inertia::render('SimpleItem/Show',[
            "pagetype" => $request->type,
            "item" => $item,
            "notification" =>  [
                "type" =>'success',
                "message" => $msg
            ]
        ]); 
    }


    public function update(Request $request)
    {
        // validate
        $attributes = $request->validate([
            'id'=>'required',
            'title'=>'required'
        ]);

        $params = [
            'title' => ucfirst($attributes['title']),
            'remarks' => ucfirst($request['remarks']['html']),
            'remarks_text' => ucfirst($request['remarks']['text'])
        ];

        if ($request->type == 'language') {
            // Update record
            Language::find($attributes['id'])->update($params);
            $item = Language::getItemById($attributes['id']);
            $msg = 'Language has been updated successfully.';
        }

        if ($request->type == 'diploma') {
            // Update record
            Diploma::find($attributes['id'])->update($params);
            $item = Diploma::getItemById($attributes['id']);     
            $msg = 'Diploma has been updated successfully.';
        }

        if ($request->type == 'profession') {
            // Update record
            Profession::find($attributes['id'])->update($params);
            $item = Profession::getItemById($attributes['id']);
            $msg = 'Profession has been updated successfully.';
        }

        if ($request->type == 'project') {
            // Update record
            Project::find($attributes['id'])->update($params);
            $item = Project::getItemById($attributes['id']);
            $msg = 'Project has been updated successfully.';
        }

        return Inertia::render('SimpleItem/Show',[
            "pagetype" => $request->type,
            "item" => $item,
            "notification" =>  [
                "type" =>'success',
                "message" => $msg
            ]
        ]); 
    }



    public function show(Request $request)
    {
        if ($request->type == 'language') {
            $item = Language::getItemById($request->id);
        }

        if ($request->type == 'diploma') {
            $item = Diploma::getItemById($request->id);
        }

        if ($request->type == 'profession') {
            $item = Profession::getItemById($request->id);
        }

        if ($request->type == 'project') {
            $item = Project::getItemById($request->id);
        }

        return Inertia::render('SimpleItem/Show',[
            "pagetype" => $request->type,
            "item" => $item,
            "notification" => false
        ]);
    }



    public function destroy(Request $request)
    {
        if ($request->has('id')) {

            if ($request->type == 'language') {
                Language::find($request->id)->delete();
                $msg = 'Language has been deleted successfully.';
            }
    
            if ($request->type == 'diploma') {
                Diploma::find($request->id)->delete();
                $msg = 'Diploma has been deleted successfully.';
            }
    
            if ($request->type == 'profession') {
                Profession::find($request->id)->delete();
                $msg = 'Profession has been deleted successfully.';
            }

            if ($request->type == 'project') {
                Project::find($request->id)->delete();
                $msg = 'Project has been deleted successfully.';
            }
        }

        return Inertia::render('SimpleItem/List',[
            "pagetype" => $request->type,
            "tabledata" => $this->getdata($request),
            "filters" => $request->only(["search"]),
            "notification" =>  [
                "type" =>'success',
                "message" => $msg
            ]
        ]);
    }

}
