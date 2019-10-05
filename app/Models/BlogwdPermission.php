<?php

namespace Webdev\Models;

use Illuminate\Database\Eloquent\Model;
use Webdev\Models\BlogwdRole;
class BlogwdPermission extends Model
{
    //
    protected $table = 'blogwd_permissions';
    //
    public function roles(){
        return $this->belongsToMany(BlogwdRole::class,'blogwd_permission_role','role_id','permission_id');
    }
}
