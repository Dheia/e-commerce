<?php

namespace Wapp\UserConnect\Updates;

use Wapp\UserConnect\Models\Category;
use October\Rain\Database\Updates\Seeder;

class SeedAllTables extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Uncategorized',
            'description' => 'Default Category for subscriptions.'
        ]);
    }
}
