<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'dashboard',
            'admin-dashboard',
            'staff-dashboard',

            'show-invoices-statistics-dashboard',
            'show-clients-statistics-dashboard',

            'users-roles',
            'show-users',
            'add-users',
            'edit-users',
            'delete-users',

            'show-roles',
            'add-roles',
            'edit-roles',
            'delete-roles',

            'settings',
            'show-sections',
            'add-sections',
            'edit-sections',
            'delete-sections',

            'show-products',
            'add-products',
            'edit-products',
            'delete-products',

            'invoices',
            'add-invoices',
            'show-all-invoices',
            'edit-invoices',
            'delete-invoices',
            'export-invoices',

            'show-unpaid-invoices',
            'export-unpaid-invoices',

            'show-paid-invoices',
            'export-paid-invoices',

            'show-partially-paid-invoices',
            'export-partially-paid-invoices',

            'show-archived-invoices',
            'restore-archived-invoices',
            'export-archived-invoices',

            'paid-invoice-details',
            'partially-paid-invoice-details',
            'unpaid-invoice-details',

            'print-invoices',
            'chnage-invoices-status',
            'upload-files',
            'delete-uploaded-files',

            'reports',
            'show-invoices-reports',
            'show-clients-reports',

            'show-audit-trail',

         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

    }
}
