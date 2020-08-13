# # install

install lib
```console
composer require php-pdo-connector
```

---

### # config

```php
define('DB_HOST', 'db_host'); // localhost or 127.0.0.1
define('DB_USER', 'db_user'); // test
define('DB_PASS', 'db_pass'); // null or '' for local develop
define('DB_NAME', 'table_name'); // your db table name
```

### # using on project

```php
use Ashkanfekri\dodo\PDOConnector;
// create new object from this class
$db = new PDOConnector();
```
--- 

#### # build and run a query 

 ##### # set a query
```php

// select first row form table
$db->query("SELECT * FROM users")->first();

// select all row form table
$db->query("SELECT * FROM users")->all();
// select all rows with bind value
$db->query('SELECT * FROM users WHERE id = :id')
    ->bind(':id', 2)
    ->all();
```


##### # execute a query
```php
// execute a query
  $db->query('INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `age`)VALUES(NULL, :firstname, :lastname, :email, :age)')
    ->bind(":firstname", "ashkan")
    ->bind(":lastname", 'fekri')
    ->bind(':email', 'ashkanfekridev@gmail.com')
    ->bind(':age', 20)
    ->execute();
```

##### # count
```php

// get the row count of result
$db->query("SELECT * FROM users")->count();
```









