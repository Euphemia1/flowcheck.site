# FlowCheck MVP - Procurement Management Platform

FlowCheck is a multi-tenant,procurement management platform built with Laravel 11, MySQL, and Tailwind CSS. It's designed for SMEs, construction companies, and industrial organisations in Zambia to digitise their procurement lifecycle end-to-end.

## Project Status

This is a **complete scaffolded Laravel 11 project** with:
- ✅ Full database migrations for all modules
- ✅ Eloquent models with relationships
- ✅ Core service classes (DocumentNumberGenerator, ThreeWayMatching, ApprovalWorkflow)
- ✅ Policies for authorization
- ✅ Form Requests for validation
- ✅ Web and API controllers
- ✅ Routes configured
- ✅ Blade views (dashboard, purchase requests, etc.)
- ✅ Role-based permissions (Spatie)
- ✅ Sample seeders with demo data

## Quick Setup Instructions

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8+
- Node.js 18+ (for Tailwind/Vite)

### Installation Steps

1. **Clone/Download the project**
   ```bash
   cd flowcheck.ai
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure database** in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=flowcheck
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Run migrations**
   ```bash
   php artisan migrate
   ```

8. **Seed demo data** (optional)
   ```bash
   php artisan db:seed
   ```

9. **Build frontend assets**
   ```bash
   npm run build
   # or for development with watch:
   npm run dev
   ```

10. **Start the development server**
    ```bash
    php artisan serve
    ```

11. **Access the application**
    - URL: `http://localhost:8000`
    - Demo login: `admin@copperbelt.test` / `password`

## Project Structure

```
flowcheck.ai/
├── app/
│   ├── Models/              # Eloquent models for all entities
│   ├── Http/
│   │   ├── Controllers/Web/ # Web controllers
│   │   ├── Controllers/Api/ # API controllers
│   │   └── Requests/        # Form validation requests
│   ├── Policies/            # Authorization policies
│   ├── Services/            # Business logic (3-way matching, document numbering, etc.)
│   ├── Livewire/            # Livewire components
│   ├── Jobs/                # Queued jobs
│   └── Notifications/       # Email/in-app notifications
├── database/
│   ├── migrations/          # 25+ migrations for all tables
│   └── seeders/             # Demo data seeders
├── resources/
│   ├── views/
│   │   ├── layouts/         # App layout & navigation
│   │   ├── procurement/     # PR, RFQ, PO views
│   │   ├── finance/         # Invoice, payment views
│   │   ├── vendors/         # Vendor management
│   │   ├── analytics/       # Dashboard & charts
│   │   └── settings/        # Configuration views
│   ├── css/                 # Tailwind CSS
│   └── js/                  # Alpine.js + frontend logic
├── routes/
│   ├── web.php              # Web routes (app dashboard)
│   └── api.php              # API routes (Sanctum)
├── config/                  # Configuration files
├── storage/                 # File uploads, logs
├── tests/                   # Feature & unit tests
├── composer.json            # PHP dependencies
└── package.json             # Node dependencies
```

## Core Modules (Ready for Development)

### 1. **Authentication & Onboarding**
- ✅ Models & migrations ready
- ⏳ Blade views need completion
- Includes: Email verification, password reset, MFA (TOTP)

### 2. **User & Role Management**
- ✅ Roles defined (9 roles with Spatie)
- ✅ Permissions seeded
- ⏳ User management UI needed

### 3. **Purchase Request (PR) Workflow**
- ✅ Controller & form requests created
- ✅ Service for approval workflow logic
- ✅ Index and create views
- ⏳ Edit, show, approval UI views needed

### 4. **RFQ Management**
- ✅ Models & database ready
- ⏳ Controller & views needed

### 5. **Purchase Order (PO)**
- ✅ Models & database ready
- ⏳ PDF generation (DomPDF) integration needed

### 6. **Goods Receipt Note (GRN)**
- ✅ Models & database ready
- ⏳ Mobile-friendly views needed

### 7. **Invoice Management & 3-Way Matching**
- ✅ ThreeWayMatchingService implemented
- ✅ Invoice controller with matching logic
- ⏳ Invoice views & matching UI needed

### 8. **BOQ & Tender Management**
- ✅ Models & migrations ready
- ⏳ Controller & views needed

### 9. **Contract Management**
- ✅ Models & migrations ready
- ⏳ Controller & views needed

### 10. **Spend Analytics Dashboard**
- ✅ Dashboard controller with stats
- ✅ Initial dashboard view with Chart.js
- ⏳ More advanced analytics & charts needed

### 11. **Vendor Portal**
- ⏳ Separate authentication guard needed
- ⏳ Portal views for vendors

### 12. **Compliance & Audit**
- ✅ AuditLog model & migrations
- ⏳ Audit log viewer UI needed

### 13. **Notifications**
- ✅ Database notification migrations ready
- ⏳ Email templates needed

### 14. **Settings**
- ⏳ Organisation settings controller & views needed

## Key Technologies

| Component | Technology |
|-----------|------------|
| Backend   | Laravel 11, PHP 8.2 |
| Database  | MySQL 8 |
| Frontend  | Blade, Tailwind CSS, Alpine.js |
| Components | Livewire (for reactive UI) |
| Auth      | Laravel Breeze, Sanctum, Fortify |
| Permissions | Spatie Laravel Permission |
| PDF       | DomPDF |
| File Storage | Laravel Storage (S3-compatible) |
| Queue     | Database queue driver |

## Environment Variables

Key environment variables in `.env`:

```
APP_NAME=FlowCheck
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=flowcheck

GOOGLE2FA_ENABLED=true
SI68_COMPLIANCE_MODE=true
CURRENCY_DEFAULT=ZMW
```

## Database Schema Highlights

**25 database tables** covering:
- Organisations (multi-tenancy)
- Users & Roles (Spatie)
- Departments & Budget Lines
- Vendors & Performance Scores
- Purchase Requests & Items
- Approval Workflows & Logs
- RFQs & Vendor Quotes
- Purchase Orders & Items
- Goods Receipt Notes & Items
- Invoices & 3-Way Matching Results
- Contracts & BOQs/Tenders
- Audit Logs (append-only)
- Document Sequences (auto-numbering)

## Next Steps for Development

### Immediate Priorities (MVP Phase 1)
1. ✅ Create Purchase Request flow (create/submit/approve/reject)
2. Create Purchase Request views (show, edit, approval dashboard)
3. Implement GRN creation with photo uploads
4. Complete invoice views and 3-way matching UI
5. Build vendor approval workflow
6. Add contract expiry notifications

### Phase 2
1. RFQ management complete (create, send to vendors, quote comparison)
2. Purchase Order PDF generation
3. Tender management (BOQ, scoring, award)
4. Vendor portal (separate authentication)
5. Advanced analytics (spend trends, vendor performance)

### Phase 3
1. Mobile app (React Native/Flutter consuming API)
2. OCR for invoice parsing
3. EDI/API integrations
4. Blockchain audit trail (optional)
5. Advanced reporting & BI

## Testing

Run feature tests:
```bash
php artisan test
```

## API Documentation

API endpoints use Sanctum token auth. Key endpoints:

```
POST   /api/login                      # Get auth token
GET    /api/purchase-requests          # List PRs
POST   /api/purchase-requests          # Create PR
GET    /api/purchase-requests/{id}     # Get PR details
GET    /api/invoices                   # List invoices
POST   /api/invoices                   # Upload invoice
GET    /api/dashboard/stats            # Dashboard statistics
```

## SI 68 of 2025 Compliance

The system enforces SI 68 (Zambian Statutory Instrument 68 of 2025) compliance for 3-way matching:
- Invoices cannot move to `approved_for_payment` unless `matching_status = 'matched'`
- Enforcement is configurable via `SI68_COMPLIANCE_MODE` in `.env`
- All procurement actions are logged immutably in `audit_logs`

## Currency & Localization

- Default currency: ZMW (Zambian Kwacha)
- Default country: ZM (Zambia)
- All monetary values stored as `decimal(15,2)`
- Multi-currency support planned for future

## Support & Contributing

For questions or contributions, contact the development team.

## License

MIT License - See LICENSE file for details.

---

**Version:** 1.0.0 MVP  
**Last Updated:** April 2026  
**Maintainer:** FlowCheck Development Team
