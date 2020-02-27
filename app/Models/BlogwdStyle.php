<?php

namespace Webdev\Models;

use Illuminate\Database\Eloquent\Model;

class BlogwdStyle extends Model
{
     protected $fillable = [
        'path_css',
        'styleable_id',
        'styleable_type'
    ];
    public $timestamps = false;
    //
    public function styleable(){
        return $this->morphTo();
    }
}
