# Library Management System

A PHP + MySQL web application for managing library operations — book inventory, categories, authors, and issued/returned books — with separate admin and user login flows.

This started as an early student project and has since been hardened: all database queries now use prepared statements, passwords are hashed, and two real data-corruption bugs were fixed. Details on exactly what changed are below, verified by running the app locally against a real MySQL/MariaDB instance.

---

## Features

**Admin panel** (`admin/`)
- Add, edit, and delete books, authors, and categories
- Issue books to registered users and track issued/returned status
- Manage own admin profile and password

**User panel**
- Register and log in
- View and edit personal profile, change password
- View count and list of currently issued books

---

## Tech Stack

| Category   | Technology                        |
|------------|--------------------------------------|
| Frontend   | HTML, CSS, Bootstrap 4.4.1, jQuery    |
| Backend    | PHP (procedural, no framework)         |
| Database   | MySQL / MariaDB (`mysqli`, prepared statements) |

---

## Project Structure

```
Library-Management-System/
├── config.php            # Centralized DB connection (env-var overridable)
├── index.php              # User login
├── signup.php               # User registration form
├── register.php              # Processes registration (hashed password)
├── user_dashboard.php          # User home: issued book count
├── view_issued_book.php         # User's issued books
├── view_profile.php / edit_profile.php / change_password.php / update.php / update_password.php
├── admin/
│   ├── config → shares root config.php via require_once __DIR__.'/../config.php'
│   ├── index.php               # Admin login
│   ├── admin_dashboard.php      # Admin home
│   ├── manage_book.php / add_book.php / edit_book.php / delete_book.php
│   ├── manage_author.php / add_author.php / edit_author.php / delete_author.php
│   ├── manage_cat.php / add_cat.php / edit_cat.php / delete_cat.php
│   ├── issue_book.php           # Issue a book to a user
│   ├── view_issued_book.php      # All issued books
│   └── functions.php             # Shared dashboard-count helper functions
├── bootstrap-4.4.1/               # Vendored Bootstrap (CSS/JS)
├── lms.sql                          # Database schema + seed data (hashed passwords)
└── images/                            # UI background images
```

---

## Setup

Requires a local PHP (8+) and MySQL/MariaDB environment (e.g., XAMPP, WAMP, MAMP, or plain `php -S` + a local MySQL install).

1. Place the project folder inside your server's web root (e.g., `htdocs/` for XAMPP), or run PHP's built-in server from the project root: `php -S localhost:8000`.
2. Create a database named `lms` and import `lms.sql`.
3. By default, `config.php` connects as `root` with no password on `localhost` — matching typical local XAMPP/WAMP defaults. To use different credentials, set environment variables before starting PHP: `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`.
4. Visit `http://localhost:8000/index.php` for the user login, or `.../admin/index.php` for the admin login.

**Default seeded credentials** (from `lms.sql`):
- Admin: `admin@gmail.com` / `admin@123`
- User: `user@gmail.com` / `user@123`

(Passwords are stored as bcrypt hashes in `lms.sql` — the plaintext values above are only for logging in through the UI.)

---

## Database Schema

Five tables, defined in `lms.sql`:

- **`admins`** — id, name, email, password (bcrypt hash), mobile
- **`users`** — id, name, email, password (bcrypt hash), mobile, address
- **`books`** — book_id, book_name, author_id, cat_id, book_no, book_price
- **`authors`** — author_id, author_name
- **`category`** — cat_id, cat_name
- **`issued_books`** — s_no, book_no, book_name, book_author, student_id, status, issue_date

---

## What Was Fixed

This project was hardened in a dedicated pass. Every change below was verified by running the app locally against real MariaDB, hitting it with actual HTTP requests, and checking the database state directly — not just read through.

- **SQL injection, fixed throughout.** Every query that previously built SQL by interpolating `$_POST`/`$_GET`/`$_SESSION` directly into a string is now a parameterized `mysqli` prepared statement. Verified with a classic `' OR '1'='1` injection attempt against the login form — correctly rejected after the fix (it would have logged in as an arbitrary user before).
- **Passwords are hashed.** Registration and login now use `password_hash()` / `password_verify()` (bcrypt) instead of storing and comparing plaintext. The seed data in `lms.sql` was regenerated with real bcrypt hashes.
- **Fixed a data-corruption bug in profile updates.** The original `update.php` (both the user-facing and admin versions) ran `UPDATE users SET ... ` / `UPDATE admins SET ...` with **no `WHERE` clause**, meaning saving any one profile silently overwrote every row in the table. Verified with a two-user test: before the fix, editing one user's profile would have renamed every user in the database; after the fix, only the logged-in user's row changes.
- **Centralized the database connection.** All ~30 files previously opened their own independent `mysqli_connect("localhost","root","")` call. Replaced with a single shared `config.php`, overridable via `DB_HOST`/`DB_USER`/`DB_PASS`/`DB_NAME` environment variables.
- **Fixed a broken redirect.** `register.php` redirected to a non-existent `login.php` after signup (the login page is actually `index.php`); new users hit a 404 immediately after registering. Now redirects correctly.
- **Fixed a mismatched form field.** In `admin/add_book.php`, the "Category ID" input was named `book_id` but read into the `cat_id` column — functionally worked by accident, but was confusing and fragile. Renamed to `cat_id` to match its actual purpose.
- **Escaped output.** User-supplied values (names, addresses, book titles, etc.) are now passed through `htmlspecialchars()` before being echoed into HTML, closing a stored-XSS gap that existed wherever this data was later displayed.
- **Fixed broken navigation links** on several user-facing pages (`edit_profile.php`, `view_profile.php`, `view_issued_book.php`, `change_password.php`) that pointed to `../logout.php` and `admin_dashboard.php` — leftover copy-paste from the admin templates that didn't resolve correctly from the root-level pages.

---

## Known Limitations

Issues that are still open, being upfront about them rather than glossing over:

- **`mobile` columns are `int(10)`**, which overflows for real 10-digit phone numbers (max signed 32-bit int is ~2.1 billion). This is a pre-existing schema issue — even the original seed data's mobile number (`2147483644`) is suspiciously close to that ceiling. Registering with a real phone number can trigger a database error. Should be changed to `varchar`.
- **No CSRF protection** on any form (add/edit/delete actions, profile updates, password changes).
- **Delete actions use plain `GET` links** (`delete_book.php?bn=...`) rather than a confirmation step or `POST` request — a crawler or prefetcher following these links could trigger deletions.
- **No search feature** — despite being a natural fit for a library system, there's currently no book search/browse capability for users; the user dashboard only shows an issued-book count and link.
- **No rate limiting** on login attempts.

---

## Future Enhancements

- Change `mobile` columns from `int` to `varchar`
- Add CSRF tokens to all state-changing forms
- Convert delete actions from `GET` links to confirmed `POST` requests
- Add book search/browse for users
- Add login rate limiting
- Move the HTML nav/header markup (currently duplicated across every page) into a shared include

---

## Learning Outcomes

This project was useful for learning:

- Core PHP without a framework — form handling, sessions, `mysqli` database access
- Basic relational schema design (books, authors, categories, issued-books, users)
- Separating admin and user access flows
- Where it fell short taught real lessons too: the SQL injection, plaintext passwords, and missing-WHERE-clause bugs found here were a direct before/after reference point for how I approach database access in later projects (e.g., using prepared statements and hashed passwords from the start in `taskflow-api`).
