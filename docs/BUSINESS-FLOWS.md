# SinnoERP — Business Flows

Sequence diagram alur bisnis antar modul. Setiap flow merujuk ke **Manager class** yang mengorkestrasi logika bisnis dan **Events** yang memicu side effects.

---

## Daftar Isi

1. [Sales Order — Konfirmasi ke Delivery](#1-sales-order--konfirmasi-ke-delivery)
2. [Delivery Selesai — Update Sales Order](#2-delivery-selesai--update-sales-order)
3. [Sales Order — Pembuatan Invoice](#3-sales-order--pembuatan-invoice)
4. [Purchase Order — Konfirmasi ke Receipt](#4-purchase-order--konfirmasi-ke-receipt)
5. [Inventory Procurement Rules (MTO)](#5-inventory-procurement-rules-mto)
6. [Sales Order — Pembatalan](#6-sales-order--pembatalan)
7. [Plugin Install Lifecycle](#7-plugin-install-lifecycle)
8. [API Authentication Flow](#8-api-authentication-flow)
9. [Indeks Flow per Plugin](#9-indeks-flow-per-plugin)
10. [Accounts — Posting & Reconciliation](#10-accounts--posting--reconciliation)
11. [Payments — Register Payment on Invoice](#11-payments--register-payment-on-invoice)
12. [Manufacturing Order Lifecycle](#12-manufacturing-order-lifecycle)
13. [Purchase Requisition → Purchase Order](#13-purchase-requisition--purchase-order)
14. [Recruitment — Applicant Pipeline](#14-recruitment--applicant-pipeline)
15. [Time-off — Leave Request](#15-time-off--leave-request)
16. [Projects — Task & Timesheet](#16-projects--task--timesheet)
17. [Maintenance Request](#17-maintenance-request)
18. [Products — Catalog Setup](#18-products--catalog-setup)
19. [Partners & Contacts](#19-partners--contacts)
20. [Website & Blogs — Publish Content](#20-website--blogs--publish-content)
21. [Chatter — Message on Record](#21-chatter--message-on-record)
22. [Custom Fields — Dynamic Attributes](#22-custom-fields--dynamic-attributes)
23. [Plugin Dependency Install Order](#23-plugin-dependency-install-order)
24. [Analytics — Cost Tracking](#24-analytics--cost-tracking)
25. [Table Views — Saved Filters](#25-table-views--saved-filters)

---

## 1. Sales Order — Konfirmasi ke Delivery

Alur saat admin mengkonfirmasi Sales Order (Quotation → Sale). Modul Sales memicu procurement di Inventory.

**Entry point:** `SaleManager::confirmSaleOrder()`  
**File:** `plugins/sinno/sales/src/SaleManager.php`

```mermaid
sequenceDiagram
    actor Admin
    participant Filament as Filament UI
    participant SM as SaleManager
    participant SO as sales_orders
    participant SOL as sales_order_lines
    participant PG as ProcurementGroup
    participant IM as InventoryManager
    participant Rule as inventories_rules
    participant Op as inventories_operations
    participant Move as inventories_moves

    Admin->>Filament: Klik "Confirm Order"
    Filament->>SM: confirmSaleOrder(order)

    SM->>SO: state = SALE, invoice_status = TO_INVOICE
    SM->>SM: applyInventoryRules(lines)

    loop Setiap order line (product type = GOODS)
        SM->>SM: getQtyProcurement(line)
        alt Belum ada procurement group
            SM->>PG: create(name, move_type, partner, sale_order_id)
            SM->>SO: procurement_group_id = PG.id
        end
        SM->>SM: prepareProcurementValues(line, PG)
        SM->>SM: createProcurements(line, qty, uom, origin, values)
    end

    SM->>IM: runProcurements(procurements)

    loop Setiap procurement
        IM->>Rule: getRule(product, location, values)
        alt Rule action = PULL
            IM->>IM: runPullRule(procurements)
            IM->>Move: create move (warehouse → customer location)
            IM->>Op: create operation (Delivery Order)
            IM->>Op: confirmTransfer(operation)
        else Rule action = BUY (MTO)
            IM->>IM: runBuyRule(procurements)
            Note over IM: Generate Purchase RFQ/Order
        end
    end

    SM->>SM: computeSaleOrder(order)
    SM->>SM: OrderConfirmed::dispatch(order)
    SM-->>Filament: Order updated
    Filament-->>Admin: Notifikasi sukses
```

### State Transitions — Sales Order

```
DRAFT → SENT (email quotation)
DRAFT/SENT → SALE (confirm)
SALE → CANCEL (cancel)
SALE → DRAFT (back to quotation)
```

### State Transitions — Delivery Operation

```
DRAFT → CONFIRMED (confirmTransfer)
CONFIRMED → ASSIGNED (assignTransfer / check availability)
ASSIGNED → DONE (doneTransfer)
any → CANCELED (cancelTransfer)
```

---

## 2. Delivery Selesai — Update Sales Order

Saat delivery order di-mark done, Inventory memicu recomputasi qty_delivered di Sales via event listener.

**Entry point:** `InventoryManager::doneTransfer()`  
**Listener:** `Sinno\Sale\Listeners\ComputeSaleOrderListener`

```mermaid
sequenceDiagram
    actor Warehouse as Warehouse Staff
    participant Filament as Filament UI
    participant IM as InventoryManager
    participant Op as inventories_operations
    participant Move as inventories_moves
    participant PQ as product_quantities
    participant Event as OperationDone Event
    participant Listener as ComputeSaleOrderListener
    participant SM as SaleManager
    participant SO as sales_orders
    participant SOL as sales_order_lines

    Warehouse->>Filament: Validate & "Done" delivery
    Filament->>IM: doneTransfer(operation)

    IM->>IM: doneMoves(todoMoves)
    loop Setiap move
        IM->>Move: state = DONE, update quantity
        IM->>PQ: update stock (source -, destination +)
    end

    IM->>Op: computeState() → DONE
    IM->>Event: OperationDone::dispatch(operation)

    Event->>Listener: handle(OperationDone)
    Listener->>Listener: check saleOrder exists

    alt operation.sale_order_id set
        Listener->>SM: computeSaleOrder(saleOrder)
        SM->>SOL: computeQtyDelivered(line) via stock moves
        SM->>SOL: computeQtyInvoiced(line)
        SM->>SOL: compute invoice_status per line
        SM->>SO: computeDeliveryStatus(order)
        SM->>SO: computeInvoiceStatus(order)
        SM->>SO: recalculate amount_untaxed/tax/total
    end

    IM-->>Filament: Operation done
    Filament-->>Warehouse: delivery_status updated on SO
```

### Registrasi Listener

```php
// plugins/sinno/sales/src/SaleServiceProvider.php
Event::listen(OperationDone::class, ComputeSaleOrderListener::class);
```

---

## 3. Sales Order — Pembuatan Invoice

Alur pembuatan customer invoice dari Sales Order ke modul Accounts.

**Entry point:** `SaleManager::createInvoice()` → `createAccountMove()`

```mermaid
sequenceDiagram
    actor Admin
    participant Filament as Filament UI
    participant SM as SaleManager
    participant SO as sales_orders
    participant SOL as sales_order_lines
    participant AM as accounts_account_moves
    participant AML as accounts_account_move_lines
    participant AMgr as AccountManager
    participant Tax as Tax Facade

    Admin->>Filament: Create Invoice (advance payment / delivered)
    Filament->>SM: createInvoice(order, data)

    alt advance_payment_method = DELIVERED
        SM->>AM: create(move_type=OUT_INVOICE, partner, journal, ...)
        SM->>SO: attach account move (pivot)

        loop Setiap order line
            SM->>SM: determine quantity (ORDER policy vs DELIVERY policy)
            SM->>AML: create(name, quantity, price_unit, product, uom)
            SM->>SOL: sync accountMoveLines pivot
            SM->>AML: sync taxes from order line
        end

        SM->>AMgr: computeAccountMove(accountMove)
        AMgr->>Tax: collect tax amounts
        AMgr->>AM: update amount_untaxed, amount_tax, amount_total
    end

    SM->>SM: computeSaleOrder(order)
    Note over SO: invoice_status → INVOICED / TO_INVOICE
    SM-->>Filament: Invoice created
```

### Invoice Policy

| Policy | Quantity di Invoice |
|--------|---------------------|
| `ORDER` | `product_uom_qty` (full order qty) |
| `DELIVERY` | `qty_to_invoice` (= qty_delivered - qty_invoiced) |

---

## 4. Purchase Order — Konfirmasi ke Receipt

Alur saat Purchase Order dikonfirmasi — Inventory membuat receipt operation.

**Entry point:** `PurchaseOrder::confirmPurchaseOrder()`  
**File:** `plugins/sinno/purchases/src/PurchaseOrder.php`

```mermaid
sequenceDiagram
    actor Admin
    participant Filament as Filament UI
    participant PO as PurchaseOrder Manager
    participant Order as purchases_orders
    participant OL as purchases_order_lines
    participant IM as InventoryManager
    participant Op as inventories_operations
    participant Move as inventories_moves

    Admin->>Filament: Confirm Purchase Order
    Filament->>PO: confirmPurchaseOrder(order)

    PO->>Order: state = PURCHASE
    PO->>PO: createReceiptOperations(order)

    loop Setiap order line
        PO->>Op: create operation (Receipt, supplier → warehouse)
        PO->>Move: create moves for products
        PO->>IM: confirmMoves(moves)
        PO->>IM: assignMoves(moves)
        PO->>IM: confirmTransfer(operation)
    end

    PO->>PO: computePurchaseOrder(order)
    PO-->>Filament: PO confirmed + receipts created
    Filament-->>Admin: Receipt operations visible in Inventory
```

### Receipt Completion

Saat receipt di-mark done (mirroring delivery flow):

```
Warehouse Staff → doneTransfer(receipt)
  → stock increased at warehouse location
  → purchases_order_lines.qty_received updated
  → purchases_orders receipt status updated
```

---

## 5. Inventory Procurement Rules (MTO)

Detail internal `InventoryManager::runProcurements()` — bagaimana rule menentukan aksi.

```mermaid
flowchart TD
    Start[Sale Order Confirmed] --> Proc[applyInventoryRules]
    Proc --> Build[Build procurement array per line]
    Build --> Run[InventoryManager.runProcurements]

    Run --> GetRule{getRule product + location}
    GetRule -->|No rule| Error[Throw: no rule found]
    GetRule -->|Rule found| Action{rule.action}

    Action -->|PULL| Pull[runPullRule]
    Action -->|BUY| Buy[runBuyRule → Purchase RFQ]
    Action -->|PULL_PUSH| PullPush[runPull then Push]

    Pull --> CheckStock{MTS: stock available?}
    CheckStock -->|Yes| FromStock[Create move from warehouse stock]
    CheckStock -->|No MTO| Buy

    FromStock --> CreateOp[Create Delivery Operation]
    Buy --> CreatePO[Create Purchase Order / RFQ]
    CreateOp --> Confirm[confirmTransfer]
    CreatePO --> ConfirmPO[Vendor fulfills → Receipt]
```

### Procure Methods

| Method | Perilaku |
|--------|----------|
| `make_to_stock` (MTS) | Ambil dari stok gudang |
| `make_to_order` (MTO) | Trigger purchase/manufacturing |
| `mts_else_mto` | Coba MTS dulu, fallback MTO jika stok kurang |

---

## 6. Sales Order — Pembatalan

```mermaid
sequenceDiagram
    actor Admin
    participant SM as SaleManager
    participant SO as sales_orders
    participant IM as InventoryManager
    participant Op as inventories_operations

    Admin->>SM: cancelSaleOrder(order, emailData)
    SM->>SO: state = CANCEL, invoice_status = NO
    SM->>SM: cancelAndSendEmail (optional)
    SM->>SM: computeSaleOrder(order)
    SM->>SM: cancelInventoryOperation(order)

    loop Setiap operation linked to order
        SM->>IM: cancelTransfer(operation)
        IM->>Op: state = CANCELED
        IM->>IM: cancel related moves
    end

    SM->>SM: OrderCanceled::dispatch(order)
```

---

## 7. Plugin Install Lifecycle

```mermaid
sequenceDiagram
    actor Dev as Developer / Admin
    participant CLI as Artisan
    participant IC as InstallCommand
    participant Dep as Dependency Plugins
    participant DB as Database
    participant Shield as Filament Shield
    participant Plugin as Plugin Model

    Dev->>CLI: php artisan products:install
    CLI->>IC: handle()

    loop Dependencies not installed
        IC->>Dep: {dep}:install (recursive)
    end

    IC->>DB: publish config/assets
    IC->>DB: run plugin migrations
    IC->>DB: run plugin seeders
    IC->>Plugin: updateOrCreate(is_installed=true)
    IC->>DB: sync plugin_dependencies pivot
    IC->>Shield: shield:generate --all --panel=admin

    Note over Plugin: ProductPlugin.register() now passes isPluginInstalled check
    Note over Plugin: Routes & migrations now loaded
```

---

## 8. API Authentication Flow

```mermaid
sequenceDiagram
    actor Client as API Client
    participant API as Laravel API
    participant Auth as AuthController
    participant Sanctum as Sanctum
    participant User as Security User
    participant Controller as API V1 Controller
    participant Gate as Gate / Policy

    Client->>API: POST /admin/api/v1/login {email, password}
    API->>Auth: login(request)
    Auth->>User: validate credentials
    Auth->>Sanctum: createToken('api-token')
    Auth-->>Client: {token: "..."}

    Client->>API: GET /admin/api/v1/products (Authorization: Bearer token)
    API->>Sanctum: auth:sanctum middleware
    Sanctum->>User: resolve token → user
    API->>Controller: index()
    Controller->>Gate: authorize('viewAny', Product::class)
    Gate-->>Controller: allowed
    Controller->>Controller: QueryBuilder + paginate
    Controller-->>Client: ProductResource collection JSON
```

---

## Manager Classes Reference

| Manager | Plugin | Path | Tanggung Jawab |
|---------|--------|------|----------------|
| `SaleManager` | sales | `plugins/sinno/sales/src/SaleManager.php` | SO lifecycle, procurement trigger, invoice |
| `InventoryManager` | inventories | `plugins/sinno/inventories/src/InventoryManager.php` | Transfers, moves, stock, procurement rules |
| `PurchaseOrder` | purchases | `plugins/sinno/purchases/src/PurchaseOrder.php` | PO lifecycle, receipt creation |
| `AccountManager` | accounts | via `AccountFacade` | Journal entries, move computation, posting |

## Events Reference

| Event | Dispatched By | Listened By |
|-------|---------------|-------------|
| `OrderConfirmed` | SaleManager | (extensible) |
| `OrderCanceled` | SaleManager | (extensible) |
| `OperationDone` | InventoryManager | `ComputeSaleOrderListener` (sales) |
| `OperationConfirmed` | InventoryManager | (extensible) |
| `OperationCanceled` | InventoryManager | (extensible) |
| `MoveConfirmed` | AccountManager | (accounts) |
| `sinno.installed` | InstallERP | `PluginManager\Listeners\Installer` |
| `MovePaid` | AccountManager | (extensible) |
| `MoveCancelled` | AccountManager | (extensible) |
| `OperationConfirmed` | InventoryManager | (extensible) |
| `OperationAssigned` | InventoryManager | (extensible) |

---

## 9. Indeks Flow per Plugin

| Plugin | Flow Section | Manager / Entry Point | Ada Event? |
|--------|--------------|----------------------|------------|
| plugin-manager | §7, §23 | `InstallERP`, `InstallCommand` | `sinno.installed` |
| security | §8 | `AuthController` | — |
| support | — | Company/Currency seeders | — |
| products | §18 | Filament CRUD | — |
| partners | §19 | Filament CRUD | — |
| contacts | §19 | extends partners | — |
| accounts | §10 | `AccountManager` | `MoveConfirmed`, `MovePaid` |
| accounting | §10 | Reporting pages | — |
| invoices | §3, §10 | extends accounts | — |
| payments | §11 | `Payment` model + register | — |
| sales | §1–3, §6 | `SaleManager` | `OrderConfirmed`, `OrderCanceled` |
| purchases | §4, §13 | `PurchaseOrder` | — |
| inventories | §1–2, §5 | `InventoryManager` | `OperationDone`, `OperationConfirmed` |
| manufacturing | §12 | `ManufacturingManager` | — |
| employees | — | Filament CRUD | — |
| recruitments | §14 | Filament + stage actions | — |
| time-off | §15 | Filament leave actions | — |
| projects | §16 | Task updates → timesheet sum | — |
| timesheets | §16 | `analytic_records` create | — |
| website | §20 | Page publish | — |
| blogs | §20 | Post publish | — |
| maintenance | §17 | Calendar widget / CRUD | — |
| chatter | §21 | `addMessage()` trait | — |
| fields | §22 | `HasCustomFields` | — |
| analytics | §24 | `analytic_records` | — |
| table-views | §25 | User saved views | — |
| full-calendar | — | Widget render hook | — |

---

## 10. Accounts — Posting & Reconciliation

**Entry point:** `AccountManager::confirmMove()`  
**File:** `plugins/sinno/accounts/src/AccountManager.php`

```mermaid
sequenceDiagram
    actor Accountant
    participant AM as AccountManager
    participant Move as accounts_account_moves
    participant Lines as move_lines
    participant Partner as partners_partners

    Accountant->>AM: confirmMove(invoice)
    AM->>AM: isConfirmAllowedForMove()
    AM->>AM: reconcileReversedMoves (if credit note)
    AM->>Move: state = POSTED
    AM->>Lines: parent_state = POSTED
    AM->>AM: computeAccountMove()
    alt Sale document
        AM->>Partner: customer_rank++
    else Purchase document
        AM->>Partner: supplier_rank++
    end
    AM->>AM: MoveConfirmed::dispatch(move)
```

**Reset to draft:** `resetToDraftMove()` → un-reconcile partial matches → `MoveDrafted::dispatch`

**Payment:** `registerPayment()` → creates `accounts_account_payments` → reconcile with move lines → `MovePaid::dispatch`

---

## 11. Payments — Register Payment on Invoice

Modul **payments** menangani metode pembayaran gateway; registrasi pembayaran invoice utama ada di **accounts** (`PaymentRegister`).

```mermaid
sequenceDiagram
    actor User
    participant Filament
    participant AM as AccountManager
    participant PR as PaymentRegister
    participant Payment as accounts_account_payments

    User->>Filament: Register Payment on Invoice(s)
    Filament->>PR: create(payment_type, amount, journal)
    Filament->>AM: processPaymentRegister(PR)
    AM->>Payment: create payment move
    AM->>AM: reconcile payment lines with invoice lines
    AM->>AM: MovePaid::dispatch(invoice)
```

Plugin **payments** terpisah: `payments_payment_tokens` untuk penyimpanan token kartu pelanggan.

---

## 12. Manufacturing Order Lifecycle

**Entry point:** `ManufacturingManager::confirmManufacturingOrder()`  
**File:** `plugins/sinno/manufacturing/src/ManufacturingManager.php`

```mermaid
sequenceDiagram
    actor Production
    participant MM as ManufacturingManager
    participant MO as manufacturing_orders
    participant BOM as bills_of_materials
    participant WO as work_orders
    participant IM as InventoryManager
    participant Op as inventories_operations

    Production->>MM: confirmManufacturingOrder(MO)
    MM->>MO: apply BOM consumption settings
    MM->>MO: adjustProcureMethod on raw material moves
    MM->>MM: confirmMoves(raw + finished)
    MM->>MM: confirmWorkOrders(WO)
    loop inventory_operations
        MM->>IM: confirmTransfer(operation)
    end
    MM->>MO: state = CONFIRMED

    Production->>MM: startManufacturingOrder(MO)
    MM->>WO: start work orders

    Production->>MM: produce / mark done
    MM->>IM: doneTransfer (consume components, produce FG)
    MM->>MO: state = DONE
```

**Unbuild:** `manufacturing_unbuild_orders` — reverse production flow.

---

## 13. Purchase Requisition → Purchase Order

```mermaid
sequenceDiagram
    actor Buyer
    participant Filament
    participant PR as purchases_requisitions
    participant PO as PurchaseOrder Manager
    participant IM as InventoryManager

    Buyer->>Filament: Create Requisition (RFQ)
    Buyer->>Filament: Confirm Requisition
    Buyer->>Filament: Create PO from Requisition
    Filament->>PO: confirmPurchaseOrder(order)
    PO->>PO: state = PURCHASE
    PO->>PO: createReceiptOperations()
    PO->>IM: confirmMoves + assignMoves + confirmTransfer
    Note over PO: Vendor bill via accounts (mirror sales invoice)
```

**Vendor bill:** PO linked to `accounts_account_moves` via `purchases_order_account_moves` pivot.

---

## 14. Recruitment — Applicant Pipeline

Tidak ada Manager class — alur via Filament Actions pada `ApplicantResource`.

```mermaid
sequenceDiagram
    actor HR
    participant Filament
    participant App as recruitments_applicants
    participant Stage as recruitments_stages
    participant Cand as recruitments_candidates
    participant Emp as employees_employees

    HR->>Filament: Create Candidate
    HR->>Filament: Create Applicant (job + salary expected)
    loop Pipeline stages
        HR->>Filament: Move to next stage
        Filament->>App: stage_id = next
    end
    HR->>Filament: Hire Applicant
    Filament->>Emp: create employee from applicant
    Filament->>App: mark hired / archive
```

Field gaji (`salary_proposed`, `salary_expected`) hanya untuk negosiasi rekrutmen — bukan payroll.

---

## 15. Time-off — Leave Request

```mermaid
sequenceDiagram
    actor Employee
    actor Manager
    participant Filament
    participant Leave as time_off_leaves
    participant Alloc as time_off_leave_allocations

    Employee->>Filament: Request Leave (type, dates)
    Filament->>Leave: create(state=draft/confirm)
    Filament->>Alloc: validate remaining days
    Manager->>Filament: Approve / Refuse
    Filament->>Leave: state = validated / refused
    Note over Leave: Updates employee calendar via CalendarLeave
```

Dependensi: plugin **employees** (data karyawan & kalender kerja).

---

## 16. Projects — Task & Timesheet

Tidak ada ProjectManager — timesheet update via model events.

```mermaid
sequenceDiagram
    actor User
    participant Filament
    participant Task as projects_tasks
    participant TS as analytic_records

    User->>Filament: Log timesheet on task
    Filament->>TS: create(project_id, task_id, unit_amount)
    TS->>Task: updateTaskTimes() [model event]
    Task->>Task: total_hours_spent = sum(timesheets)
    Task->>Task: progress = spent / allocated_hours
    Task->>Task: overtime = max(0, spent - allocated)
```

Plugin **timesheets** menyediakan UI terpusat untuk `ManageTimesheets` page.

---

## 17. Maintenance Request

```mermaid
sequenceDiagram
    actor Technician
    participant Widget as MaintenanceCalendarWidget
    participant Req as maintenance_requests
    participant Equip as maintenance_equipments

    Technician->>Widget: createMaintenanceRequest(data)
    Widget->>Req: create(equipment_id, schedule_date, stage)
    Technician->>Widget: Drag to reschedule
    Widget->>Req: update schedule_date
    Technician->>Widget: Mark done
    Widget->>Req: state = repaired / stage = done
```

---

## 18. Products — Catalog Setup

Alur setup master data produk (prasyarat banyak modul).

```mermaid
flowchart LR
    A[Create Category] --> B[Create Attributes + Options]
    B --> C[Create Product]
    C --> D{Type?}
    D -->|Goods| E[Enable inventory routes]
    D -->|Service| F[Enable sales only]
    C --> G[Variants via parent_id]
    E --> H[Install inventories plugin]
    H --> I[Configure routes & rules]
```

**Dependensi:** `products` → required by `accounts`, `inventories`, `sales` (transitively).

---

## 19. Partners & Contacts

```mermaid
flowchart TD
    P[Create Partner] --> T{account_type}
    T -->|Customer| S[Used in Sales Orders]
    T -->|Vendor| PU[Used in Purchase Orders]
    T -->|Both| S
    T -->|Both| PU
    P --> C[Contacts plugin: child contacts via parent_id]
    P --> BA[Bank accounts for payments]
```

---

## 20. Website & Blogs — Publish Content

```mermaid
sequenceDiagram
    actor Editor
    participant Admin as Admin Panel
    participant Page as website_pages
    participant Post as blogs_posts
    participant Customer as Customer Panel

    Editor->>Admin: Create / edit page
    Editor->>Admin: is_published = true
    Note over Customer: website plugin registers customer routes
    Customer->>Customer: View published pages
    Editor->>Admin: Create blog post (requires blogs + website)
    Customer->>Customer: Read blog articles
```

Install order: `website:install` → `blogs:install`

---

## 21. Chatter — Message on Record

Trait `HasChatter` pada model bisnis.

```mermaid
sequenceDiagram
    actor User
    participant Model as Order/Task/Employee
    participant Chatter as HasChatter trait
    participant Msg as chatter_messages

    User->>Model: addMessage(body, type=comment)
    Model->>Chatter: create polymorphic message
    Chatter->>Msg: messageable_type + messageable_id
    User->>Model: addAttachments(files)
    Chatter->>Msg: chatter_attachments
    User->>Model: addFollower(partner)
    Chatter->>Chatter: chatter_followers
```

---

## 22. Custom Fields — Dynamic Attributes

```mermaid
flowchart LR
    A[Admin defines custom_fields] --> B[Attach to model type e.g. Order]
    B --> C[Filament form renders dynamic fields]
    C --> D[Values stored in custom_field_values JSON/pivot]
```

Trait: `Sinno\Field\Traits\HasCustomFields`

---

## 23. Plugin Dependency Install Order

Urutan instalasi otomatis saat `InstallCommand` resolve dependencies:

```mermaid
flowchart TD
    ERP[erp:install] --> Core[Core plugins always active]
    
    subgraph sales_chain [Sales chain]
        P[products] --> A[accounts]
        A --> I[invoices]
        A --> Pay[payments]
        I --> S[sales]
        Pay --> S
    end
    
    subgraph purchase_chain [Purchase chain]
        P --> A
        A --> I
        I --> Pur[purchases]
    end
    
    subgraph mfg_chain [Manufacturing chain]
        P --> Inv[inventories]
        P --> Inv
        Inv --> Mfg[manufacturing]
    end
    
    subgraph hr_chain [HR chain]
        E[employees] --> R[recruitments]
        E --> TO[time-off]
    end
    
    subgraph content_chain [Content chain]
        W[website] --> B[blogs]
    end
    
    Proj[projects] --> TS[timesheets]
```

---

## 24. Analytics — Cost Tracking

```mermaid
flowchart LR
    TS[Timesheet entry] --> AR[analytic_records]
    AR --> R[Reporting / dashboards]
    AR --> P[Project profitability]
```

Tabel `analytic_records` shared; plugin **analytics** menyediakan widget/report infrastructure.

---

## 25. Table Views — Saved Filters

```mermaid
sequenceDiagram
    actor User
    participant Filament Table
    participant TV as table_view_favorites

    User->>Filament Table: Apply filters + column layout
    User->>Filament Table: Save as favorite view
    Filament Table->>TV: store(resource, filters, columns, user_id)
    User->>Filament Table: Load saved view
    Filament Table->>TV: restore state
```

---

## Diagram Integrasi Lintas Modul (Ringkas)

```mermaid
flowchart TB
    subgraph sell [Sell]
        SO[Sales Order] --> DEL[Delivery]
        SO --> INV_C[Customer Invoice]
    end
    subgraph buy [Buy]
        PO[Purchase Order] --> REC[Receipt]
        PO --> INV_V[Vendor Bill]
    end
    subgraph make [Make]
        MO[Manufacturing Order] --> CONS[Consume RM]
        MO --> PROD[Produce FG]
    end
    subgraph stock [Stock]
        DEL --> STK[Stock Moves]
        REC --> STK
        CONS --> STK
        PROD --> STK
    end
    subgraph finance [Finance]
        INV_C --> ACC[Account Moves POSTED]
        INV_V --> ACC
        ACC --> PAY[Payments / Reconcile]
    end
```

---

[Lihat Database ERD →](./DATABASE-ERD.md) · [Kembali ke Architecture →](./ARCHITECTURE.md)
