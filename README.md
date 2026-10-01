# Midwifery Outcomes Management System (MOMS)

**Midwifery Outcomes Management System (MOMS)** is a web-based information management system developed to support the management of maternal, child, and family health information by Public Health Midwives (PHMs) and relevant supervisory healthcare staff.

The system provides a centralized platform for recording and managing family information, pregnancies, birth outcomes, children, growth measurements, vaccinations, supplementation, field visits, and related maternal and child health information.

The project was developed as an academic software engineering project using **Object-Oriented PHP**, **MySQL**, and an **R-based REST API** for WHO child growth standard Z-score calculations.

## Main Technologies

| Component            | Technology                        |
| -------------------- | --------------------------------- |
| Backend              | PHP 8                             |
| Database             | MySQL 8                           |
| Database access      | PHP PDO                           |
| API Service          | R                                 |
| REST API Framework   | Plumber                           |
| Growth calculations  | WHO Anthro R package              |
| Frontend             | HTML, CSS, JavaScript             |

## Key Features

* Family registration and family member management
* Maternal and pregnancy information management
* Pregnancy outcome and birth outcome recording
* Child registration and child profile management
* Child growth measurement recording
* WHO growth-standard Z-score calculation
* Child development observation management
* Vaccination record management
* Vaccination schedule management


## System Architecture

MOMS uses a PHP web application as the main application and a separate R REST API for child growth Z-score calculations.

```text
                         MOMS Web Application
                                  |
                                  |
                    Object-Oriented PHP Application
                                  |
              +-------------------+-------------------+
              |                                       |
              v                                       v
        MySQL Database                         Anthro API Client
          (PDO)                                      |
                                                    HTTP
                                                     |
                                                     v
                                            R / Plumber REST API
                                                     |
                                                     v
                                            WHO Anthro Package
                                                     |
                                                     v
                                          WHO Growth Z-Scores
```

The PHP application communicates with the Anthro API through HTTP requests. The R service receives the required child measurements, performs the growth-standard calculations using the WHO Anthro package, and returns the calculated results to the PHP application.

## Project Structure

The main parts of the repository are organized approximately as follows:

```text
Midwifery-Management-System/
│
├── app/
│   ├── Controllers/
│   ├── Core/
│   └── Modules/
│
├── config/
│
├── resources/
│   └── views/
│
├── routes/
│
├── seeders/
│   └── csv/
│
├── anthro-api/
│   └── R / Plumber API files
│
├── public/
│
├── docs/
│   └── Project documentation
│
└── README.md
```

The PHP application follows a modular object-oriented structure with controllers, services, repositories, and core application components.

Database communication is handled using **PHP Data Objects (PDO)**.

## Requirements

Before installing MOMS, make sure the following software is available:

* PHP 8
* MySQL
* A web server such as Apache
* R
* R package `plumber`
* R package `jsonlite`
* R package `anthro`
* Git

A local development environment such as **Laragon**, XAMPP, or another Apache/PHP/MySQL environment can be used.

## Installation

### 1. Clone the Repository

Clone the repository:

```bash
git clone https://github.com/ruwanswarna/Midwifery-Management-System.git
```

Move into the project directory:

```bash
cd Midwifery-Management-System
```

### 2. Configure the Web Server

Place the project in the web server's document directory.

For example, with Laragon:

```text
C:\laragon\www\Midwifery-Management-System
```

Configure the application URL according to the local development environment.

### 3. Create the MySQL Database

Create a MySQL database for the application.

For example:

```sql
CREATE DATABASE midwifery_outcomes_management
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Import the project's database schema into the newly created database.

The database configuration should then be updated according to the local MySQL installation.

### 4. Configure the PHP Application

Update the database and application configuration files with the appropriate local settings.

Typical settings include:

```text
Database host
Database name
Database username
Database password
Application URL
```

Do not commit passwords or other sensitive credentials to the public repository.

### 5. Configure the Anthro API

The Anthro API is located separately from the PHP application.

```text
anthro-api/
```

Install the required R packages.

For example, from R:

```r
install.packages("plumber")
install.packages("jsonlite")
install.packages("anthro")
```

The exact installation requirements may depend on the R version and operating system.

### 6. Start the Anthro API

Navigate to the Anthro API directory and start the Plumber API using the R API script provided in the repository.

For example:

```bash
Rscript api.R
```

The API should be running before using MOMS features that require WHO growth-standard calculations.

### 7. Configure the PHP Anthro API Client

The PHP application contains the client responsible for communicating with the R API.

Relevant configuration is located in:

```text
config/anthroApi.php
```

Set the API URL to match the address and port used by the local Plumber server.

The PHP application then communicates with the R service through HTTP requests.

## Database Seeding

The repository contains seeders and CSV data for development and testing.

Growth and child development data are provided under:

```text
seeders/
```

including:

```text
seeders/csv/growth_measurement.csv
seeders/csv/child_development_observation.csv
```

The available seeders can be used to populate the database with development and testing data.

Refer to the seeder documentation included in the repository before running the seed scripts.

## WHO Growth Z-Score Calculation

Child growth measurements are processed through the separate Anthro REST API.

The process is:

```text
Child Measurement
       |
       v
MOMS PHP Application
       |
       v
Anthro API Client
       |
       | HTTP / JSON
       v
R Plumber API
       |
       v
WHO Anthro Package
       |
       v
WHO Growth Standard Z-Scores
       |
       v
MOMS PHP Application
       |
       v
Database / Growth Records
```

The API is designed to keep the statistical growth-standard calculation separate from the main PHP application.


## Project Documentation

Additional project documentation can be found in the `docs/` directory.

The project report describes the system requirements, analysis, design, implementation, database design, architecture, testing, and other aspects of the project.

**Project Report:** [MOMS Project Report](docs/MOMS project - final report.pdf)

## Academic Project

MOMS was developed as an academic software engineering project. The repository contains the implementation of the proposed system together with supporting database, API, and development resources.


## Authors

Anusha Obadage
Janith Kumara
Thimash Kavinda

GitHub: [@ruwanswarna](https://github.com/ruwanswarna)

