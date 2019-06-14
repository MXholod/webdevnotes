<?php

namespace Webdev\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogwdCategory extends Model
{
    //White list - for recording
    protected $fillable = ['title','description','slug','parent_id','published','created_by','modified_by'];
    
    //Mutators prepare field's value before save into DB 
    //Here we create 'slug' from 'title' automatically
    public function setSlugAttribute($value){
        $this->attributes['slug'] = Str::slug(mb_substr($this->title,0,40).
                "-".\Carbon\Carbon::now()->format('dmyHi'),'-'); 
    }
    
    //Get children Category. Relationship.
    public function children(){
       /**
        * @param  'Webdev\BlogwdCategory' or self::class - is a Namspace of the Model
        * @param  'parent_id' - field is being searched for nested categories
        * @return 
        */
       return $this->hasMany(self::class,'parent_id'); 
    }
}
