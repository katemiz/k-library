<?php
/*
|----------------------------------------------------------------------------
|	Ankara 02 August 2020 (katemiz@gmail.com)
|----------------------------------------------------------------------------
*/

define("IMDB_DIR","/wd2tb/IMDB/");
define("FILM_DIR","/var/lib/transmission-daemon/downloads/");



$config = json_decode(file_get_contents("../config/config.json"));

include_once $_SERVER["DOCUMENT_ROOT"].'/Common/class/MongoDb.php';

$mongo = new Mongo($config->DB);

$data = json_decode(file_get_contents("php://input"));  // DATA AS OBJECT

switch($data->action) {

    default:
    case "listall":
        ListFilms($mongo,$config,$data);
        break;

    case "search":
        SearchFilms($mongo,$config,$data->query);
        break;

    case "scandir":
        DirFiles($data->id);
        break;

    case "deleteFile":
        DeleteFile($data->file);
        break;

    case "refreshDb":
        RefreshDb($data->ttid);
        break;

    case "scanAll":
        ScanAll();
        break;

    case "listNew":
        ListNew();
        break;

    case "insertNewFilm":
        InsertNewFilm();
        break;        
}





function ListFilms($mongo,$config,$data) {

    $all = $mongo->Query($config->FILM_COLLECTION,[],['sort' => ['title' => 1]]);

    if ($data->showRandom) {

        $filtered = [];

        for ($i = 0; $i<= $data->noResults; $i++) {
            array_push($filtered,$all[rand(0, count($all))]);
        }

        $all = $filtered;
    }

    if ($all) {

        http_response_code(200);
        echo json_encode(["films"=>$all,"error"=>false]);

    } else {

        http_response_code(404);
        echo json_encode(["error"=>"An error occurred"]);
    }
}


function SearchFilms($mongo,$config,$query) {

    //echo 'Query = '.$query;

    $searchParams = array('$or' => array(
        array("title" => [ '$regex' => $query ]),
        array("directors" => [ '$regex' => $query ])
    ));


    //$searchParams = array("title" => [ '$regex' => $query,'$options' => 'i' ]);

    $all = $mongo->Query($config->FILM_COLLECTION,$searchParams,['sort' => ['title' => 1]]);

    // if (count($all) <1) {
    //     $all = [];
    // }
    
    if ($all) {

        http_response_code(200);
        echo json_encode(["films"=>$all,"error"=>false]);

    } else {

        http_response_code(404);
        echo json_encode(["error"=>"An error occurred"+$all]);
    }
}


function DirFiles($id) {

    $dir = IMDB_DIR.$id;

    if (!file_exists($dir)) {

        http_response_code(404);
        echo json_encode(["error"=>"Directory does not exist : ".$dir]);
        exit();
    }

    $files = scandir($dir);

    $dosyalar = [];

    foreach ($files as $file) {
        $dosyalar[] = [
            "name" => $file,
            "size"=>filesize($dir.'/'.$file),
            "type" =>filetype($dir.'/'.$file),
            "mime" =>mime_content_type($dir.'/'.$file)
        ];
    }

    if (scandir($dir)) {

        http_response_code(200);
        echo json_encode(["files"=>$dosyalar,"error"=>false]);

    } else {

        http_response_code(404);
        echo json_encode(["error"=>"An error occurred in returning dir files"]);
    }
}


function DeleteFile($fileToDelete) {

    if (!file_exists($fileToDelete)) {

        http_response_code(404);
        echo json_encode(["error"=>"No such file found : ".$fileToDelete]);
        exit();
    }

    if (unlink($fileToDelete)) {

        http_response_code(200);
        echo json_encode(["error"=>false]);

    } else {

        http_response_code(404);
        echo json_encode(["error"=>"Error deleting file :".$fileToDelete]);
    }
}


function RefreshDb($ttid) {

    global $mongo,$config;

    $oneItem = $mongo->Query($config->FILM_COLLECTION,["id"=>$ttid],[]);

    if ( count($oneItem) < 1 ) {

        http_response_code(404);
        echo json_encode(["error"=>true,"msg"=>"No item found","response"=>$oneItem]);
        exit();
    } 

    $_id    = $oneItem["0"]->_id;

    $response = apiData($ttid,'imdb');

    if (!$response["errorMessage"]) {

        $props["year"]      = $response["year"];
        $props["title"]     = $response["title"];
        $props["orgtitle"]  = $response["originalTitle"];
        $props["plot"]      = $response["plot"];
        $props["directors"] = $response["directors"];
        $props["image"]     = $response["image"];

        /* ****************************************
        *
        *   UPDATE
        *
        * ****************************************/
        if (!$mongo->UpdateOne($config->FILM_COLLECTION,$_id,$props)) {

            http_response_code(404);
            echo json_encode(["error"=>true,"msg"=>"Failed to update","response"=>$response]);
            exit();
        } 

        http_response_code(200);
        echo json_encode(["props"=>$response,"error"=>false]);
      
    } else {
        http_response_code(200);
        echo json_encode(["props"=>$response,"error"=>false]);
    }
}


function ListNew() {

    if (!file_exists(FILM_DIR)) {

        http_response_code(404);
        echo json_encode(["files"=>[],"error"=>"Directory does not exist : ".FILM_DIR]);
        exit();
    }

    $files = scandir(FILM_DIR);

    $dosyalar = [];

    foreach ($files as $file) {

        if ($file != '.' && $file != '..') {

            $size = filesize(FILM_DIR.$file);
            $type = filetype(FILM_DIR.$file);
            $dosyalar[] = ["name"=>$file,"size"=>$size,"type"=>$type];
        }
    }

    http_response_code(200);
    echo json_encode(["files"=>$dosyalar,"error"=>false]);
}


function InsertNewFilm() {

    global $data;

    $imdb = $data->imdb;
    $filename = $data->filename;

    $response = apiData($imdb,'imdb');

    if ( Move($filename,$imdb) ) {

        $props["id"]        = $imdb;
        $props["year"]      = $response["year"];
        $props["title"]     = $response["title"];
        $props["orgtitle"]  = $response["originalTitle"];
        $props["plot"]      = $response["plot"];
        $props["directors"] = $response["directors"];
        $props["image"]     = $response["image"];

        if ( AddNewFilmToDb($imdb,$props) ) {

            http_response_code(200);
            echo json_encode(["error"=>false]);
            exit();
        } 

        http_response_code(404);
        echo json_encode(array("msg"=>"DB Error","error"=>true));
        exit();

    } else {

        http_response_code(404);
        echo json_encode(array("msg"=>"Move Error","error"=>true));
        exit();
    }
}


function ScanAll() {

    global $mongo;

    $dirs = scandir(IMDB_DIR);

    $sonuc = [];

    foreach ($dirs as $filmDir) {

        $fullpath = IMDB_DIR.$filmDir;

        $response = apiData($filmDir,'omdb');

        $dosyalar = [];

        $filmFiles = scandir($fullpath);
        
        foreach ($filmFiles as $file) {

            $dosyalar[] = [
                "name" => $file,
                "size"=>filesize($file),
                "type" =>filetype($file),
                "mime" =>mime_content_type($file)
            ];
        }

        $dbItem["id"] = $filmDir;
        $dbItem["Title"] = $response["Title"];
        $dbItem["Year"] = $response["Year"];
        $dbItem["Director"] = $response["Director"];
        $dbItem["Plot"] = $response["Plot"];
        $dbItem["Poster"] = $response["Poster"];

        if (!$mongo->InsertOne('FData2',$dbItem)) {

            http_response_code(404);
            echo json_encode(array("record"=>true,"error"=>true));
            exit();
        }

        $sonuc[] = ["data" => $response,"dosyalar" => $dosyalar];
    }

    http_response_code(200);
    echo json_encode($sonuc);
}


function apiData($ttnumber,$tip) {

    if ($tip == 'imdb') {
        $url = 'https://imdb-api.com/en/API/Title/k_g5G134n7/'.$ttnumber;
    }

    if ($tip == 'omdb') {
        $url = 'https://www.omdbapi.com/?i='.$ttnumber.'&apikey=60f45ca8';
    }

    $response = file_get_contents($url);
    $response = (array) json_decode($response);

    return $response;
}


function Move($name,$ttnumber) {

    if ( !file_exists(IMDB_DIR.$ttnumber) ) {

        if ( !mkdir(IMDB_DIR.$ttnumber) ) {
            echo 'Not able to mkdir '.IMDB_DIR.$ttnumber;
            return false;
        }
    }


    if (is_dir(FILM_DIR.$name)) {

        // MOVE ALL FILES IN DIR TO ttnumber DIR
        $otherfiles = scandir(FILM_DIR.$name);

        foreach($otherfiles as $ff) {

            if ($ff != '.' && $ff != '..') {

                $source = FILM_DIR.$name.'/'.$ff;
                $target = IMDB_DIR.$ttnumber.'/'.$ff;

                if (!rename($source,$target)) {
                    echo 'Not able to rename 1 '.$source.' : '.$target;
                    return false;
                }
            }
        }

        rmdir(FILM_DIR.$name);

    } else {

        // IF THIS IS A SINGLE FILE
        $from = FILM_DIR.$name;
        $target = IMDB_DIR.$ttnumber.'/'.$name;

        if ( !rename($from, $target) ) {
            echo 'Not able to rename 2 '.$from.' : '.$target;
            return false;
        }
    }

    return true;
}


function AddNewFilmToDb($imdb,$props) {

    global $mongo,$config;

    // Does this exist in DB?
    $oneItem = $mongo->Query($config->FILM_COLLECTION,["id"=>$imdb],[]);

    if ( count($oneItem) > 0 ) {
        $_id    = $oneItem["0"]->_id;

        if ($mongo->UpdateOne($config->FILM_COLLECTION,$_id,$props)) {
            return true;
        } 
        return false;
    } 

    // New film
    if ($mongo->InsertOne($config->FILM_COLLECTION,$props)) {
        return true;
    }

    return false;
}