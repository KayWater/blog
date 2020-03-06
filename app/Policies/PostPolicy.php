<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Whether the user can delete the post
     * 
     * @param   \App\Models\User   $user
     * @param   \App\Models\Post   $post
     * @return  bool
     */
    public function delete(User $user, Post $post)
    {
        return intval($user->id) === intval($post->user_id);
    }

    /**
     * Wheter the user can update the post
     * 
     * @param   \App\Models\User    $user
     * @param   \App\Models\Post    $post
     * @return  bool
     */
    public function update(User $user, Post $post)
    {
        return intval($user->id) === intval($post->user_id);
    }
}
