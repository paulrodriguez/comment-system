# Comment App System

## instructions

download project, cd into project folder root and run:

```
php -S localhost:8888 index.php
```

if a different port or local name is prefered when starting up the server,
change value of DOMAIN_URL inside configs/Globals.php

use the .htaccess.sample to set up with apache server for correct routing

please see configuration files configs/Db.php to set up database information
for creating a connection

two databases are supported: MySql and SqLite

## testing

project was tested on PHP 7.0.32 and MySql 5.6

unit test cases are only available for PHP models using phpunit.
please see under tests folder.
