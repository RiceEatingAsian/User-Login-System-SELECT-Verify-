# User-Login-System-SELECT-Verify-
HTML form for user authentication (email, password). Processes login, uses prepared statements to fetch user data, password_verify() for secure authentication, and establishes PHP sessions.
## 🛠️ Setup Instructions

To run these experiments locally, you will need a server environment with PHP and MySQL (e.g., XAMPP, MAMP, or WAMP).

1.  **Clone the Repository:**
    ```bash
    git clone [YOUR_REPOSITORY_URL]
    cd [repository-name]
    ```

2.  **Database Configuration:**
    * Start your Apache and MySQL services.
    * Open your MySQL tool (phpMyAdmin, etc.).
    * Execute the SQL commands in the `setup.sql` file (located in Experiment 1) to create the `web_experiment_db` database and the initial `users` table.
    * **CRITICAL:** Update the database connection credentials (`$servername`, `$username`, `$password`, `$dbname`) in **ALL** PHP files to match your local environment.

3.  **Run Experiments:**
    * Place all PHP and HTML files in your local web server's root directory (e.g., `/htdocs` or `/www`).
    * Access the files via your browser (e.g., `http://localhost/index.php`).

---
### 3. User Login System (SELECT & Verify)

| File | Description |
| :--- | :--- |
| `login.html` | Login form for existing users. |
| `process_login.php` | Authenticates users by querying the database (prepared statement) and verifying the password hash with **`password_verify()`**. Manages basic session state. |
| `dashboard.php` | Protected page that requires an active **PHP session** to access. |
| `logout.php` | Securely destroys the user's session. |
