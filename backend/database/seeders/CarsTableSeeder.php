<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car::create([
            'license' => 'CAR-001',
            'brand' => 'BMW - M3',
            'category' => 'Luxury',
            'kilometers' => 50_000,
            'dailyfee' => 150,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-002',
            'brand' => 'Toyota - Corolla',
            'category' => 'Sedan',
            'kilometers' => 50_000,
            'dailyfee' => 50,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-003',
            'brand' => 'Ford - F-150',
            'category' => 'Truck',
            'kilometers' => 50_000,
            'dailyfee' => 70,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-004',
            'brand' => 'Tesla - Model S',
            'category' => 'Electric',
            'kilometers' => 50_000,
            'dailyfee' => 120,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-005',
            'brand' => 'Honda - CR-V',
            'category' => 'SUV',
            'kilometers' => 50_000,
            'dailyfee' => 65,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-006',
            'brand' => 'Mercedes-Benz - C-Class',
            'category' => 'Luxury',
            'kilometers' => 50_000,
            'dailyfee' => 140,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-007',
            'brand' => 'Chevrolet - Silverado',
            'category' => 'Truck',
            'kilometers' => 50_000,
            'dailyfee' => 80,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-008',
            'brand' => 'Audi - A4',
            'category' => 'Sedan',
            'kilometers' => 57_000,
            'dailyfee' => 110,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-009',
            'brand' => 'Nissan - Leaf',
            'category' => 'Electric',
            'kilometers' => 57_000,
            'dailyfee' => 60,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
        Car::create([
            'license' => 'CAR-010',
            'brand' => 'Subaru - Outback',
            'category' => 'SUV',
            'kilometers' => 57_000,
            'dailyfee' => 75,
            'last_maintenance' => 45_000,
            'next_maintenance' => 55_000,
        ]);
    }
}
