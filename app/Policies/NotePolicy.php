<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  User  $user
     * @return void|bool
     */
    public function before(User $user)
    {
        if ($user->permissions->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->permissions->notes;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Note  $note
     * @return Response|bool
     */
    public function view(User $user, Note $note): Response|bool
    {
        return ($this->viewAny($user)) && ($user->id === $note->user_id || $note->user->contains($user->id));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Note  $note
     * @return Response|bool
     */
    public function update(User $user, Note $note): Response|bool
    {
        return $this->view($user, $note);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Note  $note
     * @return Response|bool
     */
    public function delete(User $user, Note $note): Response|bool
    {
        return $this->view($user, $note);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Note  $note
     * @return Response|bool
     */
    public function restore(User $user, Note $note): Response|bool
    {
        return $this->view($user, $note);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Note  $note
     * @return Response|bool
     */
    public function forceDelete(User $user, Note $note): Response|bool
    {
        return $user->id === $note->user_id;
    }
}
