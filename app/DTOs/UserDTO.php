<?php

namespace App\DTOs;

class UserDTO
{
    public function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly ?string $password = null,
    ) {}

    public function toArray(): array {
        $data = [
            'name' => $this->username,
            'email' => $this->email
        ];
        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }
        return $data;
    }
}
