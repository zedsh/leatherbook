<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SeedTestUsers extends Command
{
    protected $signature = 'seed:production-users';
    protected $description = 'Create 10 test users with password 123456';

    public function handle(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name'     => "Test User {$i}",
                'email'    => "user{$i}@test.com",
                'password' => Hash::make('123456'),
            ]);
        }

        $this->info('10 test users created successfully.');
        $this->table(
            ['Name', 'Email', 'Password'],
            collect(range(1, 10))->map(fn($i) => ["Test User {$i}", "user{$i}@test.com", '123456'])
        );
    }
}
