<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions using firstOrCreate to avoid duplicates
        $permissions = [
            // Product permissions
            ['name' => 'products.index', 'guard_name' => 'web'],
            ['name' => 'products.create', 'guard_name' => 'web'],
            ['name' => 'products.edit', 'guard_name' => 'web'],
            ['name' => 'products.delete', 'guard_name' => 'web'],
            ['name' => 'products.view-stock', 'guard_name' => 'web'],

            // Category permissions
            ['name' => 'categories.index', 'guard_name' => 'web'],
            ['name' => 'categories.create', 'guard_name' => 'web'],
            ['name' => 'categories.edit', 'guard_name' => 'web'],
            ['name' => 'categories.delete', 'guard_name' => 'web'],

            // Brand permissions
            ['name' => 'brands.index', 'guard_name' => 'web'],
            ['name' => 'brands.create', 'guard_name' => 'web'],
            ['name' => 'brands.edit', 'guard_name' => 'web'],
            ['name' => 'brands.delete', 'guard_name' => 'web'],

            // Unit permissions
            ['name' => 'units.index', 'guard_name' => 'web'],
            ['name' => 'units.create', 'guard_name' => 'web'],
            ['name' => 'units.edit', 'guard_name' => 'web'],
            ['name' => 'units.delete', 'guard_name' => 'web'],

            // Warehouse permissions
            ['name' => 'warehouses.index', 'guard_name' => 'web'],
            ['name' => 'warehouses.create', 'guard_name' => 'web'],
            ['name' => 'warehouses.edit', 'guard_name' => 'web'],
            ['name' => 'warehouses.delete', 'guard_name' => 'web'],

            // Product Stock permissions
            ['name' => 'product-stocks.index', 'guard_name' => 'web'],
            ['name' => 'product-stocks.create', 'guard_name' => 'web'],
            ['name' => 'product-stocks.edit', 'guard_name' => 'web'],
            ['name' => 'product-stocks.delete', 'guard_name' => 'web'],

            // Stock Mutation permissions
            ['name' => 'stock-mutations.index', 'guard_name' => 'web'],
            ['name' => 'stock-mutations.create', 'guard_name' => 'web'],
            ['name' => 'stock-mutations.approve', 'guard_name' => 'web'],
            ['name' => 'stock-mutations.delete', 'guard_name' => 'web'],

            // Customer permissions
            ['name' => 'customers.index', 'guard_name' => 'web'],
            ['name' => 'customers.create', 'guard_name' => 'web'],
            ['name' => 'customers.edit', 'guard_name' => 'web'],
            ['name' => 'customers.delete', 'guard_name' => 'web'],

            // Supplier permissions
            ['name' => 'suppliers.index', 'guard_name' => 'web'],
            ['name' => 'suppliers.create', 'guard_name' => 'web'],
            ['name' => 'suppliers.edit', 'guard_name' => 'web'],
            ['name' => 'suppliers.delete', 'guard_name' => 'web'],

            // Purchase permissions
            ['name' => 'purchases.index', 'guard_name' => 'web'],
            ['name' => 'purchases.create', 'guard_name' => 'web'],
            ['name' => 'purchases.receive', 'guard_name' => 'web'],
            ['name' => 'purchases.delete', 'guard_name' => 'web'],

            // Sales permissions
            ['name' => 'sales.index', 'guard_name' => 'web'],
            ['name' => 'sales.create', 'guard_name' => 'web'],
            ['name' => 'sales.delete', 'guard_name' => 'web'],

            // POS permissions
            ['name' => 'pos.access', 'guard_name' => 'web'],
            ['name' => 'pos.checkout', 'guard_name' => 'web'],

            // Transfer permissions
            ['name' => 'transfers.index', 'guard_name' => 'web'],
            ['name' => 'transfers.create', 'guard_name' => 'web'],
            ['name' => 'transfers.approve', 'guard_name' => 'web'],

            // Cash Transaction permissions
            ['name' => 'cash-transactions.index', 'guard_name' => 'web'],
            ['name' => 'cash-transactions.create', 'guard_name' => 'web'],

            // Report permissions
            ['name' => 'reports.view', 'guard_name' => 'web'],

            // Settings permissions
            ['name' => 'settings.view', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Create roles and assign permissions (check if they exist first)
        $superadmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $superadmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin-toko', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'products.index', 'products.create', 'products.edit', 'products.delete', 'products.view-stock',
            'categories.index', 'categories.create', 'categories.edit', 'categories.delete',
            'brands.index', 'brands.create', 'brands.edit', 'brands.delete',
            'units.index', 'units.create', 'units.edit', 'units.delete',
            'warehouses.index', 'warehouses.create', 'warehouses.edit', 'warehouses.delete',
            'product-stocks.index', 'product-stocks.create', 'product-stocks.edit', 'product-stocks.delete',
            'stock-mutations.index', 'stock-mutations.create', 'stock-mutations.approve', 'stock-mutations.delete',
            'customers.index', 'customers.create', 'customers.edit', 'customers.delete',
            'suppliers.index', 'suppliers.create', 'suppliers.edit', 'suppliers.delete',
            'purchases.index', 'purchases.create', 'purchases.receive', 'purchases.delete',
            'sales.index', 'sales.create', 'sales.delete',
            'pos.access', 'pos.checkout',
            'transfers.index', 'transfers.create', 'transfers.approve',
            'cash-transactions.index', 'cash-transactions.create',
            'reports.view',
            'settings.view',
        ]);

        $kasir = Role::firstOrCreate(['name' => 'kasir', 'guard_name' => 'web']);
        $kasir->givePermissionTo([
            'pos.access', 'pos.checkout',
            'products.view-stock',
            'customers.index',
            'reports.view',
        ]);
    }
}
