<?php

namespace Webdev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDBlogBaseController extends Controller
{
    /**
     * Using this method in 'edit()' method of the child Controller 
     * Find all files relatively to the specified directory
     * and pack into an array with offset if their nested
     * 
     * @param  $dir - Initial directory as a string
     * @return array
     */
    protected function getAllFiles($dir){
        if(!is_dir($dir))return [];
        $files = [];
        $i = 0;
        //Closure function using in reqursion
        $recursion = function($dir) use (&$files,&$i,&$recursion){
            if ($handle = opendir($dir)) {
              //While directory has entities do the loop
              while (false !== ($entry = readdir($handle))) {
                  //Check '.' or '..'
                  if ($entry == "." OR $entry == "..") {
                      continue;
                  }
                  //If it's a directory call a recursion
                  if(is_dir($dir. '/' .$entry)){
                       if (is_callable($recursion)) {
                           $recursion($dir. '/' .$entry);
                       }
                  }else{
                      $files[$i] = $dir. '/' .$entry;
                  }
                  $i++;
              }
              closedir($handle);
            }  
        };
        // GET PUBLIC FOLDER FILES (NAME)
        if ($handle = opendir(public_path($dir))) {
            //While directory has entities do the loop
            while (false !== ($entry = readdir($handle))) {
                //Check '.' or '..'
                if ($entry == "." OR $entry == "..") {
                    continue;
                }
                //If it's a directory call a recursion
                if(is_dir($dir. '/' .$entry)){
                    if (is_callable($recursion)) {
                        $recursion($dir. '/' .$entry);
                    }
                }else{
                    $files[$i] = $dir. '/' .$entry;
                }
                $i++;
            }
            closedir($handle);
        }
        return $files;
    }
    /**
     * This method prepare paths of files those are bound with newly created Resource by ID ($idResource)
     * 
     * @param $paths - are paths of files
     * @param $h_f - 0/1 - header/footer values
     * @param $idResource - is a ID of current resource that is created
     * @param $model - the Model that is using in the Controller 
     * @return array [] of prepared data before insert, or array of arrays [[],[],[]]
     */
    protected function insertPathsWhenCreated($paths,$h_f,$idResource,$model){
        $result_arr = array();
        if(empty($paths)){
            return $result_arr;
        }
        //If only one insert
        if(count($paths) == 1){
            $result_arr['path_js'] = $paths[0];
            $result_arr['header_or_footer'] = $h_f[0];
            $result_arr['scriptable_id'] = $idResource;
            $result_arr['scriptable_type'] = $model;
        }else{//If multiple inserts
            $each_insert = array();
            for($i = 0;count($paths) > $i; $i++){
                $each_insert['path_js'] = $paths[$i];
                $each_insert['header_or_footer'] = $h_f[$i];
                $each_insert['scriptable_id'] = $idResource;
                $each_insert['scriptable_type'] = $model;
                $result_arr[$i] = $each_insert; 
            }
        }
        return $result_arr;
    }
    /**
     * Using this method in 'create()' method of the child Controller.
     * 
     * @param $arrFilePaths - array of file paths
     * @param $id - current ID of the resorce
     * @param $model - the Model that is using in the Controller
     * @return array of arrays like - [['id'=>3,'model'=>'model'],[],[]]
     */
    protected function prepareFilesBeforeCreate($arrFilePaths,$id,$model){
        
        $preparedFilePaths = [];
        //
        foreach($arrFilePaths as $pathFile){
            $itemPathsInDb['id'] = $id;
            $itemPathsInDb['model'] = $model;
            $itemPathsInDb['path'] = $pathFile;
            
            $preparedFilePaths[] = $itemPathsInDb;
        }
        return $preparedFilePaths;
    }
    /**
     * Using this method in 'edit()' method of the child Controller.
     * Get paths which don't exist in Database to display them in the file block
     * 
     * @param $arrFilePaths - array of file paths
     * @param $arrDBPaths - array of databases paths
     * @param $id - current ID of the resorce
     * @param $model - the Model that is using in the Controller
     * @return array of unique
     */
    protected function getUnlikeDBPaths($arrFilePaths,$arrDBPaths,$id,$model){
        $allPathsInDb = array();
        //Prepare array from Model class for array_diff() function
        foreach($arrDBPaths as $dbpath){
            $allPathsInDb[] = $dbpath->path_js;
        }
        //Get only unique paths for file paths block
        $pathsAreNotInDb = array_diff($arrFilePaths,$allPathsInDb);
        
        $preparedFilePaths = [];
        //Prepare array from Model class for array_diff() function
        foreach($pathsAreNotInDb as $pathFile){
            $itemPathsInDb['id'] = $id;
            $itemPathsInDb['model'] = $model;
            $itemPathsInDb['path'] = $pathFile;
            
            $preparedFilePaths[] = $itemPathsInDb;
        }
        return $preparedFilePaths;
    }
    /**
     * Using this method in 'edit()' method of the child Controller. 
     * Prepare data from DB (ORM type) to an Array
     * 
     * @param  $arrDBPaths - Rows from the DB Table according to the current Model
     * @return array
     */
    protected function getDbPreparedData($arrDBPaths){
        $allPathsInDb = array();$i=0;
        foreach($arrDBPaths as $dbDataRow){
            $allPathsInDb[$i]['id'] = $dbDataRow->id;
            $allPathsInDb[$i]['path_js'] = $dbDataRow->path_js;
            $allPathsInDb[$i]['header_or_footer'] = $dbDataRow->header_or_footer;
            $allPathsInDb[$i]['scriptable_id'] = $dbDataRow->scriptable_id;
            $allPathsInDb[$i]['scriptable_type'] = $dbDataRow->scriptable_type;
            $i++;
        }
        return $allPathsInDb;
    }
    /**
     * Using this method in 'update(Request $request, $id)' method of the child Controller. 
     * Prepare data depending on Request and make an Array for multiple Update
     * 
     * @param  $request from URI
     * @return array [
     *      ['id'=>2,'header_or_footer'=>0],
     *      ['id'=>5,'header_or_footer'=>1]
     *   ]
     */
    protected function updateScripts($request){
        if(!is_array($request->get('dbscripts')) || !is_arrray($request->get('ids'))){
            return [];
        }
         //Update 'JScript' items
        if(((count($request->get('dbscripts'))!== 0) && (count($request->get('ids')) !== 0)) &&
               ((count($request->get('dbscripts')) == count($request->get('ids'))))
        ){
          $arr_ids = $request->get('ids');
          $arr_h_f = $request->get('dbscripts');
          foreach($arr_ids as $row_id){
            $result_arr[]['id'] = $row_id;  
          }
          $i_row = 0;
          foreach($arr_h_f as $h_f){
            $result_arr[$i_row]['header_or_footer'] = $h_f;  
            $i_row++;
          }
       }else{
           //"JScript items are not exist";
           $result_arr = [];
       }
       return $result_arr;
    }
   
}
