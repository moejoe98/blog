# Blog Platform
The blog should allow users to create accounts, write blog posts, and comment on other users' posts. It should also have the following advanced functionality:
●	A tagging system that allows users to add tags to their blog posts and filter posts by tags.
●	A moderation system that allows blog administrators to approve, edit, or delete user comments.


# Installation
Clone the repository: git clone https://github.com/moejoe98/blog.git
Install dependencies: composer install
Create a new .env file: cp .env.example .env
Generate a new application key: php artisan key:generate
Configure your database connection in the .env file
Migrate the database: php artisan migrate
Start the local development server: php artisan serve
