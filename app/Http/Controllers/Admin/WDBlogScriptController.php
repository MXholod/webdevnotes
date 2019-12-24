<?php

namespace Webdev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

use DB;

class WDBlogScriptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Check method
        if($request->isMethod('post')){
            //Get item to transfer data into the DB
            $itemObject = json_decode($request->input('body'));
            //Prepare data before insert
            $data = [
                'path_js'=>$itemObject->path,
                'header_or_footer'=>$itemObject->h_f,
                'scriptable_id'=>$itemObject->model_id,
                'scriptable_type'=>$itemObject->model
            ];
            //Get the last id
            $lastId = DB::table("blogwd_scripts")->insertGetId($data);
            return response()->json(['id' => $lastId]);
        }else{
            return json_encode(['method' => 'Unknown']);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete table row by ID
        $id = DB::table("blogwd_scripts")->where('id', '=', $id)->delete();
        return json_encode(["id"=>$id]);
    }
}
