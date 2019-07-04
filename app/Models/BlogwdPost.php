<?php

namespace Webdev\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogwdPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'full_text',
        'image',
        'image_show',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published',
        'created_by',
        'modified_by'
    ];
    
    //Mutators prepare field's value before save into DB 
    //Here we create 'slug' from 'title' automatically
    public function setSlugAttribute($value){
        $this->attributes['slug'] = Str::slug(mb_substr($this->title,0,40).
                "-".\Carbon\Carbon::now()->format('dmyHi'),'-'); 
    }
    
    //Polymorphic relation with Categories
    public function categories(){
        return $this->morphToMany('Webdev\Models\BlogwdCategory','blogwd_categoryable');//categoryable
    }
    
    public function scopeLastPosts($query, $count){
        return $query->orderBy('created_at','desc')->take($count)->get();
    }
}
