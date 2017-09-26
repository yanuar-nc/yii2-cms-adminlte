# Yii2 AdminLTE CMS (Development Still)
This project just a simple design to created of CMS using by template AdminLTE2 and Yii2 Framework 

The template includes three tiers: common, assets, front end, back end, and console, each of which
is a separate Yii application. 

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

# DIRECTORY STRUCTURE

	media			
		/{model_name}   contains file uploads and the name depends on your model
    common
		components/		contains user definition functions
        config/			contains shared configurations
        mail/			contains view files for e-mails
        models/  		contains model classes used in both backend and frontend
        tests/   		contains tests for common classes
        console
        config/  		contains console configurations
        controllers/ 	contains console controllers (commands)
        migrations/  	contains database migrations
        models/  		contains console-specific model classes
        runtime/ 		contains files generated during runtime
    backend
		components/		contains user definition functions
        assets/  		contains application assets such as JavaScript and CSS
        config/  		contains backend configurations
        controllers/ 	contains Web controller classes
        models/  		contains backend-specific model classes
        runtime/ 		contains files generated during runtime
        tests/   		contains tests for backend application
        views/   		contains view files for the Web application
        web/ 			contains the entry script and Web resources
    frontend
		components/		contains user definition functions
        assets/  		contains application assets such as JavaScript and CSS
        config/  		contains frontend configurations
        controllers/ 	contains Web controller classes
        models/  		contains frontend-specific model classes
        runtime/ 		contains files generated during runtime
        tests/   		contains tests for frontend application
        views/   		contains view files for the Web application
        web/ 			contains the entry script and Web resources
        widgets/ 		contains frontend widgets
        vendor/  		contains dependent 3rd-party packages
    environments/		contains environment-based overrides


## Installation

### 1. Via Git Clone
if you have git in your machine, you are suggested to using `git clone`

    git clone https://github.com/yanuar-nc/yii2-cms-adminlte.git
### 2. Via Download
Maybe you have no GIT you also be able to download at this link [https://github.com/yanuar-nc/yii2-cms-adminlte/archive/master.zip](https://github.com/yanuar-nc/yii2-cms-adminlte/archive/master.zip "Download")

### 3. Run Initialization
`php init`

### 4. Run Migration
`php yii migrate/up`

### 5. Run your website
`http://localhost/yii2-cms-admintle`


### RULES
This template have several rules to create database. The important *fields* you have when you are create *table* make sure there is **row_status TINYINT(4)** field in every table. The field used to identify of row either active or disactive even deleted. 
> Don't forget it, if you don't want to see error appear.

## Configuration

Now we have arrive in configuration. The all configuration are in **environtments** folder. 
> Please check the folder for your reference.

For more pleasure, when you have configured of **environtments** you can try to mixing this configuration using `php init` on your command line. And then, *Yii Framework will guide you to configure*. **You must be try this!**

If you feel puzzle with command line you need to configure the files one by one **from** enviroments **to** folder backend, frontend and common.
The Configuration Structure it's look like this:

-----------------------
	common
		config/
			params-local.php    ===> PROJECT name
			main-local.php      ===> DATABASE configurations 
	backend
		config/
			params-local.php
			main-local.php
		web/
			index.php
	frontend
		config/
			params-local.php
			main-local.php
		web/
			index.php

## Time to running

You can access backend on [http://localhost/yii2-cms-adminlte/backend/web](http://localhost/yii2-cms-adminlte/backend/web) and you should be redirected to register page, caused you don't have user account.

## References

- [http://www.yiiframework.com/doc-2.0/index.html](http://www.yiiframework.com/doc-2.0/index.html "Yii2 Framework")
- [http://demos.krajee.com/widget-details/datepicker](http://demos.krajee.com/widget-details/datepicker)
- [https://github.com/kartik-v/yii2-widget-datetimepicker](https://github.com/kartik-v/yii2-widget-datetimepicker)
- [http://twig.sensiolabs.org/doc/2.x/](http://twig.sensiolabs.org/doc/2.x/)
- [https://github.com/yiisoft/yii2-twig/tree/master/docs/guide](https://github.com/yiisoft/yii2-twig/tree/master/docs/guide)
- [https://getcomposer.org/](https://getcomposer.org/)
- [https://almsaeedstudio.com/preview](https://almsaeedstudio.com/preview)

## See Other

- [MVC Structure](doc/MVC.md)
- [Database](doc/Database.md)
- [Example](doc/EXAMPLE.md)
