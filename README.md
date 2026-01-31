FRAUD DETECTOR
==============

Fraud Detector is a CLI-only application built with Symfony 7.4 and PHP 8.2+.

It was developed as part of a technical assessment and follows modern
Symfony best practices, with a focus on clean architecture, testing,
and maintainability.

--------------------------------------------------------------------

REQUIREMENTS
------------

- PHP >= 8.2 (tested with PHP 8.4)
- Composer >= 2.x
- Symfony CLI (recommended)
- Docker & Docker Compose (optional)

Recomended PHP extensions:
- openssl
- curl
- intl
- mbstring
- zip
- fileinfo

--------------------------------------------------------------------

INSTALLATION
------------

1. Clone the repository:

   `git clone https://github.com/reateguiDiego/fraud-detector.git`

   `cd fraud-detector`

2. Install PHP dependencies:

   `composer install`

No additional environment configuration is required.

--------------------------------------------------------------------

RUNNING THE APPLICATION
-----------------------

This is a CLI-only application.

The main functionality is executed through Symfony console commands.

   `php bin/console app:detect-fraud tests/Fixtures/2016-readings.xml`

   `php bin/console app:detect-fraud tests/Fixtures/2016-readings.csv`

Use the --help option to see available arguments and options:

   `php bin/console app:detect-fraud --help`

--------------------------------------------------------------------

DOCKER (OPTIONAL)
-----------------

Docker support is provided as a convenience for running the application
in an isolated environment. It is not required to run the project.

To build and run the container:

   `docker compose up --build`

Inside the container, commands can be executed using:

   `docker compose exec app php bin/console app:detect-fraud tests/Fixtures/2016-readings.csv`

   `docker compose exec app php bin/console app:detect-fraud tests/Fixtures/2016-readings.xml`

--------------------------------------------------------------------

TESTING
-------

This project uses Symfony PHPUnit Bridge.

Run the test suite with:

   `php bin/phpunit`

Tests are located in the tests/ directory.

--------------------------------------------------------------------

PROJECT STRUCTURE
-----------------

    -bin
    -config
    -src
        -Application
            -Service
                -DetectSuspiciousReadingsUseCase.php
        -Domain
            -Model
                -Reading.php
            -Port
                -ReadingsLoaderInterface.php
            -Service
                -FraudDetector.php
        -Infrastructure
            -Adapter
                -CsvReadingsAdapter.php
                -XmlReadingsAdapter.php
        -UserInterface
            -Command
                -DetectFraudCommand.php
    -tests
        -Domain
            -Service
                -FraudDetectorTest.php
        -Fixtures
            -2016-readings.csv
            -2016-readings.xml

--------------------------------------------------------------------

NOTES
-----

- Symfony 7.4 LTS is used for long-term stability.
- PHPUnit Bridge ensures a compatible PHPUnit version.
- The project is structured to be easily extensible and testable.