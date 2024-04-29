<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'google_id' => null,
            ],
            [
                'username' => 'jane_doe',
                'email' => 'jane@example.com',
                'password' => password_hash('password456', PASSWORD_DEFAULT),
                'google_id' => null,
            ],
            // Add more sample users if needed
        ];

        $users = $this->table('users');
        $users->insert($data)
              ->save();
    }
}
