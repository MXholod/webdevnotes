<?php

namespace Webdev\Models;

use Illuminate\Database\Eloquent\Model;
use Webdev\Models\User;
use Webdev\Models\BlogwdPermission;
class BlogwdRole extends Model
{
    //
    protected $table = 'blogwd_roles';
    //
    public function users(){
        return $this->belongsToMany(User::class,'blogwd_role_user','user_id','role_id');
    }
    
    public function permissions(){
        return $this->belongsToMany(BlogwdPermission::class,'blogwd_permission_role','permission_id','role_id');
    }
}
