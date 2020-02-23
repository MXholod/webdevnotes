<?php

namespace Webdev\Models;

use Illuminate\Database\Eloquent\Model;

class BlogwdStaticPage extends Model
{
    //Work with Table 'blogwd_static_pages'
    protected $table = 'blogwd_static_pages';
    
    //Get only published using Scope
    public function scopeIsPublished($query){
        return $query->where('published',1);
    }
    //Make relationship with Model 'BlogwdScript'
    public function scripts(){
        return $this->morphMany('Webdev\Models\BlogwdScript', 'scriptable');
    }
}
