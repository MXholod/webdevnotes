<?php

namespace Webdev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDBlogBaseController extends Controller
{
    /**
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
   
}
