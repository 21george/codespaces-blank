# PHP REST API

This project is a simple REST API built with PHP that allows for CRUD operations on user data, including income calculation and tax refund processing based on the user's country.

## Project Structure

```
php-rest-api
├── src
│   ├── index.php              # Entry point of the application
│   ├── controllers
│   │   └── UserController.php # Handles user-related operations
│   ├── models
│   │   └── User.php           # Represents the user entity
│   ├── routes
│   │   └── api.php            # API routes definition
│   └── services
│       └── TaxService.php     # Tax calculation and refund processing
├── composer.json               # Composer configuration file
├── .htaccess                   # URL rewriting and server configuration
└── README.md                   # Project documentation
```

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/microsoft/vscode-remote-try-php.git
   cd php-rest-api
   ```

2. Install dependencies using Composer:
   ```
   composer install
   ```

3. Configure your web server to point to the `src` directory.

## API Endpoints

### User Operations

- **Create User**
  - `POST /api/users`
  - Request body: `{ "name": "John Doe", "income": 50000, "country": "US" }`

- **Read User**
  - `GET /api/users/{id}`

- **Update User**
  - `PUT /api/users/{id}`
  - Request body: `{ "name": "John Doe", "income": 60000, "country": "US" }`

- **Delete User**
  - `DELETE /api/users/{id}`

### Tax Calculation

- **Calculate Tax Refund**
  - `POST /api/tax/refund`
  - Request body: `{ "userId": 1 }`

## Usage

After setting up the project, you can use tools like Postman or cURL to interact with the API endpoints. Make sure to replace `{id}` with the actual user ID when making requests.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.