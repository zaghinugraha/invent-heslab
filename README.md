# Inventory Management System

This project is an Inventory Management System for managing electronic components, particularly Arduino and related devices. It allows users to keep track of products, manage inventory levels, and handle rental transactions.

## Features

-   **Product Management**: Add, update, and delete products with detailed specifications.
-   **Inventory Tracking**: Monitor stock levels with quantity alerts.
-   **Rental System**: Handle rentals with before and after documentation.
-   **User Management**: Manage users and assign roles.
-   **Reporting**: Generate reports on inventory and rental status.

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/your-username/inventory-management-system.git
    Navigate to the project directory

    ```

2. **Navigate to the project directory**

    ```bash
    cd inventory-management-system

    ```

3. **Install dependencies**

    ```bash
    composer install
    npm install

    ```

4. **Copy the environment file**

    ```bash
    cp .env.example .env

    ```

5. **Generate application key**

    ```bash
    php artisan key:generate

    ```

6. **Configure database**

    Update the `.env` file with your database credentials.

7. **Run migrations and seeders**

    ```bash
    php artisan migrate --seed

    ```

8. **Start the development server**

    ```bash
    php artisan serve

    ```

## Usage

-   Access the application at http://localhost:8000.
-   Log in with the default credentials (if provided).
-   Manage products, users, and rentals through the dashboard.
