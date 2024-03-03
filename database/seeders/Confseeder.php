<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuration;


class ConfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = array(
            [
                'name'      => 'AFG_TAX',
                'value'     => 'AFG_TAX, 0.1',
            ]
        );
    
        Configuration::insert($data);

    }
    

}
