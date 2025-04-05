<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create {email} {name?} {--p|password=}';
    protected $description = 'Create a new admin user';

    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name') ?? 'Admin User';
        $password = $this->option('password') ?? 'password';

        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            $existingUser->update(['role' => 'admin']);
            $this->info("User {$email} has been upgraded to admin");
        } else {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            $this->info("Admin user {$email} created successfully");
        }
    }
}