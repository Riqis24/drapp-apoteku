<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Umum',
            'phone' => '-',
            'address' => '-',
            'total_outstanding' => 0,
            'isvisible' => 1,
            'type' => 'Reguler'
        ]);

        Customer::create([
            'name' => 'Riqi Saputra',
            'phone' => '088135749642',
            'address' => 'Jl. Merdeka No. 123',
            'total_outstanding' => 0,
            'isvisible' => 0,
            'type' => 'Member'
        ]);

        // Customer::factory()->count(100)->create(); // generate 10 data customer


    }
}
