<?php

namespace Webdev\Policies;

use Webdev\Models\User;
use Webdev\Models\BlogwdCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogwdCategoryPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any blogwd categories.
     *
     * @param  \Webdev\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the blogwd category.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return mixed
     */
    public function view(User $user, BlogwdCategory $blogwdCategory)
    {
        //
    }

    /**
     * Determine whether the user can create blogwd categories.
     *
     * @param  \Webdev\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the blogwd category.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return mixed
     */
    public function update(User $user, BlogwdCategory $blogwdCategory)
    {
        //
    }

    /**
     * Determine whether the user can delete the blogwd category.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return mixed
     */
    public function delete(User $user, BlogwdCategory $blogwdCategory)
    {
        //
        //$blogwdCategory
        return $user->hasRole("Administrator");
    }

    /**
     * Determine whether the user can restore the blogwd category.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return mixed
     */
    public function restore(User $user, BlogwdCategory $blogwdCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the blogwd category.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdCategory  $blogwdCategory
     * @return mixed
     */
    public function forceDelete(User $user, BlogwdCategory $blogwdCategory)
    {
        //
    }
}
