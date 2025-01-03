# Contact Manager Project

This project is a simple contact manager application built using PHP, HTML, CSS, and JavaScript.  It allows users to add, view, update, and delete contact information.

## Project Structure

```
├── config/
│   ├── database.php
│   └── schema/
│       └── contact_manager.sql
├── dashboard/
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css
│   │   └── js/
│   │       └── script.js
│   └── index.html
└── api.php
```

## Database Schema

The `contacts` table stores contact information.  The table structure is defined in `config/schema/contact_manager.sql`.

## API Endpoints

The `api.php` file exposes the following API endpoints:

* **GET /api.php:** Retrieves all contacts or a single contact by ID.
* **POST /api.php:** Creates a new contact.
* **PUT /api.php:** Updates an existing contact.
* **DELETE /api.php:** Deletes a contact by ID.

## Front-End Functionality

The `dashboard/index.html` file provides the user interface for adding, viewing, updating, and deleting contacts.  The front-end interacts with the API endpoints to manage data.

## Usage

1.  **Database Setup:** Create the `contacts` table in your MySQL database using the SQL script in `config/schema/contact_manager.sql`.
2.  **Configure Database Connection:** Update the database credentials in `config/database.php` to match your database settings.
3.  **Run the Application:** Open `dashboard/index.html` in a web browser to access the contact manager application.

## Further Development

*   Implement more robust error handling and validation in the API.
*   Add more features, such as searching and filtering contacts.
*   Implement user authentication and authorization.
*   Improve the user interface design.

## Contact Information

For any questions or issues, please contact <a href="https://github.com/TitidTerbang">Titid Terbang</a>.
