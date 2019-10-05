<?php

namespace Webdev\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Webdev\Models\BlogwdRole;
use Illuminate\Support\Str;
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    /**
     * New Model name is 'wdusers'
     */
    protected $table = "wdusers";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //Relation User with Roles
    public function roles(){
        return $this->belongsToMany(BlogwdRole::class,'blogwd_role_user','user_id','role_id');
    }
    /**
     * The parameters are:
     * @permission - a String or an Array 
     * @$require - false by default. It works when first parameter is an array 
     * @return bollean
     */
    public function canDo($permission,$require = false){//Has permissions
        if(is_array($permission)){
            foreach($permission as $permName){
                $permName = $this->canDo($permName);
                if($permName && !$require){
                    return true;
                }else if(!$permName && $require){
                    return false;
                }
            }
            return $require;
        }else{
            foreach($this->roles as $role){
                foreach($role->permissions()->get() as $perm){//$perm - is a Model of previlege
                    if(Str::is($permission, $perm->name)){//Name of a previlege
                        return true;
                    }
                }
            }
        }
    }
    public function hasRole($name, $require = false){
        if(is_array($name)){
            foreach($name as $roleName){
                $hasRole = $this->hasRole($roleName);
                if($hasRole && !$require){
                    return true;
                }
                else if(!$hasRole && $require){
                    return false;
                }
            }
            return $require;
        }else{
            foreach($this->roles as $role){
                if($role->name == $name){
                    return true;
                }
            }
        }
    }
}
