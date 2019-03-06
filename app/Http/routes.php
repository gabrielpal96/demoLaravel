<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
//use Illuminate\Support\Facades\DB;
//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/demo', function () {
//    $demo= DB::table('users')->get();
//    return view('demo.demoView',['demo'=>($demo)]);
//});
//
//Route::get('/demo1/{id?}','demo'.DIRECTORY_SEPARATOR.'demo1Controller@index' )->name('demoNema')->middleware(App\Http\Middleware\testMIddleware::class);

Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware('languages');

Route::group(['middleware' => ['auth', 'languages']], function () {
    Route::group(['prefix' => 'company'], function () {
        Route::get('/', 'Company' . DIRECTORY_SEPARATOR . 'companyController@index')->name('company');
        Route::get('/edit/{id}', 'Company' . DIRECTORY_SEPARATOR . 'companyController@edit')->name('edit');
        Route::post('/update', 'Company' . DIRECTORY_SEPARATOR . 'companyController@update')->name('update');
        Route::get('/delete/{id}', 'Company' . DIRECTORY_SEPARATOR . 'companyController@delete')->name('delete');
        Route::get('/add', 'Company' . DIRECTORY_SEPARATOR . 'companyController@companyAdd')->name('add');
        Route::post('/save', 'Company' . DIRECTORY_SEPARATOR . 'companyController@save')->name('save');
        Route::get('/show/{id}', 'Company' . DIRECTORY_SEPARATOR . 'companyController@infoCompany')->name('show');
        Route::post('/deleteMenyCompany', 'Company' . DIRECTORY_SEPARATOR . 'companyController@deleteMenyCompany')->name('deleteMenyCompany');
    });
    Route::group(['prefix' => 'person'], function () {
        Route::get('/', 'Person' . DIRECTORY_SEPARATOR . 'personController@index')->name('person');
        Route::get('/delete/{id}', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@delete')->name('deletePerson');
        Route::get('/add', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@addPerson')->name('addPerson');
        Route::post('/save', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@savePerson')->name('savePerson');
        Route::get('/edit/{id}', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@editPerson')->name('editPerson');
        Route::post('/update', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@updatePerson')->name('updatePerson');
        Route::post('/getCity', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@getCity')->name('getCity');
        Route::get('/getCompany', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@getCompany')->name('getCompany');
        Route::post('/deleteManyPerson', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@deleteManyPerson')->name('deleteManyPerson');
        Route::post('/changePosition', 'Person' . DIRECTORY_SEPARATOR . 'PersonController@changePosition')->name('changePosition');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'User' . DIRECTORY_SEPARATOR . 'UserController@index')->name('user');
        Route::get('/changeStatus/{id}', 'User' . DIRECTORY_SEPARATOR . 'UserController@changeStatus')->name('changeStatus');
        Route::get('/photo/{id}', 'User' . DIRECTORY_SEPARATOR . 'UserController@addPhoto')->name('addPhoto');
        Route::post('/upload', 'User' . DIRECTORY_SEPARATOR . 'UserController@upload')->name('upload');
        Route::get('/photoDelete/{id}', 'User' . DIRECTORY_SEPARATOR . 'UserController@photoDelete')->name('photoDelete');
        Route::get('/newUser', 'User' . DIRECTORY_SEPARATOR . 'UserController@newUser')->name('newUser');
        Route::post('/saveUser', 'User' . DIRECTORY_SEPARATOR . 'UserController@saveUser')->name('saveUser');
        Route::get('/deleteUser/{id}', 'User' . DIRECTORY_SEPARATOR . 'UserController@deleteUser')->name('deleteUser');
        Route::get('/profile', 'User' . DIRECTORY_SEPARATOR . 'UserController@profile')->name('profile');
        Route::get('/chagePassword', 'User' . DIRECTORY_SEPARATOR . 'UserController@chagePassword')->name('chagePassword');
        Route::post('/chagePassword', 'User' . DIRECTORY_SEPARATOR . 'UserController@chagePassword')->name('chagePassword');
        Route::get('/saveRole', 'User' . DIRECTORY_SEPARATOR . 'UserController@saveRole')->name('saveRole');
        Route::get('/permissions', 'User' . DIRECTORY_SEPARATOR . 'UserController@permissions')->name('permissions');
        Route::post('/permissionsAction', 'User' . DIRECTORY_SEPARATOR . 'UserController@permissionsAction')->name('permissionsAction');
        Route::POST('/changeEmail', 'User' . DIRECTORY_SEPARATOR . 'UserController@changeEmail')->name('changeEmail');
         Route::get('/getEmail', 'User' . DIRECTORY_SEPARATOR . 'UserController@getEmail')->name('getEmail');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'Admin' . DIRECTORY_SEPARATOR . 'adminController@index')->name('admin');
        Route::post('/newRole', 'Admin' . DIRECTORY_SEPARATOR . 'adminController@newRole')->name('newRole');
    });
    Route::group(['prefix' => 'languages'], function () {
        Route::get('/{lang}', 'Controller@languages')->name('languages');
    });

//});
});
Route::auth();

Route::get('/home', 'HomeController@index');
