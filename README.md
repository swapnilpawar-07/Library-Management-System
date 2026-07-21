# Library Management System

A PHP + MySQL web application for managing library operations — book inventory, categories, authors, and issued/returned books — with separate admin and user portals.

---

## Features

**Admin panel**
- Add, edit, and delete books, authors, and categories
- Issue books to registered users and track issued/returned status
- Manage admin profile and password

**User panel**
- Register and log in
- View and edit personal profile, change password
- View issued books

---

## Tech Stack

| Category   | Technology                        |
|------------|--------------------------------------|
| Frontend   | HTML, CSS, Bootstrap 4.4.1, jQuery    |
| Backend    | PHP (procedural, `mysqli` with prepared statements) |
| Database   | MySQL / MariaDB                        |
| Security   | Bcrypt password hashing, parameterized queries, output escaping |

---

## Project Structure

```
Library-Management-System/
├── config.php              # Centralized database connection (env-var configurable)
├── index.php                 # User login
├── signup.php                  # User registration form
├── register.php                 # Processes registration
├── user_dashboard.php             # User home: issued book count
├── view_issued_book.php            # User's issued books
├── view_profile.php / edit_profile.php / change_password.php
├── admin/
│   ├── index.php                    # Admin login
│   ├── admin_dashboard.php           # Admin home
│   ├── manage_book.php / add_book.php / edit_book.php / delete_book.php
│   ├── manage_author.php / add_author.php / edit_author.php / delete_author.php
│   ├── manage_cat.php / add_cat.php / edit_cat.php / delete_cat.php
│   ├── issue_book.php                # Issue a book to a user
│   ├── view_issued_book.php           # All issued books
│   └── functions.php                   # Dashboard summary counts
├── bootstrap-4.4.1/                       # Vendored Bootstrap (CSS/JS)
├── lms.sql                                  # Database schema + seed data
└── images/                                    # UI assets
```

---

## Setup

Requires PHP 8+ and MySQL/MariaDB.

1. Clone the repo and place it in your server's web root (e.g., `htdocs/` for XAMPP), or run it directly with PHP's built-in server: `php -S localhost:8000`.
2. Create a database named `lms` and import `lms.sql`.
3. `config.php` connects as `root` with no password on `localhost` by default (standard local XAMPP/WAMP setup). To use different credentials, set the `DB_HOST`, `DB_USER`, `DB_PASS`, and `DB_NAME` environment variables before starting PHP.
4. Visit `http://localhost:8000/index.php` for the user login, or `.../admin/index.php` for the admin login.

**Seeded credentials** (from `lms.sql`):
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

## Security

- Passwords are hashed with `password_hash()` (bcrypt) and verified with `password_verify()` — never stored or compared in plaintext
- All database queries use parameterized `mysqli` prepared statements
- User-supplied values are escaped with `htmlspecialchars()` before being rendered
- Database credentials are centralized in `config.php` and overridable via environment variables rather than hardcoded per-file

---

## Known Limitations

- `mobile` columns are `int(10)`, which can overflow for some real phone numbers — better suited to `varchar`
- No CSRF protection on forms
- Delete actions are plain `GET` links rather than confirmed `POST` requests
- No book search/browse feature for users
- No login rate limiting

---

## Future Enhancements

- Change `mobile` columns to `varchar`
- Add CSRF tokens to state-changing forms
- Convert delete actions to confirmed `POST` requests
- Add book search/browse for users
- Add login rate limiting
- Extract the repeated navigation markup into a shared include

---

## Learning Outcomes

This project reinforced:

- Core PHP without a framework — form handling, sessions, `mysqli` database access
- Secure authentication practices — password hashing and parameterized queries
- Relational schema design (books, authors, categories, issued-books, users)
- Separating admin and user access flows
