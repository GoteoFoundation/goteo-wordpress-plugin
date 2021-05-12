# README

Docker
------

Run this application through docker using docker-compose for instance:

```
docker-compose -f docker-composer.production.yml up
```

Building Docker in production
-----------------------------

This application is available as a Docker image in: https://cloud.docker.com/u/goteo/repository/docker/goteofoundation/wordpress-lazona

To build a new image we use the `Dockerfile` file. First be sure to be on the root of the repository, then run:

Build docker:

sudo docker build . -t goteo/wordpress-lazona:VERSION -f Dockerfile

To upload it to the Docker hub (permissions needed):

sudo docker login
sudo docker push goteo/wordpress-lazona:VERSION
sudo docker tag goteo/wordpress-lazona:VERSION goteo/wordpress-lazona:latest
sudo docker push goteo/wordpress-lazona:latest

