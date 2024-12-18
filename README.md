# Pars Ticket

Pars Ticket is a Laravel-based ticketing system designed to manage and track customer support requests efficiently. This project provides features to create, assign, and resolve tickets, ensuring a seamless support experience for users and administrators.

## Features

- **User Authentication**: Secure login and registration for users and admins.
- **Ticket Management**: Create, update, and track tickets.
- **Role-Based Access**: Different roles and permissions for users, support agents, and administrators.
- **Notifications**: Email notifications for ticket updates.
- **Dashboard**: Overview of ticket statuses and user activities.
- **Search and Filters**: Quickly find tickets based on various criteria.

## Requirements

- PHP >= 8.0
- Laravel >= 10.x
- Composer
- MySQL or any other supported database
- Node.js and npm (for frontend assets)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-repo/pars-ticket.git
   cd pars-ticket
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
   ```

3. Copy the `.env` file and configure your environment variables:
   ```bash
   cp .env.example .env
   ```

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

6. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

- Access the application at `http://localhost:8000`.
- Register as a user or log in as an admin (use seeded credentials if available).
- Create and manage tickets through the user-friendly interface.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for review.

## License

This project is open-source and available under the [MIT License](LICENSE).

---

### Contact
For any inquiries or support, please contact [pars.zamani.mohsen@gmail.com].

