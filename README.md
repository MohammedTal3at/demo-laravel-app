# Project Setup Guide

## Prerequisites
Before getting started, ensure you have the following installed:

- **Docker**: [Install Docker](https://docs.docker.com/get-docker/)
- **Docker Compose**: Comes with Docker Desktop on macOS and Windows.
- **Git**: [Install Git](https://git-scm.com/downloads)

---

## Setup Instructions

### 1. Clone the Repository
Clone the project repository to your local machine:

```bash
git clone https://github.com/yourusername/your-laravel-project.git
cd your-laravel-project
```

### 2. Copy `.env.example` to `.env`
The `.env` file contains environment-specific settings. Copy the example file:

```bash
cp .env.example .env
```

### 3. Configure Environment Variables
Edit the `.env` file and update the following values:

```env
APP_PORT=8056 # Your App port, http://localhost:{APP_PORT}
DB_DATABASE=testing
DB_USERNAME=admin
DB_PASSWORD=admin
FORWARD_DB_PORT=3302          # Change as needed 
FORWARD_PHPMYADMIN_PORT=8081  # Your PhpMyAdmin port

```

### 4. Build and Start the Containers
Use Docker to build and start the services:

```bash
docker-compose build
docker-compose up -d
```

This will start the following containers:

- **Laravel App**: Your Laravel application
- **MySQL**: Database service
- **PhpMyAdmin**: Web interface for database management

### 5. Install composer packages and generate needed keys
If not already generated, run:

```bash
./vendor/bind/sail composer install
./vendor/bin/sail  artisan key:generate
./vendor/bin/sail  artisan passport:install
 
```
Please make sure that the container name for the laravel is laravel.test, otherwise you you need to check the name using "docker ps"

### 6. Run Migrations and DB Seeders
To set up the database schema, execute:

```bash
./vendor/bin/sail artisan migrate --seed

```

### 7. Access the Application
- **Laravel App**: [http://localhost:80](http://localhost:80) (or the port (APP_PORT) specified in `.env`)
- **PhpMyAdmin**: [http://localhost:8081](http://localhost:8081) (or the configured port (FORWARD_PHPMYADMIN_PORT))

Login to PhpMyAdmin using your `.env` database credentials.


---

## Stopping the Containers
To stop all running containers:

```bash
docker-compose down
```

---

## Docker Compose Services
- **laravel.test** → Laravel application container
- **mysql** → MySQL database container
- **demo-phpmyadmin** → PhpMyAdmin for database management

---

## Contributing
Feel free to fork this repository and submit pull requests. Please follow the existing code style and include tests for any new features.

---

## API Documentation

### Authentication Endpoints

#### Register New User
```http
POST /api/register
Content-Type: application/json

{
    "first_name": "string",
    "last_name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
}

Response (201):
{
    "token": "access_token_string"
}
```

#### User Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "string",
    "password": "string"
}

Response (200):
{
    "token": "access_token_string"
}
```

#### User Logout
```http
POST /api/logout
Authorization: Bearer {token}

Response (200):
{
    "message": "Logged out successfully"
}
```

#### Get User Profile
```http
GET /api/profile
Authorization: Bearer {token}

Response (200):
{
    "status": "success",
    "data": {
        "id": 1,
        "first_name": "string",
        "last_name": "string",
        "email": "string"
    }
}
```

#### Update User Profile
```http
PUT /api/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "first_name": "string",
    "last_name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
}

Response (200):
{
    "status": "success",
    "message": "Profile updated successfully",
    "data": {
        "id": 1,
        "first_name": "string",
        "last_name": "string",
        "email": "string"
    }
}
```

### Project Endpoints

#### Create Project
```http
POST /api/projects
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "string",
    "status": "string",
    "attributes": {
        "attribute_id": "value"
    }
}

Response (201):
{
    "id": 1,
    "name": "string",
    "status": "string",
    "attribute_values": [
        {
            "id": 1,
            "attribute_id": 1,
            "value": "string"
        }
    ]
}
```

#### List All Projects
```http
GET /api/projects
Authorization: Bearer {token}

Optional Query Parameters:
filters[field]=value                 # Equal operator (default)
filters[field][operator]=value       # With specific operator

Available Operators:
- =     (Equal, default if not specified)
- >     (Greater than)
- <     (Less than)
- >=    (Greater than or equal)
- <=    (Less than or equal)
- like  (Contains)

Filterable Fields:
1. Regular Fields (automatically detected from projects table):
   - id
   - name
   - status
   - created_at
   - updated_at
   ... and any other column in the projects table

2. Custom Attributes (automatically detected from attributes table):
   - Any attribute defined in the system
   - Values are matched against the attribute_values table

Example Requests:
# Basic filtering
/api/projects?filters[name]=ProjectA
/api/projects?filters[status]=active

# Using operators
/api/projects?filters[name][like]=Project
/api/projects?filters[budget][>]=10000
/api/projects?filters[created_at][>=]=2024-01-01

# Combining multiple filters
/api/projects?filters[department]=IT&filters[status]=active
/api/projects?filters[budget][>]=10000&filters[name][like]=Project

# Filtering by custom attributes
/api/projects?filters[location]=London
/api/projects?filters[employee_count][>=]=50

Response (200):
{
    "data": [
        {
            "id": 1,
            "name": "ProjectA",
            "status": "active",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z",
            "attribute_values": [
                {
                    "id": 1,
                    "attribute_id": 1,
                    "value": "IT",
                    "attribute": {
                        "id": 1,
                        "name": "department",
                        "type": "text"
                    }
                },
                {
                    "id": 2,
                    "attribute_id": 2,
                    "value": "15000",
                    "attribute": {
                        "id": 2,
                        "name": "budget",
                        "type": "number"
                    }
                }
            ]
        }
    ]
}

Notes:
- The system automatically detects whether a field is a regular column or a custom attribute
- All operators are case-insensitive
- LIKE operator automatically adds wildcards around the value (%value%)
- Invalid operators default to equals (=)
- Non-existent fields or attributes are ignored
- Multiple filters are combined with AND logic
```

#### Get Single Project
```http
GET /api/projects/{id}
Authorization: Bearer {token}

Response (200):
{
    "id": 1,
    "name": "string",
    "status": "string",
    "attribute_values": [
        {
            "id": 1,
            "attribute_id": 1,
            "value": "string",
            "attribute": {
                "id": 1,
                "name": "string"
            }
        }
    ]
}
```

#### Update Project
```http
PUT /api/projects/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "string",
    "status": "string",
    "attributes": {
        "attribute_id": "value"
    }
}

Response (200):
{
    "id": 1,
    "name": "string",
    "status": "string",
    "attribute_values": [
        {
            "id": 1,
            "attribute_id": 1,
            "value": "string"
        }
    ]
}
```

#### Delete Project
```http
DELETE /api/projects/{id}
Authorization: Bearer {token}

Response (204)
```

#### Get Project Timesheets
```http
GET /api/projects/{id}/timesheets
Authorization: Bearer {token}

Response (200):
{
    "status": "success",
    "data": {
        "data": [
            {
                "id": 1,
                "task_name": "string",
                "date": "2024-01-01",
                "hours": 8,
                "user": {
                    "id": 1,
                    "first_name": "string",
                    "last_name": "string",
                    "email": "string"
                }
            }
        ],
        "current_page": 1,
        "per_page": 15,
        "total": 50
    }
}
```

#### Assign Users to Project
```http
POST /api/projects/{id}/users
Authorization: Bearer {token}
Content-Type: application/json

{
    "user_ids": [1, 2, 3]  // Array of user IDs to assign
}

Response (200):
{
    "status": "success",
    "message": "Users assigned successfully",
    "data": {
        "id": 1,
        "name": "string",
        "status": "string",
        "users": [
            {
                "id": 1,
                "first_name": "string",
                "last_name": "string",
                "email": "string",
                "pivot": {
                    "project_id": 1,
                    "user_id": 1
                }
            },
            {
                "id": 2,
                "first_name": "string",
                "last_name": "string",
                "email": "string",
                "pivot": {
                    "project_id": 1,
                    "user_id": 2
                }
            }
        ]
    }
}

Error Response (422):
{
    "message": "The given data was invalid.",
    "errors": {
        "user_ids": ["The user_ids field is required."],
        "user_ids.0": ["The selected user_ids.0 is invalid."]
    }
}
```

### Timesheet Endpoints

#### Log Time Entry
```http
POST /api/timesheets
Authorization: Bearer {token}
Content-Type: application/json

{
    "task_name": "string",
    "date": "2024-01-01",
    "hours": 8,
    "project_id": 1
}

Response (201):
{
    "status": "success",
    "message": "Time logged successfully",
    "data": {
        "id": 1,
        "task_name": "string",
        "date": "2024-01-01",
        "hours": 8,
        "user_id": 1,
        "project_id": 1,
        "project": {
            "id": 1,
            "name": "string",
            "status": "string"
        }
    }
}

Validation Rules:
- task_name: Required, string, max 255 characters
- date: Required, valid date format
- hours: Required, number between 0 and 24
- project_id: Required, must exist in projects table and user must be assigned to the project

Error Response (422):
{
    "message": "The given data was invalid.",
    "errors": {
        "project_id": [
            "The selected project id is invalid."
        ]
    }
}
```

#### Get User's Timesheets
```http
GET /api/my-timesheets
Authorization: Bearer {token}

Optional Query Parameters:
- date: Filter by specific date (YYYY-MM-DD)
- project_id: Filter by project ID

Response (200):
{
    "status": "success",
    "data": {
        "data": [
            {
                "id": 1,
                "task_name": "string",
                "date": "2024-01-01",
                "hours": 8,
                "project": {
                    "id": 1,
                    "name": "string",
                    "status": "string"
                }
            }
        ],
        "current_page": 1,
        "per_page": 15,
        "total": 50,
        "last_page": 4,
        "links": {
            "first": "http://localhost/api/my-timesheets?page=1",
            "last": "http://localhost/api/my-timesheets?page=4",
            "prev": null,
            "next": "http://localhost/api/my-timesheets?page=2"
        }
    }
}
```

### Attribute Endpoints

#### Create Attribute
```http
POST /api/attributes
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "string",
    "type": "text|number|date|boolean"
}

Response (201):
{
    "status": "success",
    "message": "Attribute created successfully",
    "data": {
        "id": 1,
        "name": "string",
        "type": "text",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}

Validation Rules:
- name: Required, string, max 255 characters, must be unique
- type: Required, must be one of: text, number, date, boolean
```

#### List All Attributes
```http
GET /api/attributes
Authorization: Bearer {token}

Response (200):
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "name": "string",
            "type": "text",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Get Single Attribute
```http
GET /api/attributes/{id}
Authorization: Bearer {token}

Response (200):
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "string",
        "type": "text",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Update Attribute
```http
PUT /api/attributes/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "string",
    "type": "text|number|date|boolean"
}

Response (200):
{
    "status": "success",
    "message": "Attribute updated successfully",
    "data": {
        "id": 1,
        "name": "string",
        "type": "text",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}

Validation Rules:
- name: Optional, string, max 255 characters, must be unique (except current)
- type: Optional, must be one of: text, number, date, boolean
```

#### Delete Attribute
```http
DELETE /api/attributes/{id}
Authorization: Bearer {token}

Response (204):
{
    "status": "success",
    "message": "Attribute deleted successfully"
}
```

