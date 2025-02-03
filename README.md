# PHP-based Dashboard Application with Docker Support

This project is a comprehensive PHP-based dashboard application with Docker support, designed for managing clients, inventory, and sales.

The application provides a robust set of features for business management, including client management, inventory tracking, sales processing, and appointment scheduling. It utilizes a modern tech stack with PHP 8.2, Apache, MariaDB, and various front-end technologies to deliver a responsive and user-friendly interface.

## Repository Structure

```
.
├── composer.json
├── Docker
│   └── Dockerfile
├── docker-compose.yml
├── index.php
├── public
│   ├── scripts
│   │   └── dashboard
│   └── styles
│       ├── dashboard
│       └── login.css
├── README.md
├── src
│   ├── Auth
│   ├── Config
│   ├── Controllers
│   ├── Models
│   └── Views
└── vendor
```

Key Files:
- `index.php`: The main entry point of the application
- `docker-compose.yml`: Defines the multi-container Docker environment
- `Docker/Dockerfile`: Contains instructions for building the PHP-Apache container
- `composer.json`: Manages PHP dependencies
- `src/`: Contains the core application logic, including controllers, models, and views
- `public/`: Stores public assets like JavaScript and CSS files

## Usage Instructions

### Installation

Prerequisites:
- Docker (version 20.10 or later)
- Docker Compose (version 1.29 or later)

Steps:
1. Clone the repository:
   ```
   git clone <repository-url>
   cd <project-directory>
   ```

2. Build and start the Docker containers:
   ```
   docker-compose up -d --build
   ```

3. Install PHP dependencies:
   ```
   docker-compose exec web composer install
   ```

### Getting Started

1. Access the application by navigating to `http://localhost:8008` in your web browser.

2. Log in using your credentials (refer to the application documentation for default login information).

3. You will be presented with the main dashboard, from which you can access various modules:
   - Clients
   - Inventory
   - Sales
   - Appointments

### Configuration

- Database configuration can be modified in the `docker-compose.yml` file under the `db` service.
- PHP configuration can be adjusted in the `Docker/Dockerfile` or by modifying PHP ini settings.

### Common Use Cases

1. Managing Clients:
   - Navigate to the Clients section
   - Use the search functionality to find specific clients
   - Add new clients or edit existing ones using the provided forms

2. Inventory Management:
   - Access the Inventory section
   - Add new products, update stock levels, or modify product details
   - Use the low stock highlighting feature to identify products that need restocking

3. Processing Sales:
   - Go to the Sales section
   - Select a client, add products to the order, and specify quantities
   - The system will automatically calculate the total and update stock levels

4. Scheduling Appointments:
   - Use the Scheduling section to manage appointments
   - Add, edit, or cancel appointments as needed

### Testing & Quality

To run tests (if implemented):
```
docker-compose exec web vendor/bin/phpunit
```

### Troubleshooting

1. Issue: Unable to connect to the database
   - Ensure the MariaDB container is running: `docker-compose ps`
   - Check the database credentials in `docker-compose.yml`
   - Verify network connectivity between containers

2. Issue: PHP extensions not loading
   - Review the `Docker/Dockerfile` to ensure all required extensions are installed
   - Rebuild the container: `docker-compose up -d --build web`

3. Issue: Permission denied errors
   - Check file permissions in the project directory
   - Ensure the web server has write access to necessary directories (e.g., log files, cache)

For more detailed debugging:
- Enable error logging in PHP by modifying the `php.ini` file
- Check Apache logs: `docker-compose exec web cat /var/log/apache2/error.log`

## Data Flow

The application follows a typical MVC (Model-View-Controller) architecture for handling data flow. Here's an overview of how data flows through the system:

1. User Request: The user interacts with the application through the browser, sending HTTP requests to the server.

2. Routing: The Apache web server routes the request to the appropriate PHP script, typically starting with `index.php`.

3. Controller: The relevant controller processes the request, interacting with models as needed.

4. Model: Models handle data logic, interacting with the MariaDB database to fetch or update information.

5. View: The controller passes data to the appropriate view, which renders the HTML response.

6. Response: The server sends the generated HTML back to the user's browser.

```
[User] <-> [Browser] <-> [Apache] <-> [PHP (Controllers)] <-> [Models] <-> [MariaDB]
                                            |
                                            v
                                         [Views]
```

Key technical considerations:
- AJAX requests are used for dynamic updates without page reloads
- Client-side JavaScript handles form submissions and real-time updates
- The MariaDB database stores all persistent data
- PHP sessions manage user authentication and state

## Infrastructure

The application is containerized using Docker, with the following key resources:

- Web Service:
  - Type: Docker container
  - Base Image: php:8.2-apache
  - Custom configuration:
    - PHP extensions: mysqli, pdo, pdo_mysql, gd
    - Apache modules: rewrite, ssl
    - Additional tools: git, curl, nano, composer

- Database Service:
  - Type: Docker container
  - Image: mariadb:10.5
  - Environment variables:
    - MARIADB_DATABASE: lldb
    - MARIADB_USER: user_app
    - MARIADB_PASSWORD: password
    - MARIADB_ROOT_PASSWORD: password

- Volume:
  - Name: volume_register
  - Purpose: Persistent storage for MariaDB data

The infrastructure is defined and managed through the `docker-compose.yml` file, ensuring consistency across development and production environments.