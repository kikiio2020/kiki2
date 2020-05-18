<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

\Route::get('/', function () {
    return view('main');
});


//Unfortunately this approach doesn't seem possible
/*
\Route::get('/project/{projectName}/{page?}', function (string $projectName, string $page = 'index.html') {
    $content = \File::get('/var/www/node_modules/@kikiio2020/' . $projectName . '/docs/.vuepress/dist/' . $page);
    return $content;
});
*/