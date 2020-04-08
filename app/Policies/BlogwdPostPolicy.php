<?php

namespace Webdev\Policies;

use Webdev\Models\User;
use Webdev\Models\BlogwdPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogwdPostPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any blogwd posts.
     *
     * @param  \Webdev\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the blogwd post.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return mixed
     */
    public function view(User $user, BlogwdPost $blogwdPost)
    {
        //
    }

    /**
     * Determine whether the user can create blogwd posts.
     *
     * @param  \Webdev\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the blogwd post.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return mixed
     */
    public function update(User $user, BlogwdPost $blogwdPost)
    {
        //
    }

    /**
     * Determine whether the user can delete the blogwd post.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return mixed
     */
    public function delete(User $user, BlogwdPost $blogwdPost)
    {
        return $user->hasRole("Administrator");
    }

    /**
     * Determine whether the user can restore the blogwd post.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return mixed
     */
    public function restore(User $user, BlogwdPost $blogwdPost)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the blogwd post.
     *
     * @param  \Webdev\Models\User  $user
     * @param  \Webdev\Models\BlogwdPost  $blogwdPost
     * @return mixed
     */
    public function forceDelete(User $user, BlogwdPost $blogwdPost)
    {
        //
    }
}
