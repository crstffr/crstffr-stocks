<?php

// Aliasing ChromePhp with a shorter, more javascript
// like name, which will make it easier for me to use.

use ChromePhp as console;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/



Route::get('/', function()
{

    // Check cookie to see if there is a user hash available.
    // If not, then hash something up nice and short and set
    // the cookie and redirect to the place with the charts.

    $page_id = Cookie::get('page_id');

    if (empty($page_id)) {
        $page_id = Page::new_id();
        Cookie::forever('page_id', $page_id);
    }

    return Redirect::to('c/' . $page_id);

});

Route::post('c/(:any)/add', function($page_id)
{
    $page = new Page($page_id);
    $input = Input::get();
    $page->add_symbol($input);
    $page->save();

    return Redirect::to('c/' . $page_id);

});

Route::post('c/(:any)/buy', function($page_id)
{
    $page = new Page($page_id);
    $input = Input::get();
    $page->buy_symbol($input);
    $page->save();

    return Redirect::to('c/' . $page_id);

});

Route::get('c/(:any)', function($id)
{
    $page = new Page($id);
    return View::make('charts.index')->with('symbols', $page->symbols);
});

Route::get('symbol/(:any)/history', function($symbol)
{
    $symbol = new Symbol($symbol);
    $history = $symbol->history();
    echo $history;
});

Route::get('ajax/autocomplete/symbol', function()
{

    $query = Input::get('query');
    $result = Symbol::lookup_symbol_by_query($query);
    echo json_encode($result);

});

Route::get('ajax/lookup/companyinfo', function()
{
    $query = Input::get('query');
    $result = Symbol::lookup_companyinfo_by_query($query);
    echo json_encode($result);

});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});