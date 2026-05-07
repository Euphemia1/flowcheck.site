<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Purchase Requests
            'create_purchase_requests', 'view_purchase_requests', 'update_purchase_requests',
            'delete_purchase_requests', 'submit_purchase_requests', 'approve_purchase_requests',
            'reject_purchase_requests',
            // Purchase Orders
            'create_purchase_orders', 'view_purchase_orders', 'update_purchase_orders',
            'approve_purchase_orders', 'cancel_purchase_orders',
            // RFQs
            'create_rfqs', 'view_rfqs', 'update_rfqs', 'send_rfqs', 'close_rfqs',
            // GRNs
            'create_grns', 'view_grns', 'update_grns',
            // Invoices
            'create_invoices', 'view_invoices', 'update_invoices', 'approve_invoices', 'reject_invoices',
            // Vendors
            'create_vendors', 'view_vendors', 'update_vendors', 'approve_vendors',
            // Contracts
            'create_contracts', 'view_contracts', 'update_contracts', 'close_contracts',
            // Tenders
            'create_tenders', 'view_tenders', 'update_tenders', 'publish_tenders', 'close_tenders',
            // BOQs
            'create_boqs', 'view_boqs', 'update_boqs',
            // Budgets
            'view_budgets', 'manage_budgets',
            // Reports
            'view_reports', 'export_reports',
            // Settings
            'manage_settings', 'manage_users',
            // Audit
            'view_audit_logs',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // super_admin — all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // org_admin
        $orgAdmin = Role::firstOrCreate(['name' => 'org_admin', 'guard_name' => 'web']);
        $orgAdmin->syncPermissions([
            'create_purchase_requests','view_purchase_requests','update_purchase_requests','delete_purchase_requests','submit_purchase_requests','approve_purchase_requests','reject_purchase_requests',
            'create_purchase_orders','view_purchase_orders','update_purchase_orders','approve_purchase_orders','cancel_purchase_orders',
            'create_rfqs','view_rfqs','update_rfqs','send_rfqs','close_rfqs',
            'create_grns','view_grns','update_grns',
            'create_invoices','view_invoices','update_invoices','approve_invoices','reject_invoices',
            'create_vendors','view_vendors','update_vendors','approve_vendors',
            'create_contracts','view_contracts','update_contracts','close_contracts',
            'create_tenders','view_tenders','update_tenders','publish_tenders','close_tenders',
            'create_boqs','view_boqs','update_boqs',
            'view_budgets','manage_budgets',
            'view_reports','export_reports',
            'manage_settings','manage_users','view_audit_logs',
        ]);

        // procurement_officer
        $procOfficer = Role::firstOrCreate(['name' => 'procurement_officer', 'guard_name' => 'web']);
        $procOfficer->syncPermissions([
            'create_purchase_requests','view_purchase_requests','update_purchase_requests','submit_purchase_requests',
            'create_purchase_orders','view_purchase_orders','update_purchase_orders',
            'create_rfqs','view_rfqs','update_rfqs','send_rfqs',
            'create_grns','view_grns',
            'create_invoices','view_invoices',
            'create_vendors','view_vendors','update_vendors',
            'view_contracts','view_tenders','view_boqs','create_boqs','update_boqs',
            'view_budgets','view_reports',
        ]);

        // procurement_manager
        $procManager = Role::firstOrCreate(['name' => 'procurement_manager', 'guard_name' => 'web']);
        $procManager->syncPermissions([
            'view_purchase_requests','approve_purchase_requests','reject_purchase_requests',
            'create_purchase_orders','view_purchase_orders','update_purchase_orders','approve_purchase_orders','cancel_purchase_orders',
            'create_rfqs','view_rfqs','update_rfqs','send_rfqs','close_rfqs',
            'create_grns','view_grns','update_grns',
            'view_invoices',
            'view_vendors','approve_vendors',
            'create_contracts','view_contracts','update_contracts','close_contracts',
            'create_tenders','view_tenders','update_tenders','publish_tenders','close_tenders',
            'create_boqs','view_boqs','update_boqs',
            'view_budgets','view_reports','export_reports',
        ]);

        // finance_officer
        $financeOfficer = Role::firstOrCreate(['name' => 'finance_officer', 'guard_name' => 'web']);
        $financeOfficer->syncPermissions([
            'view_purchase_requests','view_purchase_orders',
            'create_grns','view_grns','update_grns',
            'create_invoices','view_invoices','update_invoices',
            'view_vendors','view_contracts',
            'view_budgets','view_reports',
        ]);

        // cfo
        $cfo = Role::firstOrCreate(['name' => 'cfo', 'guard_name' => 'web']);
        $cfo->syncPermissions([
            'view_purchase_requests','approve_purchase_requests',
            'view_purchase_orders','approve_purchase_orders',
            'view_grns',
            'view_invoices','approve_invoices','reject_invoices',
            'view_vendors','view_contracts',
            'view_budgets','manage_budgets',
            'view_reports','export_reports','view_audit_logs',
        ]);

        // department_head
        $deptHead = Role::firstOrCreate(['name' => 'department_head', 'guard_name' => 'web']);
        $deptHead->syncPermissions([
            'view_purchase_requests','approve_purchase_requests','reject_purchase_requests',
            'view_purchase_orders','view_invoices','view_vendors',
            'view_budgets','view_reports',
        ]);

        // vendor_portal (read-only placeholder)
        $vendorPortal = Role::firstOrCreate(['name' => 'vendor_portal', 'guard_name' => 'web']);
        $vendorPortal->syncPermissions(['view_rfqs','view_purchase_orders']);

        // viewer
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
        $viewer->syncPermissions([
            'view_purchase_requests','view_purchase_orders','view_rfqs','view_grns',
            'view_invoices','view_vendors','view_contracts','view_tenders','view_boqs',
            'view_budgets','view_reports',
        ]);
    }
}
