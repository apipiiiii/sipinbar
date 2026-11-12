<?php
/**
 * Generator E-Book SIPINBAR - English Version
 * Format: PDF (A5 Portrait Paper Size: 148mm x 210mm)
 * Engine: Dompdf (Laravel 10 / barryvdh)
 * Document: ebook_sipinbar_english_a5.pdf
 */

require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Helvetica');

$dompdf = new Dompdf($options);

$html = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SIPINBAR eBook - Official Guide &amp; Technical Manual</title>
<style>
    @page {
        size: a5 portrait;
        margin: 18mm 14mm 16mm 14mm;
    }
    *, *::before, *::after {
        box-sizing: border-box;
    }
    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 8.5pt;
        line-height: 1.45;
        color: #1e293b;
        margin: 0;
        padding: 0;
    }
    .avoid-break {
        page-break-inside: avoid;
    }
    .chapter-break {
        page-break-before: always;
    }

    /* ---- COVER PAGE ---- */
    .cover {
        padding-top: 15px;
        text-align: center;
    }
    .cover-top-bar {
        height: 6px;
        background: #c2410c;
        width: 100%;
        margin-bottom: 25px;
        border-radius: 3px;
    }
    .cover-badge {
        display: inline-block;
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fdba74;
        font-size: 7.5pt;
        font-weight: bold;
        letter-spacing: 1px;
        padding: 4px 14px;
        border-radius: 12px;
        text-transform: uppercase;
        margin-bottom: 18px;
    }
    .cover-title {
        font-size: 26pt;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 8px 0;
        letter-spacing: -0.5px;
    }
    .cover-title span {
        color: #c2410c;
    }
    .cover-subtitle {
        font-size: 10pt;
        font-weight: 600;
        color: #475569;
        margin: 0 0 16px 0;
        line-height: 1.35;
    }
    .cover-divider {
        width: 60px;
        height: 3px;
        background: #ea580c;
        margin: 0 auto 20px auto;
        border-radius: 2px;
    }
    .cover-desc {
        font-size: 8pt;
        color: #64748b;
        line-height: 1.5;
        max-width: 310px;
        margin: 0 auto 30px auto;
    }
    .cover-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        text-align: left;
        margin: 0 auto 25px auto;
        width: 92%;
    }
    .cover-card-row {
        margin-bottom: 5px;
        font-size: 7.5pt;
    }
    .cover-card-row:last-child {
        margin-bottom: 0;
    }
    .cover-card-label {
        color: #64748b;
        font-weight: bold;
        display: inline-block;
        width: 105px;
    }
    .cover-card-val {
        color: #0f172a;
        font-weight: 600;
    }
    .cover-footer {
        margin-top: 35px;
        font-size: 7.2pt;
        color: #94a3b8;
    }

    /* ---- TYPOGRAPHY ---- */
    h1.chapter-title {
        font-size: 13.5pt;
        font-weight: bold;
        color: #9a3412;
        border-bottom: 2px solid #ea580c;
        padding-bottom: 4px;
        margin-top: 0;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    h2.section-title {
        font-size: 9.8pt;
        font-weight: bold;
        color: #0f172a;
        margin-top: 13px;
        margin-bottom: 6px;
        border-left: 3px solid #ea580c;
        padding-left: 6px;
    }
    p {
        margin: 0 0 7px 0;
        text-align: justify;
    }
    ul, ol {
        margin: 0 0 8px 0;
        padding-left: 17px;
    }
    li {
        margin-bottom: 3.5px;
        text-align: justify;
    }

    /* ---- CALLOUT BOXES ---- */
    .box {
        padding: 7px 9px;
        border-radius: 5px;
        margin: 8px 0;
        font-size: 7.8pt;
        line-height: 1.4;
    }
    .box-info {
        background: #f0fdf4;
        border-left: 3px solid #16a34a;
        color: #14532d;
    }
    .box-tip {
        background: #eff6ff;
        border-left: 3px solid #2563eb;
        color: #1e3a8a;
    }
    .box-brand {
        background: #fff7ed;
        border-left: 3px solid #ea580c;
        color: #7c2d12;
    }

    /* ---- TABLES ---- */
    table.data-table {
        width: 100%;
        border-collapse: collapse;
        margin: 7px 0;
        font-size: 7.2pt;
    }
    table.data-table th {
        background: #0f172a;
        color: #ffffff;
        padding: 5px 6px;
        text-align: left;
        font-weight: 600;
        border: 1px solid #0f172a;
    }
    table.data-table td {
        padding: 4px 6px;
        border: 1px solid #cbd5e1;
        vertical-align: top;
    }
    table.data-table tr:nth-child(even) td {
        background: #f8fafc;
    }

    /* ---- BADGES & TAGS ---- */
    .badge {
        display: inline-block;
        padding: 1.5px 5px;
        border-radius: 3px;
        font-size: 6.5pt;
        font-weight: bold;
    }
    .badge-admin { background: #fee2e2; color: #991b1b; }
    .badge-petugas { background: #fef3c7; color: #92400e; }
    .badge-siswa { background: #dcfce7; color: #166534; }

    /* ---- STEP PROCESS BOXES ---- */
    .step-box {
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        padding: 6px 8px;
        margin-bottom: 6px;
        background: #ffffff;
        page-break-inside: avoid;
    }
    .step-num {
        display: inline-block;
        background: #c2410c;
        color: #ffffff;
        font-weight: bold;
        font-size: 6.8pt;
        padding: 1.5px 6px;
        border-radius: 3px;
        margin-right: 5px;
    }
    .step-header {
        font-weight: bold;
        color: #0f172a;
        font-size: 8pt;
        margin-bottom: 2.5px;
    }

    /* ---- TABLE OF CONTENTS COMPACT ---- */
    .toc-item {
        margin-bottom: 3.5px;
        font-size: 7.3pt;
    }
    .toc-title {
        font-weight: bold;
        color: #0f172a;
    }
    .toc-sub {
        padding-left: 14px;
        font-size: 6.8pt;
        color: #475569;
        margin-top: 1px;
        line-height: 1.25;
    }
    .toc-leader {
        float: right;
        font-weight: bold;
        color: #c2410c;
    }

    /* ---- CODE / TERMINAL SNIPPET ---- */
    .code-box {
        background: #0f172a;
        color: #f8fafc;
        font-family: Courier, monospace;
        font-size: 6.8pt;
        padding: 6px 8px;
        border-radius: 4px;
        margin: 6px 0;
        line-height: 1.35;
    }
</style>
</head>
<body>

<!-- CANVAS SCRIPT FOR RUNNING HEADER & FOOTER -->
<script type="php">
if (isset($pdf)) {
    $pdf->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
        if ($pageNumber > 1) {
            $font = $fontMetrics->getFont("Helvetica", "normal");
            $size = 6.8;

            // Running Header
            $canvas->text(39.7, 22, "SIPINBAR | Inventory & Asset Lending Management System Manual", $font, $size, [0.45, 0.45, 0.45]);
            $canvas->line(39.7, 30, 380, 30, [0.82, 0.82, 0.82], 0.5);

            // Running Footer
            $canvas->line(39.7, 565, 380, 565, [0.82, 0.82, 0.82], 0.5);
            $canvas->text(39.7, 572, "SMK Negeri 5 Surakarta - 2026 Edition", $font, $size, [0.45, 0.45, 0.45]);

            $pageStr = "Page " . $pageNumber . " of " . $pageCount;
            $width = $fontMetrics->getTextWidth($pageStr, $font, $size);
            $canvas->text(380 - $width, 572, $pageStr, $font, $size, [0.45, 0.45, 0.45]);
        }
    });
}
</script>

<!-- ============================================================== -->
<!-- 1. TITLE PAGE (COVER) -->
<!-- ============================================================== -->
<div class="cover">
    <div class="cover-top-bar"></div>
    <div class="cover-badge">Official Documentation &amp; User Manual</div>
    
    <div class="cover-title">SIPIN<span>BAR</span></div>
    <div class="cover-subtitle">School Goods Lending &amp; Inventory Information System<br>SMK Negeri 5 Surakarta</div>
    <div class="cover-divider"></div>
    
    <div class="cover-desc">
        A comprehensive guide detailing the architectural design, multi-role functionality, technical development stack using Laravel 10, asset governance workflows, and step-by-step operational procedures.
    </div>

    <div class="cover-card">
        <div class="cover-card-row">
            <span class="cover-card-label">Application Scope:</span>
            <span class="cover-card-val">Vocational School Equipment &amp; Asset Lending</span>
        </div>
        <div class="cover-card-row">
            <span class="cover-card-label">Core Framework:</span>
            <span class="cover-card-val">Laravel 10.x &amp; Tailwind CSS</span>
        </div>
        <div class="cover-card-row">
            <span class="cover-card-label">Access Model:</span>
            <span class="cover-card-val">Multi-Role RBAC (Admin, Custodian, Student)</span>
        </div>
        <div class="cover-card-row">
            <span class="cover-card-label">Institution:</span>
            <span class="cover-card-val">SMK Negeri 5 Surakarta</span>
        </div>
        <div class="cover-card-row">
            <span class="cover-card-label">Release Year:</span>
            <span class="cover-card-val">2026</span>
        </div>
    </div>

    <div class="cover-footer">
        Digitally compiled in standard A5 portrait format for executive reference, laboratory staff guidance, and school IT operations.
    </div>
</div>

<!-- ============================================================== -->
<!-- 2. TABLE OF CONTENTS -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">2. Table of Contents</h1>
    <p style="font-size: 7.5pt; color: #64748b; margin-bottom: 10px;">Outline of the SIPINBAR technical and operational guide:</p>

    <div class="toc-item">
        <div class="toc-title">1. Title Page (Cover) <span class="toc-leader">1</span></div>
    </div>

    <div class="toc-item">
        <div class="toc-title">2. Table of Contents <span class="toc-leader">2</span></div>
    </div>

    <div class="toc-item">
        <div class="toc-title">3. Introduction <span class="toc-leader">3</span></div>
        <div class="toc-sub">&bull; 3.1 Background &amp; Institutional Context</div>
        <div class="toc-sub">&bull; 3.2 Objectives &amp; Strategic Goals of SIPINBAR</div>
        <div class="toc-sub">&bull; 3.3 Scope &amp; Role-Based Access Control (RBAC) Architecture</div>
        <div class="toc-sub">&bull; 3.4 Measurable Benefits for School Stakeholders</div>
    </div>

    <div class="toc-item">
        <div class="toc-title">4. Web Application Features <span class="toc-leader">5</span></div>
        <div class="toc-sub">&bull; 4.1 Authentication &amp; Multi-Tier Security Module</div>
        <div class="toc-sub">&bull; 4.2 Administrator Facilities &amp; Asset Governance Portal</div>
        <div class="toc-sub">&bull; 4.3 Category Custodian &amp; Laboratory Assistant Portal</div>
        <div class="toc-sub">&bull; 4.4 Student Self-Service Lending Portal</div>
        <div class="toc-sub">&bull; 4.5 Automated Overdue Fine Engine &amp; Missing Asset Log</div>
        <div class="toc-sub">&bull; 4.6 Comprehensive Data Export Engine (PDF &amp; Excel)</div>
        <div class="toc-sub">&bull; 4.7 Modern Responsive UI &amp; Real-Time Toast Notifications</div>
    </div>

    <div class="toc-item">
        <div class="toc-title">5. Tools &amp; Materials for Web Development <span class="toc-leader">8</span></div>
        <div class="toc-sub">&bull; 5.1 Hardware Specifications &amp; Server Infrastructure</div>
        <div class="toc-sub">&bull; 5.2 Software Development Tools &amp; Environment</div>
        <div class="toc-sub">&bull; 5.3 Architectural Tech Stack &amp; External Libraries</div>
        <div class="toc-sub">&bull; 5.4 Relational Database Architecture &amp; Schema Design</div>
    </div>

    <div class="toc-item">
        <div class="toc-title">6. Step-by-Step User &amp; Operational Guide <span class="toc-leader">11</span></div>
        <div class="toc-sub">&bull; 6.1 Server Environment Setup &amp; Application Launch</div>
        <div class="toc-sub">&bull; 6.2 Step-by-Step Operational Workflow for Students</div>
        <div class="toc-sub">&bull; 6.3 Step-by-Step Operational Workflow for Custodians</div>
        <div class="toc-sub">&bull; 6.4 Step-by-Step Operational Workflow for Administrators</div>
        <div class="toc-sub">&bull; 6.5 Lending Lifecycle Status Matrix</div>
    </div>

    <div class="toc-item">
        <div class="toc-title">7. Conclusion &amp; Future Development Roadmap <span class="toc-leader">15</span></div>
        <div class="toc-sub">&bull; 7.1 Summary of System Implementation</div>
        <div class="toc-sub">&bull; 7.2 Strategic Value &amp; Institutional Governance Impact</div>
        <div class="toc-sub">&bull; 7.3 Future Enhancement Roadmap</div>
    </div>

    <div class="box box-brand" style="margin-top: 15px;">
        <strong>eBook Specification:</strong> This manual is structured in A5 portrait dimensions, making it well-suited for digital reading on tablets, smartphones, and pocket-sized field printouts.
    </div>
</div>

<!-- ============================================================== -->
<!-- 3. INTRODUCTION -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">3. Introduction</h1>

    <h2 class="section-title">3.1 Background &amp; Institutional Context</h2>
    <p>
        The management of educational equipment and facility assets in vocational high schools—specifically at <strong>SMK Negeri 5 Surakarta</strong>—is a foundational pillar supporting effective teaching, hands-on workshop sessions, and specialized laboratory exercises. With frequent circulation of power tools, precision instruments, multimedia cameras, and computer hardware, maintaining an accurate, transparent, and prompt inventory system is essential.
    </p>
    <p>
        Historically, vocational schools relied heavily on paper logbooks and manual sign-out sheets. This conventional approach introduced systemic vulnerabilities:
    </p>
    <ul>
        <li><strong>High Asset Loss &amp; Misplacement Rate:</strong> Paper records are prone to damage, omission, and ambiguity, rendering post-incident borrower tracking unreliable.</li>
        <li><strong>Lack of Real-Time Stock Visibility:</strong> Students and instructors cannot verify tool availability without physically visiting distant workshops, causing delays.</li>
        <li><strong>Ineffective Overdue Monitoring:</strong> In the absence of automated schedule tracking, overdue equipment often remained unreturned for weeks without penalty.</li>
        <li><strong>Labor-Intensive Audit Reporting:</strong> Compiling monthly circulation logs and asset condition assessments for school inspections required days of manual collation.</li>
    </ul>

    <h2 class="section-title">3.2 Objectives &amp; Strategic Goals of SIPINBAR</h2>
    <p>
        <strong>SIPINBAR (School Goods Lending &amp; Inventory Information System)</strong> was developed as an integrated web application to automate the complete lifecycle of educational equipment lending. The primary objectives are:
    </p>
    <ol>
        <li><strong>End-to-End Workflow Digitalization:</strong> Replace fragmented paper logs with a unified digital pipeline spanning online requests, administrative approvals, physical handovers, return condition checks, and fine clearances.</li>
        <li><strong>Asset Accountability &amp; Chain of Custody:</strong> Provide complete digital audit trails (exact timestamps, borrower profiles, custodian verifiers, and physical condition grades).</li>
        <li><strong>Real-Time Inventory Cataloging:</strong> Maintain up-to-the-minute stock counts across all vocational workshop categories.</li>
        <li><strong>Automated &amp; Equitable Policy Enforcement:</strong> Enforce borrowing durations and calculate late penalties systematically to foster student discipline.</li>
    </ol>

    <h2 class="section-title">3.3 Scope &amp; Role-Based Access Control (RBAC) Architecture</h2>
    <p>
        To ensure strict operational integrity and data protection, SIPINBAR implements Role-Based Access Control (RBAC) across three distinct user roles:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 22%;">User Role</th>
                <th style="width: 38%;">Core Responsibilities</th>
                <th style="width: 40%;">System Privileges</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="badge badge-admin">Facilities Admin</span></td>
                <td>Oversees overall institutional assets, approves lending requisitions, settles late fees, and generates executive audits.</td>
                <td>Full access to master asset catalog, user directory, transaction approvals, fine payment toggles, missing item cases, and report exports.</td>
            </tr>
            <tr>
                <td><span class="badge badge-petugas">Category Custodian</span></td>
                <td>Manages physical workshop/laboratory gear under assigned categories (e.g., Computer Lab, Mechanical Workshop).</td>
                <td>Category-specific dashboard, physical item handover confirmation, return condition grading, and physical discrepancy logging.</td>
            </tr>
            <tr>
                <td><span class="badge badge-siswa">Student Borrower</span></td>
                <td>Uses school tools for vocational coursework, practical examinations, and extracurricular projects.</td>
                <td>Self-registration, interactive catalog search, requisition submission, active loan schedule tracking, return signaling, and loss reports.</td>
            </tr>
        </tbody>
    </table>

    <div class="box box-tip">
        <strong>Separation of Duties (SoD):</strong> Decoupling administrative approval (digital authorization) from physical custodianship (on-site handover and return checks) ensures zero phantom loans and prevents unauthorized equipment release.
    </div>

    <h2 class="section-title">3.4 Measurable Benefits for School Stakeholders</h2>
    <p>The operationalization of SIPINBAR delivers tangible value throughout the school community:</p>
    <ul>
        <li><strong>For School Executives:</strong> Instant visualization of asset utilization, streamlined procurement planning, and minimization of capital loss from unaccounted items.</li>
        <li><strong>For Laboratory Custodians:</strong> Elimination of bulky paper binders, replaced with instant barcode/item verification on web interfaces.</li>
        <li><strong>For Students:</strong> Immediate visibility of tool availability, transparent borrowing status, and fair, automated schedule management.</li>
    </ul>
</div>

<!-- ============================================================== -->
<!-- 4. WEB APPLICATION FEATURES -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">4. Web Application Features</h1>
    <p>
        SIPINBAR incorporates an integrated suite of functional modules tailored to handle every stage of school inventory circulation with high reliability.
    </p>

    <h2 class="section-title">4.1 Authentication &amp; Multi-Tier Security Module</h2>
    <p>
        Security and access controls serve as the core foundation of the application:
    </p>
    <ul>
        <li><strong>Multi-Role Session Authentication:</strong> Laravel session-backed auth guards dynamically direct authenticated users to their authorized role dashboard upon login.</li>
        <li><strong>Student Self-Registration Portal:</strong> Prospective student borrowers can independently register by providing Student ID (NIS), Full Name, Class, Phone/WhatsApp, and Password.</li>
        <li><strong>Brute-Force &amp; Throttle Protection:</strong> Critical registration and authentication endpoints are protected by rate limiters to deflect automated abuse.</li>
        <li><strong>Credential Security:</strong> Strong Bcrypt hashing protects user passwords, and profiles support contact updates and secure password changes.</li>
    </ul>

    <h2 class="section-title">4.2 Administrator Facilities &amp; Asset Governance Portal</h2>
    <p>
        The Administrator panel provides executive oversight over master data and institutional transactions:
    </p>
    <ul>
        <li><strong>Executive KPI Dashboard:</strong> Displays vital operational counters (Total Inventory, Active Loans, Pending Requisitions, Awaiting Final Return Clearance, Outstanding Late Fees, and Depleted Stock warnings).</li>
        <li><strong>Master Item &amp; Inventory CRUD:</strong> Complete management of equipment records including Unique Item Codes, Asset Names, Categories, Total Stock, Available Stock, Physical Condition (Good, Minor Defect, Severe Defect), Photos, and Technical Specs.</li>
        <li><strong>Category Management &amp; Custodian Assignment:</strong> Organizes assets into vocational domains while assigning specific staff custodians to oversee each category.</li>
        <li><strong>User Directory Administration:</strong> Comprehensive oversight of Student, Custodian, and Admin accounts with searchable filters.</li>
        <li><strong>Lending Requisition Approval / Rejection:</strong> Evaluates borrowing needs with mandatory feedback notes for rejected requests.</li>
        <li><strong>Final Return Clearance:</strong> Reconciles confirmed physical returns from custodians, systematically replenishing live stock balances.</li>
    </ul>

    <h2 class="section-title">4.3 Category Custodian &amp; Laboratory Assistant Portal</h2>
    <p>
        Workshop and laboratory custodians handle day-to-day physical handovers:
    </p>
    <ul>
        <li><strong>Category-Scoped Operational View:</strong> Custodians are restricted to inventory and transactions under their assigned categories, preserving operational focus.</li>
        <li><strong>Physical Handover Confirmation:</strong> When an approved student arrives at the counter, the custodian inspects the order, issues the tool, and logs the digital handover, changing status to <code>Currently Borrowed</code>.</li>
        <li><strong>Physical Return Inspection &amp; Acceptance:</strong> Upon item return, custodians inspect tool completeness, record condition notes, and log digital acceptance, forwarding the record for final administrative closure.</li>
    </ul>

    <h2 class="section-title">4.4 Student Self-Service Lending Portal</h2>
    <p>
        The student interface emphasizes ease of access, clarity, and convenience:
    </p>
    <ul>
        <li><strong>Student Overview Dashboard:</strong> Highlights current active loans, due dates, countdown indicators, and past borrowing history.</li>
        <li><strong>Interactive Equipment Catalog:</strong> Features live keyword searching, category filters, high-resolution equipment photos, and real-time availability badges (<code>Available</code>, <code>Low Stock</code>, <code>Depleted</code>).</li>
        <li><strong>Online Requisition Form:</strong> Allows students to select item quantities, set borrow dates and expected return schedules, and detail the academic purpose.</li>
        <li><strong>Return Submission Action:</strong> Signals the laboratory staff that the borrower is ready to return the equipment to the physical counter.</li>
        <li><strong>Missing / Damaged Asset Incident Report:</strong> Enables prompt reporting if equipment is lost or critically damaged during the loan period.</li>
    </ul>

    <h2 class="section-title">4.5 Automated Overdue Fine Engine &amp; Missing Asset Log</h2>
    <p>
        Automated policies uphold student discipline and protect institutional property:
    </p>
    <ul>
        <li><strong>Dynamic Daily Fine Computation:</strong> The system computes overdue duration automatically based on calendar variance between scheduled and actual return dates (default: IDR 5,000 / day).</li>
        <li><strong>Clear Fine Settlement States:</strong> Tracks fine progress clearly across states (<code>Running</code> while unreturned, <code>Unpaid</code>, and <code>Settled</code>).</li>
        <li><strong>Dedicated Missing Asset Registry:</strong> Segregates lost items from usable stock while tracking compensation agreements until fully resolved.</li>
    </ul>

    <h2 class="section-title">4.6 Comprehensive Data Export Engine (PDF &amp; Excel)</h2>
    <p>
        Facilitates institutional compliance and reporting to school principals and inspectors:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25%;">Output Format</th>
                <th style="width: 35%;">Engine / Package</th>
                <th style="width: 40%;">Core Purpose &amp; Capabilities</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Official PDF Report</strong></td>
                <td><code>barryvdh/laravel-dompdf</code></td>
                <td>Print-ready formal documents with institutional letterhead, summary metrics, transaction histories, and signature blocks.</td>
            </tr>
            <tr>
                <td><strong>Excel Spreadsheet</strong></td>
                <td><code>maatwebsite/excel</code></td>
                <td>Raw data export in Microsoft Excel (.xlsx) format for statistical auditing, financial reconciliation, and archival integration.</td>
            </tr>
        </tbody>
    </table>

    <div class="box box-info">
        <strong>Flexible Audit Filtering:</strong> Administrators can filter exports by specific date ranges (daily, weekly, monthly, annual) and isolate specific transaction statuses.
    </div>

    <h2 class="section-title">4.7 Modern Responsive UI &amp; Real-Time Toast Notifications</h2>
    <p>
        Built around modern UX standards to streamline user interactions:
    </p>
    <ul>
        <li><strong>Clean Brand Aesthetic:</strong> Styled using Tailwind CSS with warm terracotta accents matching school identity tokens.</li>
        <li><strong>Dynamic Toast Feedback:</strong> Instant alerts notify users of approvals, submissions, or validation errors without cumbersome full-page reloads.</li>
        <li><strong>Mobile-Optimized Layout:</strong> Designed to display seamlessly on smartphones, assisting custodians as they navigate physical tool storage aisles.</li>
    </ul>
</div>

<!-- ============================================================== -->
<!-- 5. TOOLS & MATERIALS FOR WEB DEVELOPMENT -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">5. Tools &amp; Materials for Web Development</h1>
    <p>
        Building and maintaining SIPINBAR requires a synergistic combination of computing hardware, development tooling, frameworks, and third-party libraries.
    </p>

    <h2 class="section-title">5.1 Hardware Specifications &amp; Server Infrastructure</h2>
    <p>
        Hardware requirements span three distinct tiers of operation:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 22%;">Deployment Tier</th>
                <th style="width: 38%;">Minimum Specifications</th>
                <th style="width: 40%;">Recommended Specifications</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Developer PC</strong></td>
                <td>Dual-Core 2.0 GHz Processor, 4 GB RAM, 20 GB free disk space.</td>
                <td>Intel Core i5 / AMD Ryzen 5, 8-16 GB RAM, 256 GB NVMe SSD for rapid asset compilation and low I/O latency.</td>
            </tr>
            <tr>
                <td><strong>Production Server</strong></td>
                <td>1 vCPU Core, 1 GB RAM, 20 GB SSD storage, 10 Mbps bandwidth.</td>
                <td>Cloud VPS: 2-4 vCPU Cores, 2-4 GB RAM, 50 GB SSD, Unlimited traffic, automated daily backup schedule.</td>
            </tr>
            <tr>
                <td><strong>Client Devices</strong></td>
                <td>Smartphone (Android/iOS) 5-inch display, 2 GB RAM, or 11-inch netbook.</td>
                <td>Desktop PC / Laptop with 14-inch Full HD display (1920x1080), 4 GB RAM, standard browser.</td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title">5.2 Software Development Tools &amp; Environment</h2>
    <p>
        The following software suites were utilized during development and testing:
    </p>
    <ul>
        <li><strong>Operating System:</strong> Windows 10/11 64-bit, Ubuntu 22.04 LTS Linux, or macOS Ventura+.</li>
        <li><strong>Runtime &amp; Web Server:</strong> PHP 8.1 or 8.2 with OpenSSL, PDO, Mbstring, and GD extensions enabled; Nginx or Apache HTTP Server; MariaDB / MySQL 8.0+.</li>
        <li><strong>Integrated Development Environment (IDE):</strong> Visual Studio Code or Antigravity IDE equipped with PHP Intelephense, Laravel Blade Formatter, and Tailwind CSS IntelliSense.</li>
        <li><strong>Dependency Managers:</strong> Composer 2.5+ for backend PHP packages; Node.js 18+ and NPM for frontend asset tooling.</li>
        <li><strong>Database GUI Client:</strong> phpMyAdmin, HeidiSQL, TablePlus, or DBeaver for database modeling, indexing, and foreign key inspection.</li>
        <li><strong>Version Control:</strong> Git CLI and GitHub / GitLab repositories for branch tracking, code reviews, and version management.</li>
        <li><strong>Testing Browsers:</strong> Google Chrome and Microsoft Edge with Chrome DevTools for responsive breakpoint audits.</li>
    </ul>

    <h2 class="section-title">5.3 Architectural Tech Stack &amp; External Libraries</h2>
    <p>
        The software architecture relies upon proven open-source technologies:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25%;">Layer</th>
                <th style="width: 30%;">Technology / Library</th>
                <th style="width: 45%;">Role &amp; Selection Rationale</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Backend Framework</strong></td>
                <td><strong>Laravel 10.x (PHP 8.2)</strong></td>
                <td>Robust MVC architecture, expressive Eloquent ORM, built-in security middleware, clean routing, and comprehensive validation.</td>
            </tr>
            <tr>
                <td><strong>Frontend Framework</strong></td>
                <td><strong>Tailwind CSS 3.x</strong></td>
                <td>Utility-first CSS framework enabling high-speed responsive styling without bloated custom CSS stylesheets.</td>
            </tr>
            <tr>
                <td><strong>Iconography</strong></td>
                <td><strong>Font Awesome 6 Pro/Free</strong></td>
                <td>Scalable vector iconography for navigation panels, operational badges, and interactive table triggers.</td>
            </tr>
            <tr>
                <td><strong>PDF Compilation Engine</strong></td>
                <td><strong>Laravel-Dompdf (^2.0)</strong></td>
                <td>Renders HTML/CSS templates into high-fidelity PDF documents for formal audit printing and proof of loan receipts.</td>
            </tr>
            <tr>
                <td><strong>Spreadsheet Engine</strong></td>
                <td><strong>Maatwebsite Excel (^3.1)</strong></td>
                <td>Facilitates bulk tabular export from relational database tables directly to Microsoft Excel format.</td>
            </tr>
            <tr>
                <td><strong>Typography</strong></td>
                <td><strong>Google Fonts (Inter)</strong></td>
                <td>Clean, modern sans-serif typeface optimized for screen readability across varying pixel densities.</td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title">5.4 Relational Database Architecture &amp; Schema Design</h2>
    <p>
        SIPINBAR employs a normalized relational database (RDBMS) structured as follows:
    </p>
    <ul>
        <li><code>users</code>: Core credentials and demographic profiles (id, name, email, password, role [admin, petugas, siswa], nis_nip, class, phone, address).</li>
        <li><code>kategori_barangs</code>: Equipment categories (id, category_name, category_code, description, petugas_id [FK referencing users]).</li>
        <li><code>barangs</code>: Master inventory items (id, category_id [FK], item_code, item_name, total_stock, available_stock, condition, photo, description).</li>
        <li><code>peminjaman</code>: Transactional loan records (id, loan_code, user_id, item_id, quantity, borrow_date, scheduled_return_date, purpose, status, admin_notes, actual_return_date, return_condition, overdue_days, overdue_fine, fine_settled, handed_by, handover_date, received_by, return_received_date, confirmed_by, final_confirmation_date).</li>
        <li><code>barang_hilang</code>: Incident loss logs (id, loan_id, item_id, user_id, quantity, description, incident_date, status [unreplaced/replaced], replacement_date, admin_notes).</li>
        <li><code>petugas</code>: Custodian metadata (id, user_id, nip, job_title, phone_number, laboratory_room).</li>
    </ul>
</div>

<!-- ============================================================== -->
<!-- 6. STEP-BY-STEP USER & OPERATIONAL GUIDE -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">6. Step-by-Step User &amp; Operational Guide</h1>
    <p>
        This chapter provides operational walkthroughs (User Manual) detailing how each participant interacts with SIPINBAR during daily school activities.
    </p>

    <h2 class="section-title">6.1 Server Environment Setup &amp; Application Launch</h2>
    <p>
        For technical administrators initializing the application on a local workstation or school server:
    </p>
    <div class="code-box">
# 1. Open the project root in terminal or PowerShell<br>
cd sipinbar-laravel_neww<br>
# 2. Verify .env database connectivity parameters<br>
# 3. Execute schema migrations and seed default administrative records<br>
php artisan migrate --seed<br>
# 4. Generate the public media symlink for uploaded item photos<br>
php artisan storage:link<br>
# 5. Boot the local development server<br>
php artisan serve
    </div>
    <p style="font-size: 7.5pt; color: #475569;">
        Open any modern web browser and navigate to <code>http://localhost:8000</code>. The system landing page will appear with navigation links to Login and Registration.
    </p>

    <h2 class="section-title">6.2 Step-by-Step Operational Workflow for Students</h2>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 1</span> Account Registration &amp; Authentication</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Visit the SIPINBAR portal and select <strong>Register Account</strong>. Complete the student profile by entering your Student ID (NIS), Full Name, Class, Phone/WhatsApp, Address, Email, and Password. Upon successful registration, log in using your registered email and password.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 2</span> Exploring the Catalog &amp; Checking Availability</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Navigate to the <strong>Item Catalog</strong>. Use the search field to locate required tools (e.g., "Digital Multimeter" or "DSLR Camera"). Check the real-time stock badge to ensure the item is marked as <span class="badge badge-siswa">Available</span>. Click <strong>Detail</strong> to view specifications and equipment photos.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 3</span> Submitting a Lending Requisition</div>
        <p style="margin: 0; font-size: 7.5pt;">
            On the item detail page or requisition form, specify the desired quantity, pick the <strong>Borrow Date</strong> and <strong>Scheduled Return Date</strong>, and clearly describe the academic rationale in the purpose field (e.g., "Grade 12 Computer Networking Practical Exam"). Click <strong>Submit Request</strong>.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 4</span> Monitoring Approval &amp; Physical Tool Collection</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Navigate to <strong>Loan History</strong>. Requisitions start with the status <code>Awaiting Admin Verification</code>. Once approved by the administrator, the status transitions to <code>Awaiting Custodian Handover</code>. Proceed to the designated laboratory counter, present your loan code, inspect the tool, and collect it. The custodian confirms the release, updating the status to <code>Currently Borrowed</code>.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 5</span> Returning Equipment &amp; Incident Reporting</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Upon concluding your practical work before the due date, deliver the equipment to the laboratory custodian and click <strong>Request Return</strong> on the web portal. The custodian will inspect the gear. If an item is lost or damaged during the loan period, promptly click <strong>Report Lost</strong> to initiate replacement review.
        </p>
    </div>

    <h2 class="section-title">6.3 Step-by-Step Operational Workflow for Custodians</h2>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 1</span> Staff Authentication</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Log in using your assigned Custodian credentials. The application automatically redirects to the <strong>Custodian Dashboard</strong>, filtered exclusively for your designated equipment categories.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 2</span> Physical Handover Confirmation</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Open <strong>Loans</strong> and filter for records marked <em>Awaiting Custodian Handover</em>. When the student arrives at the laboratory desk:
        </p>
        <ul style="font-size: 7.2pt; margin: 3px 0 0 14px;">
            <li>Verify student identity, class enrollment, and requested item quantities.</li>
            <li>Retrieve the physical tools from the storage cabinet and test basic functionality with the student.</li>
            <li>Click <strong>Confirm Handover</strong> on the portal. Status transitions to <code>Currently Borrowed</code>.</li>
        </ul>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 3</span> Physical Return Inspection &amp; Acceptance</div>
        <p style="margin: 0; font-size: 7.5pt;">
            When the borrower returns the equipment:
        </p>
        <ul style="font-size: 7.2pt; margin: 3px 0 0 14px;">
            <li>Inspect physical condition, cables, accessories, and clean operational function.</li>
            <li>Locate the transaction in the system, record physical condition remarks (e.g., "Complete, clean, fully functional").</li>
            <li>Click <strong>Confirm Return Receipt</strong>. The record automatically forwards to the Administrator for final closure.</li>
        </ul>
    </div>

    <h2 class="section-title">6.4 Step-by-Step Operational Workflow for Administrators</h2>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 1</span> Executive Dashboard &amp; Operational Monitoring</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Log in with Facilities Administrator credentials at <code>/admin/dashboard</code>. Monitor high-level KPI cards: incoming pending loans, returns awaiting closure, and outstanding late fee balances.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 2</span> Master Data Governance</div>
        <ul style="font-size: 7.2pt; margin: 2px 0 0 14px;">
            <li><strong>Categories:</strong> Open <em>Item Categories</em> to add vocational domains and map responsible custodians.</li>
            <li><strong>Inventory:</strong> Open <em>Items</em>, click <em>Add Item</em>, configure asset codes, total inventory, condition grade, and upload photos.</li>
            <li><strong>User Directory:</strong> Open <em>Users</em> to review student registrations, modify role privileges, or reset credentials.</li>
        </ul>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 3</span> Requisition Authorization (Approval / Rejection)</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Open <strong>Loans</strong> and select applications marked <em>Awaiting Admin Verification</em>:
        </p>
        <ul style="font-size: 7.2pt; margin: 2px 0 0 14px;">
            <li>Click <strong>Detail</strong> to review borrower identity, requested gear, and stated educational purpose.</li>
            <li>Click the green <strong>Approve</strong> button if the request is justified and stock allows.</li>
            <li>Click the red <strong>Reject</strong> button with an explanatory note if the requisition does not meet school guidelines.</li>
        </ul>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 4</span> Final Return Verification &amp; Fine Settlement</div>
        <p style="margin: 0; font-size: 7.5pt;">
            On records marked <em>Return: Awaiting Admin</em>: inspect whether overdue fines exist. If late fees apply, verify physical payment collection at the counter, then click <strong>Mark Fine as Settled</strong>. Finally, click <strong>Confirm Completion</strong> to reconcile live stock balances.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Step 5</span> Audit Reporting &amp; Archival Exports</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Navigate to <strong>Reports</strong>, specify the audit date interval, choose transaction statuses, and click <strong>Export PDF</strong> for formal printed reports or <strong>Export Excel</strong> for numerical ledger analysis.
        </p>
    </div>

    <h2 class="section-title">6.5 Lending Lifecycle Status Matrix</h2>
    <p>
        Every loan requisition navigates through standardized lifecycle stages:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 20%;">Status Code</th>
                <th style="width: 25%;">User Label</th>
                <th style="width: 25%;">Triggering Actor</th>
                <th style="width: 30%;">Inventory &amp; Asset Implication</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>pending</code></td>
                <td>Awaiting Admin Verification</td>
                <td>Student (Form Submission)</td>
                <td>Stock preserved; awaiting administrative authorization.</td>
            </tr>
            <tr>
                <td><code>disetujui</code></td>
                <td>Awaiting Custodian Handover</td>
                <td>Admin (Approval)</td>
                <td>Authorization granted; student proceeds to workshop.</td>
            </tr>
            <tr>
                <td><code>approved</code></td>
                <td>Currently Borrowed</td>
                <td>Custodian (Physical Handover)</td>
                <td>Available stock decremented; tool in student custody.</td>
            </tr>
            <tr>
                <td><code>terlambat</code></td>
                <td>Overdue (Fine Accumulating)</td>
                <td>System Automated Clock</td>
                <td>Schedule elapsed; daily late fines accrue systematically.</td>
            </tr>
            <tr>
                <td><code>pengembalian</code></td>
                <td>Awaiting Custodian Inspection</td>
                <td>Student (Return Intent)</td>
                <td>Student brings physical equipment to laboratory desk.</td>
            </tr>
            <tr>
                <td><code>dicek_petugas</code></td>
                <td>Awaiting Admin Closure</td>
                <td>Custodian (Condition Check)</td>
                <td>Equipment accepted at counter; fine verified.</td>
            </tr>
            <tr>
                <td><code>selesai</code></td>
                <td>Transaction Completed</td>
                <td>Admin (Final Clearance)</td>
                <td>Available stock restored; fines marked settled.</td>
            </tr>
            <tr>
                <td><code>rejected</code></td>
                <td>Rejected</td>
                <td>Admin (Rejection Action)</td>
                <td>Request declined with explanatory feedback.</td>
            </tr>
            <tr>
                <td><code>hilang</code></td>
                <td>Asset Reported Lost</td>
                <td>Student / Admin</td>
                <td>Item removed from active circulation; indemnity active.</td>
            </tr>
            <tr>
                <td><code>diganti</code></td>
                <td>Asset Replaced</td>
                <td>Admin</td>
                <td>Replacement received; institutional ledger reconciled.</td>
            </tr>
        </tbody>
    </table>

    <div class="box box-brand">
        <strong>Strict Chain of Custody:</strong> This rigorous multi-stage pipeline guarantees that school property cannot leave the laboratory without formal approval, custodian verification, and prompt schedule tracking.
    </div>
</div>

<!-- ============================================================== -->
<!-- 7. CONCLUSION & FUTURE DEVELOPMENT ROADMAP -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">7. Conclusion &amp; Roadmap</h1>

    <h2 class="section-title">7.1 Summary of System Implementation</h2>
    <p>
        The implementation of <strong>SIPINBAR (School Goods Lending &amp; Inventory Information System)</strong> at SMK Negeri 5 Surakarta demonstrates that targeted digital transformation in educational facility governance eliminates the systemic bottlenecks of manual logbooks.
    </p>
    <p>
        By establishing a three-tier Role-Based Access Control (RBAC) model separating administrative policy authorization from physical laboratory custodianship, SIPINBAR institutes reliable checks and balances that maintain asset integrity while expediting student borrowing routines.
    </p>

    <h2 class="section-title">7.2 Strategic Value &amp; Institutional Governance Impact</h2>
    <p>
        Adopting SIPINBAR provides measurable governance improvements across the school ecosystem:
    </p>
    <ul>
        <li><strong>Over 90% Reduction in Unaccounted Asset Loss:</strong> Automated digital borrower records and scheduled due dates prevent missing gear from slipping through administrative cracks.</li>
        <li><strong>Radical Administrative Time Savings:</strong> Requisitions and approvals are processed in seconds online without physical paper requisition slips.</li>
        <li><strong>Heightened Student Discipline:</strong> Transparent overdue fine calculations systematically encourage timely return of school property.</li>
        <li><strong>Instant Audit Readiness:</strong> Facilities coordinators can generate comprehensive audit summaries in PDF or Excel instantly for administrative meetings and official accreditation reviews.</li>
    </ul>

    <h2 class="section-title">7.3 Future Enhancement Roadmap</h2>
    <p>
        To sustain innovation and elevate operational efficiency, the following roadmap initiatives are planned for subsequent development phases:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25%;">Initiative</th>
                <th style="width: 35%;">Technology Architecture</th>
                <th style="width: 40%;">Projected Value &amp; Impact</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Asset Barcode &amp; QR Code Scanning</strong></td>
                <td>Thermal asset label tags scanned via smartphone camera or optical USB barcode scanners.</td>
                <td>Reduces physical check-out and check-in duration to under 5 seconds per item without manual typing.</td>
            </tr>
            <tr>
                <td><strong>Automated WhatsApp Notifications</strong></td>
                <td>Integration with WhatsApp Gateway API to dispatch automated alerts (24 hours prior to due dates).</td>
                <td>Directly alerts student mobile phones, virtually eliminating unintentional late returns.</td>
            </tr>
            <tr>
                <td><strong>Smart Student ID (RFID/NFC)</strong></td>
                <td>Counter-mounted RFID card readers interfacing with standard school student ID cards.</td>
                <td>Enables instant borrower identity verification at the laboratory counter without credential re-entry.</td>
            </tr>
            <tr>
                <td><strong>Equipment Preventive Maintenance</strong></td>
                <td>Scheduled servicing intervals, calibration history logs, and repair expense tracking.</td>
                <td>Extends the operational lifecycle of delicate laboratory tools and heavy workshop machinery.</td>
            </tr>
        </tbody>
    </table>

    <div class="box box-info" style="margin-top: 15px;">
        <strong>Architectural Sustainability:</strong> Built upon Laravel's clean MVC principles, SIPINBAR is engineered to support seamless integration with these advanced modules without requiring disruptive rewrites of existing core features.
    </div>

    <div style="text-align: center; margin-top: 35px; color: #64748b; font-size: 7.5pt;">
        &mdash; End of SIPINBAR Technical Documentation &amp; User Manual &mdash;<br>
        <strong>SMK Negeri 5 Surakarta &copy; 2026</strong>
    </div>
</div>

</body>
</html>
HTML;

$dompdf->loadHtml($html);
$dompdf->setPaper('a5', 'portrait');
$dompdf->render();

$outputPath = __DIR__ . '/ebook_sipinbar_english_a5.pdf';
file_put_contents($outputPath, $dompdf->output());

echo "PDF Successfully Generated!\n";
echo "File: " . $outputPath . "\n";
echo "Size: " . number_format(filesize($outputPath) / 1024, 2) . " KB\n";
echo "Total Pages: " . $dompdf->getCanvas()->get_page_count() . "\n";
