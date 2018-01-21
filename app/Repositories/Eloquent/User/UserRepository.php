<?php

namespace App\Repositories\Eloquent\user;

use App;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\User\UserRepositoryInterface;
use App\User;

/**
 * Laravel 5 Repositories is used to abstract the data layer, making our application more flexible to maintain.
 *
 * The Abstract Repository provides default implementations of the methods defined
 * in the base repository interface. These simply delegate static function calls 
 * to the right eloquent model based on the $modelClassName.
 *  
 * I usually use something more complex(package) : https://github.com/andersao/l5-repository
 *
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    private $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function userAcount()
    {
        return $this->user->whereId(auth()->id());
    }

    public function updateAcount($userData)
    {
        return $this->user->whereId(auth()->id())
            ->where('updated_at', '=', auth()->user()->updated_at)
            ->update($userData);
    }
}
