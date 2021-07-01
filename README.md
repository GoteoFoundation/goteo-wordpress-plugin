# README

The Goteo plugin for Wordpress is a plugin that lets you connect your woocommerce instance to a crowdfunding platform using [Goteo.org](https://goteo.org)

This plugin is meant to be used alongside a woocommerce installation. It allows you to login to a Goteo platform throught the API and be able to donate a % of your orders.

This plugin is still under development.

What does this plugin do?
-------------------------

This plugin allows you to configure a connection to any goteo platform so that you can donate money you raise through your economic activity. It is meant to be used with a Matcher user inside Goteo. You can find more information [here](https://goteo.org/matchfunding-match)


Docker
------

Run this application through docker using docker-compose for instance:

```
docker-compose -f docker-composer.production.yml up
```

To use this plugin you need to have WooCommerce in your installation. To do this in the docker environment you can just enter and install it through the wordpress cli or inside the plugin section of the admin panel.


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

Future developments
-----------------------------

In the future we will like to develop some features for this plugin.

We want to be able to create products to be sold that represent projects inside the Goteo.org platform. This way, when costumers are interacting with this platform, they can add donation to projects they select to their order.

Right now we are developing some tweak to use the WooDonation plugin as a base to let the users select a donation, so that the owner of the shop can send that donation to goteo.