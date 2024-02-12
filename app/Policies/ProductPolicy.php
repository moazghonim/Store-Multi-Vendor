<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *

     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        return $user->HasAbility('products.index');
    }

    /**
     * Determine whether the user can view the model.

     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, Product $product)
    {
        return $user->HasAbility('products.index') && $product->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can create models.
     *

     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        return $user->HasAbility('products.create');
    }

    /**
     * Determine whether the user can update the model.
     *

     * @param  \App\Models\Prodcut  $prodcut
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, Product $product)
    {
        return $user->HasAbility('products.update') && $product->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     *
     * @param  \App\Models\Prodcut  $prodcut
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, Product $product)
    {
        return $user->HasAbility('products.delete') && $product->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can restore the model.
     *

     * @param  \App\Models\Prodcut  $prodcut
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Prodcut  $prodcut
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, Product $product)
    {
        //
    }
}
