# rahisi

> php Rahisi Framework

-php framework eamed to siplify the process of creating customer projects (**Systems**)

## Get Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### installation

-run

```
composer create-project rahisi/rahisi project-name
```

## Running the tests

-Once you've completed these steps, you'll be good to go.

## 1.Routes

-a "route" refers to the mapping of a URL (Uniform Resource Locator) to a specific function or handler that will be responsible for generating a response to that URL.

For example, let's say you're building a web application that has a homepage, a blog, and a contact page. You might define three different routes:

    "/" (the root URL) maps to a function that generates the homepage.
    "/blog" maps to a function that generates the blog page.
    "/contact" maps to a function that generates the contact page.

When a user navigates to your website and enters a URL, your web application will look at the URL and determine which function to call based on the defined routes. The function then generates a response (HTML, JSON, etc.) that is sent back to the user's browser.

exaples
```
  Route::Get("routeName","controller");
```
-Route with Anonymous functions

```php
<?php

  use Rahisi\Routes\Route;

  Route::Get("", function ()
  {
    echo "welcome" ;
  });

```
-Route whith class(controller)
```php
<?php

  
use App\Controllers\testController;
use Rahisi\Routes\Route;

Route::Get("", [testController::class,"index"]);

```
## 2.Views
-A "view" refers to the part of an application that is responsible for displaying information to the user. 
**in php Rahishi**
views/Html files are located at ```resources\views\```

### calling view
-the process is done when you need to display your html page
>there we use ``view()`` function which find your view from resources\views\
-example
```
View('fileLocation',array data to the view)
```

```php
<?php

  use Rahisi\Routes\Route;

  Route::Get("", function ()
  {
    $userData = ["name"=>"john Doe","Age"=>30];
    view("index",["userData"=>$userData]); //view function will add .php it self
  });

```

### accessing Data sent from view

```html
// index.php
<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
  <h3>User Data</h3>
  <p>Name <?php echo $userData['name'] ?></p>
  <p>Age <?php echo $userData['Age'] ?></p>
</body>
</html>
```