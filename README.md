# Brutal PHP Framework
Just our own way brutal PHP framework. Maybe you like it or maybe not!

### Why Brutal PHP Framework?
This framework is for people that love coding PHP with vanilla PHP style, but want to take advantage of advanced templating mechanism (we use Twig) and advanced routing (we use Symfony routing component). For database connection you can use your own way, such as mysqli_connect or REST or anything you like.

### Usage
1. Clone it

```bash
git clone https://github.com/sonyarianto/brutal-php-framework.git
```

2. Go to the folder

```bash
cd brutal-php-framework
```

3. Install project dependencies, make sure you already install Composer, [how to install composer here](https://getcomposer.org/download/)

```bash
composer -vvv install 
```

4. Test with PHP development server

```bash
php -S 0.0.0.0:8000 -t public/
```

5. Open from browser

```bash
http://localhost:8000
```

6. That's it!

### What next?
- You can add some routes (on file `AppRoute.php`)
- Anything you want hehehe, but later we will give more samples to give you some ideas with this framework

### Some route samples
On file `AppRoute.php` we create some routes to give you some ideas.

- Route `/` is the home page (just using `echo`)
- Route `/about` is the about page (just using `echo`)
- Route `/phpinfo` is display PHP info page (using `phpinfo()` function)
- Route `/twigsample` is display data with Twig templating system (it's just simple static Twig HTML page)
- Route `/twigsamplewithdata` is display data with Twig and we send some data to Twig template (it shows dynamic content on Twig)
- Route `/detail/{slug}/{id}` is to show route with dynamic data plus combined with Twig templating system.

### Use case
You can use this framework to create any simple web. I will give sample about this later.
