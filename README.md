# Placement Web System

A web platform for students and companies:
- Student module: register/login, profile, resume upload, apply to jobs
- Company module: register/login, post jobs, view applicants, select/reject
- Admin module: dashboards + reports (students, companies, jobs, applications)

## Tech Stack
- PHP, HTML, CSS, JS (or your actual stack)
- MySQL

## Local Setup
1. Import `database.sql` into MySQL
2. Copy `config.example.php` to `config.php` and fill DB creds
3. Start local server (XAMPP/WAMP/etc.)
4. Visit `http://localhost/placement-web-system/`

## Environment Variables / Config
- `config.php` (not committed): holds DB credentials

## Features
- Student registration & profile
- Company job postings
- Applications with status (Pending/Accepted/Rejected)
- Admin reports:
  - Registered students, per-dept counts
  - Companies & job counts
  - Jobs with most/no applicants
  - Application status breakdown
  - Total applications by student


