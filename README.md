# PostsApi
Simple PHP API to Retrieve Posts
This is a simple experimental api I developed to get a better understanding in developing api's using PHP.

**_NOTE:_** The api has a dbseed.php file that can be ran to create the table and add temporary records for testing.

# Endpoints

| HTTP Verb | Endpoint          | Description              |
|-----------|-------------------|--------------------------|
| GET       | /posts            | Get all posts            |
| GET       | /posts/:id        | Get a single post by id  |
| POST      | /posts            | Create a post            |
| PUT       | /posts/:id        | Update a post            |
| DELETE    | /posts/:id        | Delete a post            |

## Running the api locally
You can run the api using MAMP or any other local server
``` bash
# run a local php server
php -S 127.0.0.1:8000 -t public
```

# Technologies Used:
* PHP
* PHP PDO
* MySQL
