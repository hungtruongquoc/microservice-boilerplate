## Prerequisites:

- `Docker`
- `Docker-compose`

## Technologies
- `Lumem -v 6.x` : It is the perfect solution for building Laravel based micro-services and blazing fast APIs. It is
 one of the fastest micro-frameworks available. https://lumen.laravel.com/

- `Laravel -v 6.x` : Laravel is a web application framework with expressive, elegant syntax.
https://laravel.com/

- `Nginx`: It is a web-server that accelerates content and application delivery, improves security, facilitates availability and scalability for the busiest web sites on the Internet.
https://www.nginx.com/

- We will be using `php-7.4` alongside with the `fpm` procces manager.
- We will be using `mysql 8.0` and take advantage of it’s blazing speed.

## Solution Architecture

The file docker-compose.yml describes details about services included in this project. 

- The webserver is an Nginx used as a proxy to navigate request to other services (curator, dispenser, jobs).

- The curator is a laravel app with a front end. This service is irrelevant to this project since we only need web api.

- The dispenser service provides REST API for creating, get job status, get next job, and statistics information
 (still in progress)
 
 - The job service mainly used for executing the command of a job and updating the statistics of run time using Laravel
  Event. I set up the event and the database models. However, I am debugging why the run time of `stats` table is not
   updated when a job completed
   
- Job information is stored in a MySQL 8.0 database using db server.

- A redis service is configured. I plan to use it for dispatching messages from the dispenser and PHP worker can pick
 up messages to send HTTP request to the job service for processing.

## Code Base Structure

3 services reside in 3 folders under the `apps` directory. 

- For `dispenser` service: I created `JobController` under folder `app/Http/Controllers` and added new routes (POST
, GET) to `routes/web.php`.
- For `jobs` service:I created `ProcessorController` under folder `app/Http/Controllers` and added a new PUT route to
 `routes/web.php` 
- I created a package folder containing 2 Eloquent models: `JobModel` and `JobStatModel` to be shared among these
 services. I tried to set up the package so that I can import them locally into the services. However, the Dockerfile
  of each service does not allow any kind of access outside the folder of each service. Therefore, you can see there
   2 `packages` folders inside code base of services.
- The `docker` folder contains domain name configuration of each service in `nginx/sites` if you want to run the
 whole stack locally. On Mac OS, you would need those names in your `/etc/hosts` files and point them to `127.0.0.1`.
 
## Questions

Please contact Hung Truong (hungtruongquoc@gmail.com) for any question and concerned

## References

Here is the Medium post related to this project:
- https://medium.com/@shadysmaoui/micro-services-with-lumen-laravel-nginx-mysql-70b3554e8068. In this article, I will
 provide a step-by-step demonstration of the process of dockerizing your micro-services
 project with Lumen and Laravel alongside with nginx as a web server and mysql. This is the first part of a three article series.
This initial part will allow us to set up the foundation of our project, dockerize its main components and to establish the basics in order to make a fluid communication between all components.

- [Enable Eloquent](https://medium.com/@petehouston/enable-eloquent-orm-in-laravel-lumen-micro-framework-7a4f2fbcaf5d)

## License
This repository was forked from 
ShadySmaoui©2020 licensed under the [MIT license](https://opensource.org/licenses/MIT).
