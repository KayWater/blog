<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Draft;
use Illuminate\Auth\Access\HandlesAuthorization;

class DraftPolicy
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
     * Whether the user can delete the draft
     * 
     * @param   \App\Models\User   $user
     * @param   \App\Models\Draft   $draft
     * @return  bool
     */
    public function delete(User $user, Draft $draft)
    {
        return intval($user->id) === intval($draft->user_id);
    }
}
