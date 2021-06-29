# README

The Goteo plugin for Wordpress is a plugin that lets you connect your woocommerce instance to a crowdfunding platform using [Goteo.org](https://goteo.org)

This plugin is meant to be used alongside a woocommerce installation. It allows you to login to a Goteo platform throught the API and be able to donate a % of your orders.

This plugin is still under development.

Docker
------

Run this application through docker using docker-compose for instance:

```
docker-compose -f docker-composer.production.yml up
```

Building Docker in production
-----------------------------

This application is available as a Docker image in: https://cloud.docker.com/u/goteo/repository/docker/goteo/wordpress-plugin

To build a new image we use the `Dockerfile` file. First be sure to be on the root of the repository, then run:

Build docker:

```
sudo docker build . -t goteo/wordpress-plugin:VERSION -f Dockerfile
```

To upload it to the Docker hub (permissions needed):

```
sudo docker login
sudo docker push goteo/wordpress-plugin:VERSION
sudo docker tag goteo/wordpress-plugin:VERSION goteo/wordpress-plugin:latest
sudo docker push goteo/wordpress-plugin:latest
```