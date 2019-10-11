<?php
use Migrations\AbstractMigration;

class Setup extends AbstractMigration
{
    public function up()
    {
        $this->table('tasks')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('is_complete', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('completed', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'completed',
                ]
            )
            ->create();

        // Generate some data!
        $faker = \Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $createdAndModified = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');
            $isComplete = $faker->boolean(30);

            $row = [
                'name' => $faker->realText(80),
                'is_complete' => $isComplete,
                'created' => $createdAndModified,
                'modified' => $createdAndModified
            ];

            if ($isComplete) {
                $row['completed'] = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');
            }

            $data[] = $row;
        }

        $this->table('tasks')
            ->insert($data)
            ->save();
    }

    public function down()
    {
        $this->table('tasks')->drop()->save();
    }
}
