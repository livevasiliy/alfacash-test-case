# Alfacash Test case 

## Getting started 

Install [Docker](https://www.docker.com/products/docker-desktop/) now low 20.x version on your local machine. Use next command to install and run local database.
Run all required migrations and run local web server.

```shell
make run
```
Application can be available on [http://localhost:8000](http://localhost:8000)

For get to access inside the application use the following command:
```shell
make php
```

## Override default configurations

If you need get access to the database you will create in root new file `docker-compose.override.yml` below example this file.

```yml
version: '3.9'

services:
  database:
    ports: 
        - published: 3306
          target: 3306
          protocol: tcp        
```

## Configuration parser

If you want to extend list for parsing you can the put in the configuration file
``config/parser.php`` in array `keywords`, by default already filling next values
```
'Bitcoin', 'Litecoin', 'Ripple', 'Dash', 'Ethereum'
```
