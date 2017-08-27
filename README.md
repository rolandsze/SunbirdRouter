About
-
A small PHP router and URL generator.

Usage
--
**Router** is the heart of the library. It provides access to other components such as **RouteCollection, Collection Matcher and URL Generator.**
```
$router = new SunbirdRouter\Router();
```

Add your **Routes** to the **RouteCollection**. *In this example, we are configuring URLs for a typical blog using filters and parameters.*
```
$router->addRoutes(array(
    // your-domain.com - default
    'default' => array('', 'defaultController', 'defaultAction'),

    // your-domain.com?blog
    // your-domain.com?blog/11
    'blog' => array('blog</:page>', 'blogController', 'indexAction',
        'filters' => array(
            ':page' => '(\d+)')
    ),

    // your-domain.com?blog/read/9
    'blogRead' => array('blog/read/:id', 'blogController', 'readAction',
        'filters' => array(
            ':id' => '(\d+)')
    ),

    // your-domain.com?blog/archive
    // your-domain.com?blog/archive/asc
    'blogArchive' => array('blog/archive</:order>', 'blogController', 'archiveAction',
        'filters' => array(
            ':order' => '(asc|desc)'),
        'parameters' => array(
            'order' => 'desc'
        )
    )
));
```

Now we can match the **current URL** against our **RouteCollection**.

```
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

try {
    $match = $router->match($path);
    
    // Found !!
} catch (MatchNotFoundException $exception) {
    // Not found :(
}
```

URL Generator
--
The **URL Generator** can generate URLs based on your defined **Routes** in the **RouteCollection**.
```
$router->generate('blog');
```
Will yield *your-domain.com?blog*

```
$router->generate('blog', array(':page' => '12'));
```
Will yield *your-domain.com?blog/12* where "12" is the passed parameter. (Notice the filter attached to this parameter above.)

```
$router->generate('blogRead', array(':id' => '3'));
```
Will yield *your-domain.com?blog/read/3* where "3" is the passed parameter again with numbers-only filter.

```
$router->generate('blogArchive', array(':order' => 'asc'));
```
Will yield *your-domain.com?blog/archive/asc* where "asc" is the passed parameter, can only be "asc" or "desc" as defined above.
