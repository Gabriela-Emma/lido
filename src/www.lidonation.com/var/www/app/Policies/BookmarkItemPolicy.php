<?php

namespace App\Policies;

use App\Models\BookmarkItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BookmarkItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, BookmarkItem $bookmarkItem)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, BookmarkItem $bookmarkItem)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(?User $user, BookmarkItem $bookmarkItem)
    {
        if ($user === null) {
            return Response::allow();
        }
        $inLastTenMins = now()->diffInMinutes($bookmarkItem->collection->created_at) < 10;
        $isOwner = $user->id === $bookmarkItem->collection->user_id;
        
        return $inLastTenMins && $isOwner ? Response::allow() : Response::deny('You do not own this collection.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, BookmarkItem $bookmarkItem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, BookmarkItem $bookmarkItem)
    {
        //
    }
}
