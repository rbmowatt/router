

## RbMowatt Router
An example PHP router with example and easy Docker setup.

## Directories
- `src` - hold the actual code applicable to router functionality
- `tests` - where the tests reside
- `docker` - the files to build our dockr container and add local code as volume
- `example` - implementation of simple example

## Usage
- Register new route < nesting based on `.` delimitation > 
	- `Router::resource('patients');`
		- will create a series of single level routes
			- `/patients`
			- `patients/1`
	- `Router::resource('patients.metrics');`
		- will create a series of nested routes
			- `/patients/1/metrics`
			- `/patients/1/metrics/2`
	- Each route will call a CRUD level method based on Request_Method
		- `GET` with no args = `get()`
		- `GET` with args = `index(id)`
		- `PUT/PATCH` = `update(id, body)`
		- `POST` = `create(body)`
		- `DELETE` = `delete(id)`
	- In the case of Nested Routes the arguments passed to each method will equal the number of variables in the url
		- Example `GET /patients/1/metrics/2`
			- results in `get(id_1, id_2)`
		- Example `POST /patients/1/metrics/`
			- results in `create(id_1, body)`
	- `POST and PATCH` always receive the body params array as the last parameter	
		- *Normally I'd send it as first param but am doing it this way to match the signatures request in the test*

## Docker Setup
- install docker-compose
- browse to /docker directory
- run `docker-compose up -d`
- connect `docker exec -it docker_app_1 /bin/bash`
- from `/var/www` in container
	- `composer install`
## Test In Postman
- install Postman
- edit file `postman_collection.json`
	- Make sure proper host is listed on line `327`
		- This may already be correct if using a *nix based system
- Import `postman_collection.json` into Postman
- Run Requests/Queries
## Run Unit Tests
- from root of repo
	- `./vendor/bin/phpunit`



