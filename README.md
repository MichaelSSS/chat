Simple 'chat' application
=======================================================
Application is based on Yii 2 + Angular.js. All communications between the client and server happen through AJAX.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      config/             contains application configurations
      controllers/        contains Web controller classes
      data/               contains SQLite database
      models/             contains model classes
      modules/api         contains API module
      modules/auth        contains Authentication module
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
      web/js              contains JavaScript files 
      web/views           contains HTML files


REQUIREMENTS
------------

* PHP >= 5.6.0.
* SQLite >= 3.6.19

INSTALLATION
------------

Run the following command in the project directory
```
php composer.phar install
```
Alternatively, copy `vendor` directory from [Yii 2 Basic Project Template](http://www.yiiframework.com/download/).

The web root of application is the `/web` folder.

USAGE
-----
There is no registration. Users are created automatically for each new session. To login as new user just open application in a new private browser window. Messages can be sent to any previously created user. All incoming messages for the current user are showm in a single table. Messages are updated automatically every 1 minute or manually by clicking Refresh button.
