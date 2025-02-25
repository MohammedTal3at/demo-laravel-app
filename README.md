
## Prerequisites ##
Before getting started, make sure you have the following installed on your machine:

Docker: Install Docker
Docker Compose: Comes with Docker Desktop on macOS and Windows.
Git: Install Git
Setup Instructions
1. Clone the Repository
   Clone the project repository to your local machine:

bash
Copy
Edit
git clone https://github.com/yourusername/your-laravel-project.git
cd your-laravel-project
2. Copy .env.example to .env
   The .env file contains environment-specific settings for the Laravel application. Copy the example to create a new .env file:

bash
Copy
Edit
cp .env.example .env
3. Configure Environment Variables
   Edit the .env file and configure the following variables:

DB_DATABASE: The name of the database to use (e.g., testing).
DB_USERNAME: The MySQL username.
DB_PASSWORD: The MySQL password.
APP_KEY: Laravel’s app key. You can generate it by running php artisan key:generate.
4. Build and Start the Containers
   You can use Docker to build and start the containers. This is the preferred method for setting up the environment.

Run the following commands:

bash
Copy
Edit
docker-compose build
docker-compose up -d
This will start the following containers:

Laravel App: Your Laravel application.
MySQL: The MySQL database for the application.
PhpMyAdmin: A web interface for managing your MySQL database.
5. Generate the Application Key
   If you haven’t generated the application key yet, you can do so by running:

bash
Copy
Edit
docker-compose exec laravel.test php artisan key:generate
6. Run Migrations
   To set up the database schema, run the migrations:

bash
Copy
Edit
docker-compose exec laravel.test php artisan migrate
7. Access the Application
   Laravel Application: Visit http://localhost:80 in your browser (or the port specified in your .env file).
   PhpMyAdmin: Access PhpMyAdmin at http://localhost:8081 (or the port specified in your .env file).
   Log in to PhpMyAdmin using the database username and password from the .env file.

8. (Optional) Running Tests
   To run the tests for the application, use:

bash
Copy
Edit
docker-compose exec laravel.test php artisan test
9. Stopping the Containers
   To stop the running containers, use:

bash
Copy
Edit
docker-compose down
Notes
If you encounter any issues related to permissions, try running the following commands to reset permissions for Docker volumes:
bash
Copy
Edit
sudo chown -R $USER:$USER .
Ensure that your .env settings match the configuration in docker-compose.yml for MySQL.
Docker Compose Services
laravel.test: The main Laravel application container.
mysql: The MySQL container for the application.
demo-phpmyadmin: PhpMyAdmin for database management.
Troubleshooting
1. Database Connection Issues
   If you're facing connection issues (e.g., SQLSTATE[HY000] [2002] Connection refused), ensure that the .env file has the correct DB_HOST value pointing to mysql (the service name).

env
Copy
Edit
DB_HOST=mysql
2. Missing Sessions Table
   If the sessions table is missing in the database, you can run the following to create it:

bash
Copy
Edit
docker-compose exec laravel.test php artisan session:table
docker-compose exec laravel.test php artisan migrate
Contributing
Feel free to fork this repository and contribute by submitting pull requests. Please follow the existing code style and write tests for any new features.

License
This project is licensed under the MIT License.
