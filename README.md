# Book shop
## Platform Description

Book shop is an API for retrieving books from one external API combine with the Local books database using Laravel for the backend and Vue for the frontend.

## Features
### API with Laravel
- Get books from external API (Ice And Fire API.)
- Create a book in the local database.
- Get all books from the local database. 
- Update a book in the local database.
- Delete a book in the ocal database.
- Get a particular book from the local database

### Frontend with Vue
- Display books from local database
- Delete a book in the local database
- Update a book in the local database.

### Get start now

- `git clone https://github.com/johnkeychishugi/book-shop-api.git`
- `cd in the project directory`
- `create a file called .env (you can copy the content of .env.example)`
- `composer install`
- `composer dumpautoload -o`
- `Provide the information of the database in .env => DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=<DATABASE NAME>DB_USERNAME=<DATABASE USERNAME> DB_PASSWORD=<DATABASE PASSWORD>`
- `php artisan key:generate`
- `php artisan config:clear`
- `php artisan config:cache`
- `php artisan migrate`
- `npm install`
- `npm install vue vue-router vue-axios --save`
- `npm run watch`
- `php artisan serve`

## API Endpoints Specifications

| Endpoint | Request | Status | Description |
| --- | --- | --- | --- |
| /api/external-books?name=:nameOfABook | GET | 200 OK | Get books from external API |
| /api/v1/books | POST | 201 OK| Create a book in the local database  |
| /api/v1/books | GET | 200 OK | Get all books from the local database  |
| /api/v1/books/:id | PATCH | 200 OK | Update a book in the local database |
| /api/v1/books/:id | DELETE | 200 OK | Delete a book in the ocal database |
| /api/v1/books/:id | GET | 200 OK | Get a particular book from the local database |

## Tools

Tools used for development of this API are;
- Laravel Framework: [Laravel](http://laravel.com).
- Vue Framework: [Vue](http://vuejs.org).
- Code Editor/IDE: [VSCode](https://code.visualstudio.com).
- API Testing environment: [Postman](https://www.getpostman.com).

## Key Contributor

- John Chishugi

## Acknowledgements

- Data Max group : https://www.datamaxgroup.ng

# License

MIT
