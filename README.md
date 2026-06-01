# Yii2 Claims Management System

A Yii2-based Claims Management application developed as part of a technical assessment.

The application demonstrates:

- Claims listing with filtering
- Expandable claim detail view
- Dynamic grid column configuration
- User-specific grid preferences
- Excel export functionality
- PJAX-powered updates
- Service-based architecture

---

## Tech Stack

| Component | Version |
|------------|------------|
| PHP | 8.3 |
| Yii Framework | Yii2 |
| Database | MySQL |
| Frontend | Bootstrap 5 |
| JavaScript | jQuery |
| Grid Library | Kartik GridView |

---

## Features

### Claims Listing

- Searchable claims grid
- Server-side filtering
- Date range filtering
- Currency formatting
- Responsive UI

### Expandable Claim Details

- Expand row functionality
- AJAX-loaded child records
- Optimized data retrieval

### Grid Configuration

Users can:

- Show/Hide columns
- Save preferences
- Persist configuration per user

Configurations are stored in:

```sql
grid_configurations
```

### Export to Excel

Export filtered grid records directly to Excel.

### PJAX Integration

- Faster grid updates
- Reduced page reloads
- Improved user experience

---

## Project Structure

```text
controllers/
├── ClaimsController.php

models/
├── Claims.php
├── ClaimDetails.php
├── ClaimsSearch.php
├── GridConfigurations.php

services/
├── Claims/
│   ├── ClaimsService.php
│   └── ClaimsExportService.php
│
└── Grid/
    └── GridConfigService.php

views/
└── claims/
    ├── index.php
    ├── _detail.php
    ├── _config_modal.php
    └── _search.php

web/
└── js/
    └── claims.js
```

---

# Installation

## Clone Repository

```bash
git clone https://github.com/Santosh-Paratsone-TechDev/yii-grid-task.git

cd yii-grid-task
```

---

## Install Dependencies

```bash
composer install
```

---

## Configure Database

Update database credentials in:

```text
config/db.php
```

Example:

```php
return [
    'class' => yii\db\Connection::class,
    'dsn' => 'mysql:host=localhost;dbname=yii_task',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];
```

---

## Create Database

```sql
CREATE DATABASE yii_task
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

---

## Run Migrations

Execute all migrations:

```bash
php yii migrate
```

---

## Import Sample Data

After migrations are complete, import the provided SQL dump.

```bash
mysql -u root -p yii_task < yii_swarnasky.sql
```

> Note:
>
> Migrations create the database structure.
>
> The SQL dump contains the sample assessment data required for testing.

---

## Start Development Server

```bash
php yii serve
```

Application will be available at:

```text
http://localhost:8080
```

---

# Database

## Main Tables

### claims

Stores master claim records.

### claim_details

Stores child detail records associated with claims.

### grid_configurations

Stores user-specific grid visibility preferences.

### users

Application users.

---

# Usage

## Configure Columns

1. Click **Configure Columns**
2. Select visible columns
3. Save Configuration

Preferences are automatically persisted.

---

## Filter Claims

Use grid filters to search:

- File Number
- Manager Name
- Service Provider
- Claim Number
- Date Fields
- Financial Fields

---

## View Details

Click the expand icon on any row to view related claim details.

---

## Export Data

Click **Export Excel** to export the currently filtered dataset.

---

# Environment Requirements

## PHP Extensions

Required:

```text
pdo_mysql
mbstring
intl
json
curl
xml
zip
gd
```

---

# Deployment

Production deployment steps:

```bash
composer install --no-dev --optimize-autoloader

php yii migrate --interactive=0

mysql -u root -p database_name < yii_swarnasky.sql
```

---

# Assessment Scope Completed

- Claims Grid
- Search & Filters
- Expand Row Details
- Dynamic Grid Configuration
- User Preference Persistence
- Excel Export
- PJAX Updates
- Service Layer Implementation

---

# Author

**Santosh Paratsone**

GitHub:
https://github.com/Santosh-Paratsone-TechDev

Repository:
https://github.com/Santosh-Paratsone-TechDev/yii-grid-task