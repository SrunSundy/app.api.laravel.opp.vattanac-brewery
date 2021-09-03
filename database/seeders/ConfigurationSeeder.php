<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('Configurations')->insert([
            'config_key' => "my",
            'config_value' => "testing",
            'is_editable' => 1,
        ]);

    }
}
