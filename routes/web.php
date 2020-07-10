<?php



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
Auth::routes([
    'reset' =>false,
    'confirm' => false,
    'verify' => false,
]);
Route::middleware(['set_locale'])->group(function(){
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/createkek', function() {
        $path = storage_path("app/public/");
        File::put("{$path}/mytextdocument.txt",'John Doe');
    });
//Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/logout','Auth\LoginController@logout')->name('get-logout');
    Route::resource('project', 'ProjectController');
    Route::resource('task', 'TaskController');
//Route::get('/task/{$task_status}','TaskController@index');
    Route::get('/tasks/{task_status}','TaskController@filterTasks')->name('task.filter');
    Route::get('/tasks/file-download/{task}','TaskController@fileDownload')->name('task.file_download');

    Route::group(['middleware' =>'is_admin'], function() {
        Route::get('/show-users','AdminUserController@getUsers')->name('admin.get.users');
    });

    Route::get('/my-projects','ProjectController@myProjects')->name('my.projects');
    Route::post('/add-user-to-project/{project_id}','ProjectController@addUserToProject')->name('projects.add.user');
    Route::post('/project-delete-user/{user_id}','ProjectController@deleteUser')->name('project.delete.user');
    Route::post('/task-add-user/{task_id}','TaskController@addUserToTask')->name('task.add.user');
    Route::post('/task-delete-user/{task_id}','TaskController@deleteUser')->name('task.delete.user');

    Route::get('locale/{locale}','MainController@changeLocale')->name('locale');
});

