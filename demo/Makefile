.PHONY: all drupal api frontend

all: drupal api frontend

frontend:
	cd frontend && docker build -t ds2016/frontend:latest .

drupal:
	cd drupal && docker build -t ds2016/drupal:latest .

api:
	cd api && docker build -t ds2016/api:latest .
