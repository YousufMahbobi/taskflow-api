# TaskFlow API

TaskFlow is a backend-focused task management system built with Laravel.  
It provides a structured REST API for authentication, role-based access control using Spatie, task assignment, collaborators, and comments.

This repository contains **API only**. A separate Vue 3 + Pinia SPA frontend will be added later.

---

## Features
- Authentication using Laravel Sanctum
- Role-based authorization with Spatie Roles & Permissions (**Admin, Manager, Employee roles**)
- Tasks with:
    - Assigned user
    - Multiple collaborators with specific roles (e.g., backend, frontend)
    - Comments
- MySQL database with migrations
- Seeders + factories for testing
- Clean REST API structure
- Postman collection for endpoint testing (planned)

---

## Tech Stack

### Backend
- PHP 8.3
- Laravel 11
- MySQL
- Laravel Sanctum
- Spatie Roles & Permissions

### Frontend (planned)
- Vue 3
- Pinia
- Vite
- TailwindCSS

---

## Local Installation

### 1. Clone the project
```bash
git clone https://github.com/YousufMahbobi/taskflow-api.git
cd taskflow-api

```
### 2. Install backend dependencies
```bash 
composer install

```
### 3. Set up environment file
```bash 
cp .env.example .env
php artisan key:generate

```
### 4. Run database migrations
```bash 
php artisan migrate

```
### 5. Start the local development server
```bash 
php artisan serve 

```
### API will be available at:
```bash 
http://localhost:8000 

```

---


