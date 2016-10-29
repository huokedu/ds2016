Demo
====

## Requirements

* Docker (Im using Docker for Mac)
* Docker Compose

## Init

* Clear existing instances with `docker-compose rm -f`
* Start a fresh demo with `docker-compose up`

## Frontend

* Go to http://127.0.0.1

## API

* Go to http://127.0.0.1:8080/blogs
* Seed data with script in `api/seed.sh`

## Drupal

* Go to http://127.0.0.1:8081
* Install with credentials:
 * Database: drupal
 * User: root
 * Pass: drupal
 * Host: mysql
* Enable "blog" module
* Go to http://127.0.0.1:8081/admin/content/blog
