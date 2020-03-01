<?php

namespace Webdev\Http\Controllers\Admin;

use Webdev\Models\BlogwdPost;
use Webdev\Models\BlogwdCategory;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Admin\WDBlogBaseController;
use DB;
//use Webdev\Http\Controllers\Controller;

class WDPostController extends WDBlogBaseController
{
    /**
     * Display a list of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.posts.index',[
            'posts'=> BlogwdPost::orderBy('created_at','desc')->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //We've got the whole list of CSS file paths
        $filesCss = $this->getAllFiles("css/additional_css");
        //We've got the whole list of file paths
        $files = $this->getAllFiles("js/additional_js");
        //Model name    
        $model = "Webdev\Models\BlogwdPost";
        return view('admin.posts.create',[
            'firstFiles'=>$this->prepareFilesBeforeCreate($files,0,$model),
            'firstScripts'=>array(),
            'firstCssFiles'=>$this->prepareFilesBeforeCreate($filesCss,0,$model),
            'firstCss'=>array(),
            'post'=> [],
            'categories'=> BlogwdCategory::with('children')->where('parent_id',0)->get(),
            'delimiter'=> ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Model name    
        $model = "Webdev\Models\BlogwdPost";
        $post = BlogwdPost::create($request->all());
        //Get current resource ID from '$post->id'. It is needed for 'blogwd_scripts' table
        $arraToInsert = $this->insertPathsWhenCreated($request->paths, $request->dbscripts, $post->id, $model);
        //If array isn't empty. It means JS file/s was/were added to a resource.
        if(!empty($arraToInsert)){
            //Multiple inserts or one insert it depends on incomind data
            DB::table('blogwd_scripts')->insert($arraToInsert);
        }
        //Get current resource ID from '$post->id'. It is needed for 'blogwd_styles' table
        $arrayToInsertCss = $this->insertPathsWhenCreated($request->pathsCss, array(), $post->id, $model, "css");
        //If array isn't empty. It means JS file/s was/were added to a resource.
        if(!empty($arrayToInsertCss)){
            //Multiple inserts or one insert it depends on incomind data
            DB::table('blogwd_styles')->insert($arrayToInsertCss);
        }
        //Categories
        if($request->input('categories')){
            //Attach fields in database 'blogwd_categoryables'
            $post->categories()->attach($request->input('categories'));
        }
        return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function show(BlogwdPost $blogwdPost)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //We've got the whole list of file paths
        $filesCss = $this->getAllFiles("css/additional_css");
        //We've got the whole list of file paths
        $files = $this->getAllFiles("js/additional_js");
        //
        $post = BlogwdPost::find($id);
        
        //Model name    
        $model = "Webdev\Models\BlogwdPost";
        return view('admin.posts.edit',[
            // ’files’ и  'activeScripts' – данные для Vue компонентов
            'files'=>$this->getUnlikeDBPaths($files,$post->scripts,$id,$model),
            'activeScripts'=>$this->getDbPreparedData($post->scripts),
            // ’filesCss’ и  'activeCss' – данные для Vue компонентов
            'filesCss'=>$this->getUnlikeDBPaths($filesCss,$post->styles,$id,$model),
            'activeCss'=>$this->getDbPreparedData($post->styles,"css"),
            'post' => $post,
            'categories'=> BlogwdCategory::with('children')->where('parent_id',0)->get(),
            'delimiter'=> ''
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'title' => 'required',
            'meta_keywords' => 'required',
            'meta_description' => 'required',
            'description' => 'required',
        ]);
        $post = BlogwdPost::find($id);
            $post->modified_by = $request->get('modified_by');
            $post->published = $request->get('published');
            $post->title = $request->get('title');
            //Detach fields in database 'blogwd_categoryables'
            $post->categories()->detach();
            if($request->get('categories')){
                //Attach fields in database 'blogwd_categoryables' again
                $post->categories()->attach($request->get('categories'));
            }
            $post->meta_description = $request->get('meta_description');
            $post->meta_keywords = $request->get('meta_keywords');
            $post->description = $request->get('description');
            $post->full_text = $request->get('full_text');
        $post->save();
        //Update header_or_footer field in table 'blogwd_scripts'.
        $scripts_h_f = $this->updateScripts($request);
           if(count($scripts_h_f) > 0){
               for($j=0;$j<count($scripts_h_f);$j++){
                   \Webdev\Models\BlogwdScript::where('id',$scripts_h_f[$j]['id'])
                           ->where('scriptable_id',$id)
                           ->update($scripts_h_f[$j]);
                 }
           }   
        return redirect()->route('admin.post.index');
    }
         
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogwdPost::findOrFail($id);
        //Detach fields in database 'blogwd_categoryables'
        $post->categories()->detach();
        //Delete current Post
        $post->delete();
        DB::table('blogwd_scripts')->where('scriptable_id', '=', $id)->delete();
        DB::table('blogwd_styles')->where('styleable_id', '=', $id)->delete();
        return redirect()->route('admin.post.index');
    }
}