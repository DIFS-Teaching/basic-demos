Authentication in PHP
=====================

(c) 2026 Radek Burget (burgetr@fit.vut.cz)

Simple authentication using hashed passwords stored in a database.

Application layers
------------------

The code is divided into layers (for demonstration; such a small application would not really need it):

| Layer | Files | Responsibility |
| --- | --- | --- |
| Presentation | `index.php`, `login.php`, `register.php`, … | reads the input, generates the HTML output |
| Business | `services.php` (`AccountService`) | application rules: data validation, password hashing and verification |
| Data | `data.php` (`AccountRepository`) | database connection, all SQL queries (PDO) |

Each layer only uses the layer directly below it: the pages never use SQL or PDO,
the data layer contains no application rules.
