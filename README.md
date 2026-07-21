# Library Management System

A PHP + MySQL web application for managing library operations — book inventory, categories, authors, and issued/returned books — with separate admin and user login flows. Built as an early full-stack project using core PHP (no framework) and Bootstrap for styling.

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
| Database   | MySQL / MariaDB (`mysqli`)              |

---

## Project Structure

```
Library-Management-System/
├── index.php              # User login
├── signup.php               # User registration form
├── register.php              # Processes registration (inserts into `users`)
├── user_dashboard.php          # User home: issued book count
├── view_issued_book.php         # User's issued books
├── view_profile.php / edit_profile.php / change_password.php
├── admin/
│   ├── index.php               # Admin login
│   ├── admin_dashboard.php      # Admin home
│   ├── manage_book.php / add_book.php / edit_book.php / delete_book.php
│   ├── manage_author.php / add_author.php / edit_author.php / delete_author.php
│   ├── manage_cat.php / add_cat.php / edit_cat.php / delete_cat.php
│   ├── issue_book.php           # Issue a book to a user
│   ├── view_issued_book.php      # All issued books
│   └── functions.php             # Shared helper functions
├── bootstrap-4.4.1/               # Vendored Bootstrap (CSS/JS)
├── lms.sql                          # Database schema + seed data
└── images/                            # UI background images
```

---

## Setup

Requires a local PHP + MySQL/MariaDB environment (e.g., XAMPP, WAMP, or MAMP).

1. Place the project folder inside your server's web root (e.g., `htdocs/` for XAMPP).
2. Create a database named `lms` in phpMyAdmin (or via CLI) and import `lms.sql`.
3. Confirm your MySQL root user has no password, or update the connection details (see **Known Limitations** — currently hardcoded per-file).
4. Visit `http://localhost/Library-Management-System/index.php` for the user login, or `.../admin/index.php` for the admin login.

**Default seeded credentials** (from `lms.sql`):
- Admin: `admin@gmail.com` / `admin@123`
- User: `user@gmail.com` / `user@123`

---

## Database Schema

Five tables, defined in `lms.sql`:

- **`admins`** — id, name, email, password, mobile
- **`users`** — id, name, email, password, mobile, address
- **`books`** — book_id, book_name, author_id, cat_id, book_no, book_price
- **`authors`** — author_id, author_name
- **`category`** — cat_id, cat_name
- **`issued_books`** — s_no, book_no, book_name, book_author, student_id, status, issue_date

---

## Known Limitations

This was an early project and has significant issues worth being upfront about rather than glossing over:

- **SQL injection risk throughout** — nearly every query builds SQL by directly interpolating `$_POST`/`$_SESSION` values into a string (e.g. `"select * from users where email = '$_POST[email]'"`), with no parameterized queries or input escaping. This affects login, registration, and every admin CRUD operation.
- **Passwords are stored and compared in plaintext** — no hashing (`password_hash`/`password_verify`) is used anywhere; the seed data itself contains plaintext passwords.
- **Database credentials are hardcoded per-file** — every PHP file independently calls `mysqli_connect("localhost", "root", "")`, rather than using a single shared config file or environment variables.
- **No search feature** — despite being a natural fit for a library system, there's currently no book search/browse capability for users; the user dashboard only shows an issued-book count and link.
- **A broken redirect** — `register.php` redirects to `login.php` after signup, but that file doesn't exist (login lives at `index.php`), so new users hit a 404 immediately after registering.
- **No `.gitignore`** — vendored Bootstrap files (including source maps) are committed directly rather than pulled from a CDN or package manager.

---

## Future Enhancements

- Switch to prepared statements (`mysqli`/PDO with bound parameters) across every query to close the SQL injection exposure
- Hash passwords with `password_hash()` / verify with `password_verify()`
- Move DB credentials into a single shared config file (or `.env` + a config loader), not per-file
- Add book search/browse for users
- Fix the `register.php` → `login.php` redirect
- Add a `.gitignore` and drop vendored Bootstrap in favor of a CDN link or Composer/npm

---

## Learning Outcomes

This project was useful for learning:

- Core PHP without a framework — form handling, sessions, `mysqli` database access
- Basic relational schema design (books, authors, categories, issued-books, users)
- Separating admin and user access flows
- Where it fell short taught real lessons too — this project is a clear before/after reference point for what changed once I started building with parameterized queries, hashed passwords, and centralized config in later projects (e.g., `taskflow-api`).
