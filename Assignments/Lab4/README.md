# Posts Web App

### Setup

For this example application, a database must be created and the connection info added to `src/Repositories/Repository.php`.
Note that for a real application we would not be putting credentials in source code. Instead, environment variables would be used.

Creating the database and schema can be done by running the commands in `database/schema.sql`.

### Running the application
You can run the application using the built-in PHP web server, specifying the document root as the `src` directory:

```
php -S localhost:7777 -t src/Views
```

Alternatively, you can run it using Apache or Nginx.

### SQL Injection Protection

This application is designed with security in mind to prevent SQL injection attacks. 

- **Parameterized Queries:** Always use parameterized queries when interacting with the database to prevent SQL injection attacks.
  
- **User Input Validation:** Validate and sanitize user inputs before using them in database queries or any other critical operations.

- **Environment Variables:** Avoid hard-coding sensitive information such as database credentials. Use environment variables or a secure configuration file to store such information.

### Dropping database:

DROP DATABASE posts_web_app;
