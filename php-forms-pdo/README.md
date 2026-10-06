PHP Forms and PDO Demo
======================

(c) 2026 Radek Burget (burgetr@fit.vut.cz)

Application layers
------------------

The code is divided into layers (for demonstration; such a small application would not really need it):

| Layer | Files | Responsibility |
| --- | --- | --- |
| Presentation | `index.php`, `person_*.php` | reads the input, generates the HTML output |
| Business | `services.php` (`PeopleService`) | application rules: data validation |
| Data | `data.php` (`PeopleRepository`) | database connection, all SQL queries (PDO) |

Each layer only uses the layer directly below it: the pages never use SQL or PDO,
the data layer contains no application rules.
