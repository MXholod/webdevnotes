<?php

namespace Webdev\Models;

use Illuminate\Database\Eloquent\Model;

class BlogwdScript extends Model
{
    protected $fillable = [
        'path_js',
        'header_or_footer',
        'scriptable_id',
        'scriptable_type'
    ];
    public $timestamps = false;
    //
    public function scriptable()
    {
        return $this->morphTo();
    }
}
