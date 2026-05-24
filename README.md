# Dance Studio Management System

A modern, fully functional web application for managing a dance studio's frontend presentation and backend administration. The admin panel has been refactored to follow a strict MVC (Model-View-Controller) architecture, ensuring scalability, security, and clean code principles.

## Architecture (MVC)

The administration panel uses a Front Controller pattern (admin.php) that routes requests to specific modules. The logic is separated into three main layers:

* Models (/models): Handle all database interactions using Prepared Statements to prevent SQL Injection.
  * InstructorModel.php, CursModel.php, EvenimentModel.php
* Controllers (/controllers): Process POST/GET requests, validate data server-side, and decide which view to load.
  * InstructorController.php, CursController.php, EvenimentController.php
* Views (/views): Contain purely HTML templates, separated into subdirectories for each module to follow the Single Responsibility Principle.
  * /instructori/ (index.php, adauga.php, editeaza.php)
  * /cursuri/ (index.php, adauga.php, editeaza.php)
  * /evenimente/ (index.php, adauga.php, editeaza.php)

## Security & Validation (Defense in Depth)

1. Authentication: Session-based login ($_SESSION['admin_logat']) protects the entire /admin.php route.
2. Server-Side Validation (PHP): Strict checks in controllers (regex for dates, empty checks, type casting to int for IDs).
3. Client-Side Validation (JavaScript): Modular validation logic (assets/js/validare_admin.js) intercepting form submissions to provide instant UI feedback and reduce server load.
4. Database Security: 100% usage of bind_param (Prepared Statements) for all INSERT, UPDATE, and DELETE operations.

## Developer Notes & Progress

* Refactoring Phase: Successfully migrated from a procedural monolith to an MVC structure.
* Forms Organization: Extracted Add/Edit forms into dedicated files, making the main index.php of each module a clean data table.
* JS Modularization: Implemented a "Divide et Impera" pattern in JavaScript. A central router checks the form type and delegates validation to specific functions (valideazaEvenimente, valideazaCursuri, valideazaInstructori).

## How to Run

1. Ensure you have a local server (XAMPP/WAMP) running Apache and MySQL.
2. Import the database schema (instructori, cursuri, evenimente tables).
3. Access localhost/dance-studio-website/ for the public frontend.
4. Access localhost/dance-studio-website/login.php to manage the studio.