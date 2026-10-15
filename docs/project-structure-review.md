# FlowCheck structure assessment

Assessed 15 October 2026. This is a structure and selected implementation review, not an exhaustive correctness or security audit. No application files have been moved.

## Recommendation

Keep one Laravel application and its conventional top-level directories. Organise controllers, requests, services, views and tests by the same business areas. Keep models and migrations in their conventional locations for now. The application is small enough that separate packages, microservices or a frontend rewrite would add unnecessary overhead.

First make installation, asset builds, deployment and tests reproducible. Then move one feature at a time. Moving everything at once would mix existing failures with refactoring failures.

## Inventory and scope

The current checkout contains 88 app files, 70 resource files, 47 database files, three route files, four test files and one application config file. There are also 11,961 vendor files, all tracked in Git. Storage has 49 local files but only 11 tracked placeholder/ignore files. Vendor internals, runtime storage content, secrets in `.env`, and SQL row data were not reviewed. See `project-file-inventory.tsv` for the first-party file map.

Read the dependency manifests, bootstrap and routing setup, deployment entry points, representative models, controllers, validation requests, policies, services, integrations and tests. Inspected view references, script placement, notifications and the complete registered route inventory. Route registration succeeds with local PHP. This does not prove that each endpoint works.

## Findings to address before or alongside moves

| Priority | Evidence | Implication and proposed change |
| --- | --- | --- |
| High | Root `.htaccess` serves existing files directly; root `index.php` forces error display; a SQL dump is tracked in the root | Deployment depends on exposing the project root. Configure the server document root as `public/`, or keep application files outside the served directory on restricted hosting. Verify access rules before retiring the root entry point. Store database backups outside the repository and web root after verifying a recoverable copy. Actual remote exposure has not been tested. |
| High | `package.json` has no dependencies and its build only echoes a message; `package.dev.json` contains the actual build dependencies | Clean installation cannot reproduce the assets. Consolidate into one package manifest, reconcile its lockfile, and run a real Vite build during deployment. Decide whether compiled assets are built in CI or intentionally committed; use one documented policy. |
| High | Four Pest feature files exist, but no first-party `tests/Pest.php`, `tests/TestCase.php` or PHPUnit configuration was found | Restore test bootstrapping with an isolated test database before changing application behaviour. Do not run database-refresh tests using the existing application `.env`. |
| High | `InvoiceMatchingTest.php` calls `ThreeWayMatchingService::match()`, but the service exposes `matchInvoice()` | Tests and implementation disagree. Define the matching contract and add meaningful quantity, tolerance and repeat-processing coverage before extracting this service. Current matching hardcodes invoiced quantity to zero and checks only a lower price bound. |
| High | `OrganisationScoped` only checks that the user has an organisation; invoice and purchase-request validation uses unscoped `exists` rules | Organisation isolation currently depends on individual controller/policy checks. Scope foreign-key validation and relationship lookups to the current organisation, including nested quote and tender submission actions. Add cross-organisation tests before centralising these checks. This finding does not assert that every endpoint is vulnerable. |
| Medium | Runtime route inventory contains 140 routes; 27 point to methods not declared on their controllers | Restrict each resource registration with `only()`/`except()` to implemented operations, or implement the intended operations. Check intended UI links before removing routes. |
| Medium | API route inventory confirms `/api/api/...`; multiple API routes have the same `api.` name | Remove the extra API prefix through a deliberate compatibility change and give endpoints unique names. Prefer controller class references consistently. |
| Medium | `resources/views/layouts/app.blade.php` and `resources/views/components/layouts/app.blade.php` have identical SHA256 hashes | Keep the component layout used by `<x-app-layout>`, split navigation/header/flash messages into partials, and retire the duplicate after checking all references. The wrapper `components/app-layout.blade.php` can remain for compatibility. |
| Medium | Web and API purchase-request/invoice controllers repeat creation logic | Extract shared use-case actions. Let controllers handle transport, actions handle transactions, and policies/requests handle access and validation. |
| Medium | Notifications use database/mail channels and queues; repository migrations contain no notifications, jobs or personal-access-token table definitions | Verify schema provisioning against migrations and the SQL schema without importing data. Add missing infrastructure migrations if these features are enabled. Document the queue worker and scheduler. Contract expiry has a notification class but no scheduled task in `routes/console.php`. |
| Medium | All vendor files are tracked and `.gitignore` does not exclude `/vendor` | Move dependency installation into a verified deployment process before untracking vendor. Keep `composer.lock`. Do not delete the installed local dependencies as part of this assessment. |
| Low | ZPPA, ZIPPS and ZIHRM adapters explicitly return placeholder responses | Keep these as adapters, document their incomplete status and add tests when implemented. Folder moves do not make these integrations operational. |
| Low | README is a roadmap rather than setup documentation; no `.env.example` is present | Add installation, local development, test, deployment and troubleshooting instructions plus a sanitised environment example. Preserve the roadmap in a separate document. |

## Proposed arrangement

```text
app/
  Http/
    Controllers/
      Web/{Auth,Procurement,Sourcing,Suppliers,Finance,Reporting,Settings}/
      Api/{Procurement,Finance,Reporting}/
    Requests/{Procurement,Sourcing,Suppliers,Finance,Settings}/
    Middleware/                         # organisation context and MFA
  Actions/
    Procurement/                        # create/submit/approve PR, create PO, receive goods
    Sourcing/                           # send RFQ, select quote, award tender
    Finance/                            # upload/approve invoice
  Services/
    Approvals/ApprovalWorkflowService.php
    Documents/DocumentNumberGeneratorService.php
    Finance/ThreeWayMatchingService.php
  Models/                               # preserve existing model namespaces
  Policies/                             # extend coverage consistently
  Integrations/{Zppa,Zipps,Zihrm}/        # split only as adapters grow
  Notifications/                        # domain subfolders only when helpful
  Exports/                              # retain until reporting grows
  Mail/
  Providers/
  Traits/
resources/
  views/
    auth/                               # login, invitation and MFA
    components/{layouts,forms,tables}/
    procurement/{purchase-requests,purchase-orders,goods-receipts}/
    sourcing/{rfqs,tenders,boqs}/
    suppliers/{vendors,contracts}/
    finance/{invoices,budgets}/
    reporting/{dashboard,reports}/
    settings/{users,departments,workflows}/
    notifications/
    pdf/
    emails/
    marketing/landing.blade.php
  js/{app.js,components,pages}/
  css/{app.css,components}/
routes/
  web.php                               # auth routes + shared app middleware boundary
  web/{auth,procurement,sourcing,suppliers,finance,reporting,settings}.php
  api.php                               # auth and one API prefix boundary
  console.php
database/{migrations,factories,seeders}/
tests/
  Pest.php
  TestCase.php
  Feature/{Auth,Tenancy,Procurement,Sourcing,Suppliers,Finance,Reporting,Settings}/
  Unit/{Approvals,Documents,Finance}/
docs/{architecture,development,deployment,roadmap}.md
public/                                 # only web document root
storage/                                # local runtime files; retain ignore placeholders
```

These are logical groups, not a requirement to create empty directories. Contracts sit under supplier management here; if contracts become cross-functional, keep a separate Contracts group. Keep route names and URLs stable during folder moves. Rename GRN URLs separately, if desired, with an explicit compatibility decision.

## Existing file groups and destination rules

| Current location | Destination / treatment |
| --- | --- |
| Web `LoginController`, `MfaController`; auth and MFA views | Auth controller group and `views/auth/mfa` |
| Purchase request, purchase order and GRN controllers/requests | Procurement groups; keep item models in `Models` |
| RFQ, tender and BOQ controllers/requests/views | Sourcing groups |
| Vendor and contract controllers/requests/views | Suppliers groups |
| Invoice and budget controllers/requests/views | Finance groups |
| Dashboard and report controllers; analytics and reports views | Reporting groups |
| Settings controllers and views | Keep Settings grouping; extract inline validation to dedicated requests as features are touched |
| API controllers | Same business-area names, with shared actions used by web/API |
| Three existing services | Group under Approvals, Documents and Finance; update imports atomically |
| Flat model, policy, notification, export, mail and trait files | Retain initially; avoid namespace churn without a concrete benefit |
| `database/migrations` | Retain historical filenames and order; use new forward migrations for schema changes |
| Factories and seeders | Retain conventional paths; separate demo seeding from production bootstrap in documentation |
| `resources/js/app.js` and inline page scripts | Keep one Alpine startup; extract reusable line-item/forms behaviour into components and page logic into page files |
| Dashboard Chart.js CDN include | Use the package-built Chart.js consistently after the asset pipeline works |
| PDF and email views | Keep separate rendering contexts; PDF/email CSS may need to remain embedded |
| `public/build` | Generated output with one explicit deployment policy; do not hand-edit hashed bundles |
| Root `index.php`, `.htaccess`, `.hostinger.yml` | Review as a deployment unit; keep platform-discovered config where the platform expects it |
| `flowcheck_database.sql` | Recoverable backup outside the web root/repository; migrations remain the schema source of truth |
| `composer.json`, lockfiles, Vite/Tailwind/PostCSS configuration, `artisan`, bootstrap | Keep conventional root/bootstrap locations |
| `.claude/settings.local.json` | Review as local tooling configuration; avoid distributing machine-specific settings |
| `.env` | Private runtime configuration; generate a sanitised example without copying secrets |

## Implementation sequence and completion checks

1. **Establish a baseline.** Document setup; add a safe environment example and isolated test configuration; reconcile matching tests with the intended behaviour. Record route inventory. Completion: a fresh checkout can install, build and execute meaningful tests without touching application data.
2. **Stabilise deployment.** Consolidate npm manifests, prove dependency installation on hosting/CI, set the web root and backup location, then remove dependency tracking. Completion: a fresh deploy has built assets and cannot serve private source, environment files or database backups.
3. **Consolidate views and routes.** Retire the duplicate layout, group views, and split route files inside the current shared middleware/prefix groups. Fix unsupported resource routes separately. Completion: route names/URLs remain stable except documented fixes, all referenced views resolve, and key pages render.
4. **Extract shared actions.** Start with purchase-request creation, then invoice upload/matching. Move related controllers/requests a feature at a time. Completion: web/API produce equivalent records, enforce organisation boundaries and roll back failed multi-record operations.
5. **Group remaining areas.** Move Sourcing, Suppliers, Reporting and Settings. Add missing policy coverage, infrastructure migrations and scheduled operations as distinct behaviour changes. Completion: role/organisation checks, PDFs, exports, queued notifications and scheduler flows pass relevant checks.

Do not rename database tables, move historical migrations, replace Blade, or introduce a generic repository layer merely to make the tree look uniform. Remove the empty intermediate Web controller only if simplifying its imports is useful during the controller moves.

## Verification limits

Confirmed route registration and Pest 2.36.1 availability using the installed PHP runtime. Compared layout hashes and checked controller declarations against registered routes. Did not execute the feature suite: its application test bootstrap and isolated database configuration are absent. No migration, SQL import, dependency removal, production request or application refactor was performed.
