<p align="center">
  <h1 align="center">Changelog</h1>
  <p align="center">
    Audit Logging and Inventory Enhancements
  </p>
</p>

---

## Latest Update

### Added

- Structured audit logging with `details (JSON)` support  
- Approval History module for approved and rejected transactions  
- Filters for date and shelf  
- Scrollable activity section for better navigation  
- Modal view for transaction item breakdown  

---

### Improvements

#### Audit Log System

- Standardized log structure across all modules:
  - `action`, `module`, `description`, `reference_id`, `reference_no`
- Added support for:
  - Item-level transaction details  
  - Before and after comparisons  

---

#### Inventory Module

- Enhanced logging for:
  - **Stock In** — product, quantity, shelf, renter  
  - **Stock Out** — deductions with batch tracking  
  - **Adjustment** — mode-based quantity updates  

---

#### Approval System

- Logs now include transaction references and details  
- Rejection logs include review remarks  
- Full tracking of approval and rejection actions  

---

#### Product Module

- Added logging for Create, Update, and Delete  
- Logs now include:
  - Product details  
  - Shelf and renter context  
- Update logs store before and after values  

---

#### Shelf Module

- Added logging for Create, Update, and Delete  
- Tracks:
  - Shelf number  
  - Monthly rent  
  - Renter assignment  
  - Contract dates  
  - Shelf status  
- Update logs include before and after comparison  

---

#### Shelf Assignment

- Added logs for:
  - Assigning renter to shelf  
  - Unassigning renter  
- Includes shelf number and renter company  

---

#### Renter Module

- Added logging for Create, Update, and Delete  
- Logs capture:
  - Personal and company details  
  - Contact information  
  - Contract duration  
  - Status  
- Update logs include before and after snapshots  

---

### UI Enhancements

- Improved audit logs table and modal  
- Displays:
  - User  
  - Role  
  - Action  
  - Module  
  - Reference number  
  - Description  
- Prepared for structured detail rendering  

---

### Notes

The system now provides a complete audit trail across:

- Inventory  
- Approvals  
- Products  
- Shelves  
- Renters  
