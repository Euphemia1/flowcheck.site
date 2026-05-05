<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Define roles
        $roles = [
            'super_admin' => 'Platform Super Admin',
            'org_admin' => 'Organisation Administrator',
            'procurement_officer' => 'Procurement Officer',
            'requester' => 'Purchase Requester',
            'approver' => 'Approver / Manager',
            'cfo' => 'CFO / Finance',
            'warehouse_keeper' => 'Warehouse / Store Keeper',
            'vendor' => 'External Vendor',
            'auditor' => 'Auditor',
        ];

        // Define permissions
        $permissions = [
            'create_purchase_requests',
            'edit_purchase_requests',
            'approve_purchase_requests',
            'reject_purchase_requests',
            'create_vendors',
            'update_vendors',
            'approve_vendors',
            'create_invoices',
            'update_invoices',
            'approve_invoices',
            'view_audit_logs',
            'manage_workflows',
            'manage_users',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $orgAdminRole = Role::firstOrCreate(['name' => 'org_admin']);
        $orgAdminRole->givePermissionTo([
            'manage_users',
            'manage_workflows',
            'create_vendors',
            'update_vendors',
            'approve_vendors',
            'view_audit_logs',
        ]);

        $procOfficerRole = Role::firstOrCreate(['name' => 'procurement_officer']);
        $procOfficerRole->givePermissionTo([
            'create_purchase_requests',
            'edit_purchase_requests',
            'create_vendors',
            'update_vendors',
            'create_invoices',
        ]);

        $requesterRole = Role::firstOrCreate(['name' => 'requester']);
        $requesterRole->givePermissionTo([
            'create_purchase_requests',
            'edit_purchase_requests',
        ]);

        $approverRole = Role::firstOrCreate(['name' => 'approver']);
        $approverRole->givePermissionTo([
            'approve_purchase_requests',
            'reject_purchase_requests',
        ]);

        $cfoRole = Role::firstOrCreate(['name' => 'cfo']);
        $cfoRole->givePermissionTo([
            'approve_purchase_requests',
            'reject_purchase_requests',
            'approve_invoices',
            'view_audit_logs',
        ]);

        $warehouseRole = Role::firstOrCreate(['name' => 'warehouse_keeper']);
        // GRN creation permissions would be added here

        $vendorRole = Role::firstOrCreate(['name' => 'vendor']);
        // Vendor portal permissions

        $auditorRole = Role::firstOrCreate(['name' => 'auditor']);
        $auditorRole->givePermissionTo(['view_audit_logs']);
    }
}
