
FlowCheck is a multi-tenant,procurement management platform built  It's designed for SMEs, construction companies, and industrial organisations in Zambia to digitise their procurement lifecycle end-to-end.

 Project Status 

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

 1. Authentication & Onboarding
- ✅ Models & migrations ready
- ⏳ Blade views need completion
- Includes: Email verification, password reset, MFA (TOTP)

 2. User & Role Management
- ✅ Roles defined (9 roles with Spatie)
- ✅ Permissions seeded
- ⏳ User management UI needed

 3. Purchase Request (PR) Workflow
- ✅ Controller & form requests created
- ✅ Service for approval workflow logic
- ✅ Index and create views
- ⏳ Edit, show, approval UI views needed

 4. RFQ Management
- ✅ Models & database ready
- ⏳ Controller & views needed

 5. Purchase Order (PO)
- ✅ Models & database ready
- ⏳ PDF generation (DomPDF) integration needed

 6. Goods Receipt Note (GRN)
- ✅ Models & database ready
- ⏳ Mobile-friendly views needed

7. Invoice Management & 3-Way Matching
- ✅ ThreeWayMatchingService implemented
- ✅ Invoice controller with matching logic
- ⏳ Invoice views & matching UI needed




MVP Phase 1
1. ✅ Create Purchase Request flow (create/submit/approve/reject)
2. Create Purchase Request views (show, edit, approval dashboard)
3. Implement GRN creation with photo uploads
4. Complete invoice views and 3-way matching UI
5. Build vendor approval workflow
6. Add contract expiry notifications

Phase 2
1. RFQ management complete (create, send to vendors, quote comparison)
2. Purchase Order PDF generation
3. Tender management (BOQ, scoring, award)
4. Vendor portal (separate authentication)
5. Advanced analytics (spend trends, vendor performance)
 Phase 3
1. Mobile app (React Native/Flutter consuming API)
2. OCR for invoice parsing
3. EDI/API integrations
4. Blockchain audit trail (optional)
5. Advanced reporting & BI
