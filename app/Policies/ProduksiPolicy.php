<?php

namespace App\Policies;

use App\Models\Produksi;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProduksiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Produksi  $produksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Produksi $produksi)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Produksi  $produksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Produksi $produksi)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Produksi  $produksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Produksi $produksi)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Produksi  $produksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Produksi $produksi)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Produksi  $produksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Produksi $produksi)
    {
        //
    }
}
