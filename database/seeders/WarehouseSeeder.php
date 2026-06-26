<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update warehouses
        $warehouses = [
            [
                'name' => 'Gudang Pusat',
                'code' => 'WH001',
                'address' => 'Jl. Jalan Raya No. 1, Kota A',
                'pic' => 'Budi Santoso',
                'phone' => '081234567890'
            ],
            [
                'name' => 'Gudang Cabang',
                'code' => 'WH002',
                'address' => 'Jl. Jalan Sebelah No. 5, Kota B',
                'pic' => 'Siti Aminah',
                'phone' => '081234567891'
            ],
            [
                'name' => 'Gudang Selatan',
                'code' => 'WH003',
                'address' => 'Jl. Jalan Selatan No. 10, Kota C',
                'pic' => 'Joko Widodo',
                'phone' => '031-55557777'
            ]
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::updateOrCreate(
                ['code' => $warehouse['code']],
                $warehouse
            );
        }
    }
}