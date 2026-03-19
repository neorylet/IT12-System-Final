Added

Implemented structured audit logging with details (JSON) support

Added Approval History module for viewing approved and rejected transactions

Added filters (date, shelf) and scrollable activity section in approval history

Added modal view for detailed transaction item breakdown

Improved
Audit Log System

Standardized logging across modules:

action, module, description, reference_id, reference_no

Enabled support for:

item-level transaction details

before/after comparisons for updates

Inventory Module

Enhanced logging for:

Stock In (products, quantities, shelf, renter)

Stock Out (deductions, batch-based removal, product breakdown)

Adjustment (mode, quantity changes, resulting stock)

Approval System

Approval logs now include transaction references and details

Rejection logs now include review remarks

Added full tracking for approval and rejection actions

Product Module

Added logging for Create, Update, and Delete

Logs now include:

product details

shelf and renter information

Update logs now store before and after states

Shelf Module

Added logging for Create, Update, and Delete

Tracks:

shelf number

monthly rent

renter assignment

contract dates

shelf status

Update logs include before and after comparison

Shelf Assignment

Added logs for:

assigning renter to shelf

unassigning renter

Includes shelf number and renter company

Renter Module

Added logging for Create, Update, and Delete

Logs now capture:

personal and company details

contact information

contract duration

status

Update logs include before and after snapshots

UI Enhancements

Improved audit logs table and modal display

Displays:

user, role, action, module

reference number and description

Prepared UI for rendering structured log details

Notes

System now supports full audit trail across major modules:

Inventory

Approvals

Products

Shelves

Renters
