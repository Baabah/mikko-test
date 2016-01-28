Mikko Test
============
This project is written to demonstrate coding skills as part of a job application.
The project can be used to calculate bonus and salary payment dates based on the current date and business logic.

## Requirements
* Php 5.6 or higher
* Globally installed composer

## Setup Development
1. Git clone https://github.com/Baabah/mikko-test.git
2. Run composer update
3. Make sure write permissions have been set for the **output/** folder

## Frameworks & libraries
* Silex, a micro framework based on Symfony2 components
* ConsoleServiceProvider, a library for providing a Symfony console in a Silex project

## Usage
This application can be utilized by entering **app\console payroll:dates \<output filename\>** on the commandline

## Testing
To execute tests run **composer\bin\phpunit**