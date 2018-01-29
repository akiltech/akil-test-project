symfony-project
===============

A Symfony project created on January 28, 2018, 1:07 pm.

Symfony Test Project
=====================

Evaluation for Web App Developer with Symfony.

Prerequisites
-------------

* [Git](http://git-scm.com/)
* [npm](https://www.npmjs.org/)

Installation
------------

Clone the project

```bash
git clone https://github.com/akiltech/akil-test-project.git && cd akil-test-project/
```

Install the dependencies

```bash
cd symfony-project
composer install
```

```bash
cd client
npm install
```

Start the backend server

```bash
cd symfony-project
php bin/console server:start
```

Start the frontend server

```bash
cd client
gulp
```

Frontend App should run on http://localhost:9000
Backend runs on http://localhost:8000

REST API for users
http://localhost:3000/api/users

Project description
-------------------

akil-test-project is a simple user management system with a single page application.
The goal is to show a list with all users in the system.
By clicking on the user we show the detail information of the user.
We can add/edit/remove a user.



