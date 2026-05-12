<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Exceptions\NoSuchException;
use Illuminate\Database\QueryException;

class UserRepository implements UserRepositoryInterface
{
    public function getById(int $id): User
    {
        $user = User::find($id);
        if (!$user) {
            throw new NoSuchException("User with ID {$id} not found.");
        }
        return $user;
    }


    public function save(array $data, ?int $id = null): User {
        return User::updateOrCreate(['id' => $id], $data);
    }

    public function delete(int $id): bool {
        return User::destroy($id);
    }

    public function getAll() {
        return User::paginate(10);
    }
}
