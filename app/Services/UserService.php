<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get paginated teachers.
     */
    public function getPaginatedTeachers(int $perPage = 10)
    {
        return User::teachers()->paginate($perPage);
    }

    /**
     * Create a new teacher.
     */
    public function createTeacher(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'teacher',
        ]);
    }

    /**
     * Update a teacher.
     */
    public function updateTeacher(User $user, array $data): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return $user;
    }

    /**
     * Delete a teacher.
     *
     * @throws \Exception
     */
    public function deleteTeacher(User $user): bool
    {
        if ($user->isAdmin()) {
            throw new \Exception('Não é possível remover um administrador.');
        }

        if ($user->classes()->count() > 0) {
            throw new \Exception('Este professor não pode ser removido pois possui turmas associadas.');
        }

        return $user->delete();
    }
}
