# Baking with Vue.js
An example application to accompany my 'Baking with Vue.js' talk given at Cakefest Japan 2019.

You can find my slides [on slideshare.net](http://slideshare.net).

## Talk abstract
The development landscape is changing, and as always Javascript is the front runner. In my job we produce lots of visual tables of data, which all need sorting and filtering. This talk will cover how we developed a new front-end dynamic table component for our CakePHP websites using Vue.js and CakePHP.

How do you integrate Vue.js into your CakePHP application? What can Vue.js do for your CakePHP application? Hopefully after this talk, you'll have a better understanding of the answers to those questions. We'll be looking at an internal CakePHP web service and how to interact with Vue.js to use that new web service.

## Requirements
* Web server
* PHP
* Composer
* MySQL

For development
* Node.js
* Yarn or NPM

For other dependancies, see the [composer.json](https://github.com/davidyell/cakefest-japan-2019/blob/master/composer.json) and [package.json](https://github.com/davidyell/cakefest-japan-2019/blob/master/package.json).

## Setup
1. Check out the repository
2. Setup a database
3. Configure the db in `/config/app.php` with your db credentials
4. Run `composer install`
5. Run `bin/cake migrations migrate` to setup the tables and data

The Vue.js application is pre-compiled in the repo in `/webroot/app.js`

## Development
In order to build the Vue.js application you will need to [install Node.js](https://nodejs.org/en/download/) and [install Yarn](https://yarnpkg.com/en/docs/install).

Building the Vue.js can be done with `yarn run build-dev`

## License
MIT see [license](LICENSE.md)
