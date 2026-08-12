<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findByUsernameOrEmail(string $loginInput)
    {
        return $this->groupStart()
                    ->where('username', $loginInput)
                    ->orWhere('email', $loginInput)
                    ->groupEnd()
                    ->where('is_active', 1)
                    ->first();
    }
}
