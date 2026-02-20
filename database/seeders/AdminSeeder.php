<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $name = env('ADMIN_NAME');
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (app()->environment('production') && !$password) {
            throw new \RuntimeException('Пароль администратора не должен быть пустым!');
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name ?? 'Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Администратор создан успешно.');
    }
}
