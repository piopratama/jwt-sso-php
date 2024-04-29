<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class VegetablesSeed extends AbstractSeed
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
                'user_id' => 1, // Assign vegetables to user 1 (John Doe)
                'name' => 'Carrot',
                'quantity' => 5,
            ],
            [
                'user_id' => 1, // Assign vegetables to user 1 (John Doe)
                'name' => 'Tomato',
                'quantity' => 10,
            ],
            [
                'user_id' => 2, // Assign vegetables to user 2 (Jane Doe)
                'name' => 'Spinach',
                'quantity' => 8,
            ],
            // Add more sample vegetables if needed
        ];

        $vegetables = $this->table('vegetables');
        $vegetables->insert($data)
                   ->save();
    }
}
