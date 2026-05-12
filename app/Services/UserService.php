<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepo
    ) {}

    public function createUser(UserDTO $dto) {
        try {
            return $this->userRepo->save($dto->toArray());
        } catch (Exception $e) {
            throw new NoSuchException("Database error: Unable to create user.");
        }
    }

    public function updateUser(int $id, UserDTO $dto) {
        try {
            return $this->userRepo.save($dto->toArray(), $id);
        } catch (ModelNotFoundException $e) {
            throw new NoSuchException("User with ID $id not found.");
        }
    }

    public function findUser(int $id) {
        try {
            return $this->userRepo.getById($id);
        } catch (ModelNotFoundException $e) {
            throw new NoSuchException("User not found.");
        }
    }

    public function deleteUser(int $id) {
        return $this->userRepo.delete($id);
    }

    public function listUsers() {
        return $this->userRepo.getAll();
    }
}
