<?php

namespace Webdev\Models;

use Illuminate\Database\Eloquent\Model;

class BlogwdErrorPage extends Model
{
    //Work with Table 'blogwd_error_pages'
    protected $table = 'blogwd_error_pages';
    
    //Get only published using Scope
    public function scopeIsPublished($query){
        return $query->where('published',1);
    }
    //Make relationship with Model 'BlogwdScript'
    public function scripts(){
        return $this->morphMany('Webdev\Models\BlogwdScript', 'scriptable');
    }
}
