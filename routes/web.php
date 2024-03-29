<?php

use App\User;
use Illuminate\Support\Facades\Hash;
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

Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    // Dashboard process flow
    Route::prefix('select')->group(function () {
        Route::get('option/{branch_id}', 'HomeController@select')->name('select.option.list');
    });
    Route::prefix('notification')->group(function () {
        Route::get('list', 'HomeController@notificationList')->name('notification.list');
        Route::get('create', 'HomeController@notificationCreate')->name('notification.create');
        Route::post('store', 'HomeController@notificationStore')->name('notification.store');
        Route::get('view/{id}', 'HomeController@notificationView')->name('notification.view');
        Route::get('edit/{id}', 'HomeController@notificationEdit')->name('notification.edit');
        Route::post('update', 'HomeController@notificationUpdate')->name('notification.update');
        Route::get('destroy/{id}', 'HomeController@notificationDestroy')->name('notification.destroy');
    });
    // Project
    Route::prefix('project')->group(function () {
        Route::get('list', 'ProjectController@index')->name('project.list');
        Route::get('create', 'ProjectController@create')->name('project.create');
        Route::get('edit/{project_code}', 'ProjectController@edit')->name('project.edit');
        Route::get('view/{project_code}', 'ProjectController@view')->name('project.view');
        Route::post('store', 'ProjectController@store')->name('project.store');
        Route::post('update', 'ProjectController@update')->name('project.update');
        Route::get('destroy/{id}', 'ProjectController@destroy')->name('project.destroy');
        // Project Client
        Route::prefix('client')->group(function () {
            Route::get('list', 'ProjectController@indexClient')->name('project.list.client');
            Route::get('create', 'ProjectController@createClient')->name('project.create.client');
            Route::post('store', 'ProjectController@storeClient')->name('project.store.client');
            Route::get('view/{id}', 'ProjectController@viewClient')->name('project.view.client');
            Route::get('upload/{client_id}', 'ProjectController@uploadClient')->name('project.upload.client');
            Route::post('upload', 'ProjectController@storeUploadClient')->name('project.upload.store.client');
            Route::get('upload-destory/{id}', 'ProjectController@destroyUploadClient')->name('project.upload.destroy.client');
            Route::get('edit/{client_id}', 'ProjectController@editClient')->name('project.edit.client');
            Route::post('update', 'ProjectController@updateClient')->name('project.update.client');
            Route::get('destroy/{id}', 'ProjectController@destroyClient')->name('project.destroy.client');
        });
        // Milestones
        Route::prefix('milestone')->group(function () {
            Route::get('{project_id}/create', 'ProjectController@createMilestone')->name('project.create.milestone');
            Route::post('{project_id}/store', 'ProjectController@storeMilestone')->name('project.store.milestone');
            Route::get('edit/{milestone_id}', 'ProjectController@editMilestone')->name('project.edit.milestone');
            Route::post('update', 'ProjectController@updateMilestone')->name('project.update.milestone');
        });
        // Expenses management
        Route::prefix('expenses')->group(function () {
            Route::get('create', 'ExpensesController@create')->name('project.expenses.create');
            Route::get('add/{id}', 'ExpensesController@add')->name('project.expenses.add');
            Route::post('store', 'ExpensesController@store')->name('project.expenses.store');
        });
    });
    Route::prefix('store')->group(function () {
        Route::get('list/{type}', 'StoreController@index')->name('store.list');
        Route::get('create/{type}', 'StoreController@create')->name('store.create');
        Route::get('edit/{id}', 'StoreController@edit')->name('store.edit');
        Route::get('view/{id}', 'StoreController@view')->name('store.view');
        Route::post('store', 'StoreController@store')->name('store.store');
        Route::post('update', 'StoreController@update')->name('store.update');
        Route::get('destroy/{id}', 'StoreController@destroy')->name('store.destroy');
        Route::prefix('request')->group(function () {
            Route::get('list', 'StoreController@requestIndex')->name('store.request.list');
            Route::get('create', 'StoreController@requestCreate')->name('store.request.create');
            Route::post('store', 'StoreController@requestStore')->name('store.request.store');
            Route::get('view/{id}', 'StoreController@requestView')->name('store.request.view');
            Route::get('edit/{type}/{id}', 'StoreController@requestEdit')->name('store.request.edit');
            Route::post('update', 'StoreController@requestUpdate')->name('store.request.update');
            Route::get('destroy/{id}', 'StoreController@requestDestroy')->name('store.request.destroy');
        });
    });
    // Secretary management
    Route::prefix('secretary')->group(function () {
        // Letters
        Route::get('letter/upload', 'SecretaryController@letterIndex')->name('secretary.letter.list');
        Route::get('letter/create', 'SecretaryController@letterCreate')->name('secretary.letter.create');
        Route::post('letter/store', 'SecretaryController@letterStore')->name('secretary.letter.store');
        Route::get('letter/destroy/{id}', 'SecretaryController@letterDestroy')->name('secretary.letter.destroy');
        // Minutes
        Route::get('minute/upload', 'SecretaryController@minuteIndex')->name('secretary.minute.list');
        Route::get('minute/create', 'SecretaryController@minuteCreate')->name('secretary.minute.create');
        Route::post('minute/store', 'SecretaryController@minuteStore')->name('secretary.minute.store');
        Route::get('minute/view/{id}', 'SecretaryController@minuteView')->name('secretary.minute.view');
        Route::get('minute/edit/{id}', 'SecretaryController@minuteEdit')->name('secretary.minute.edit');
        Route::post('minute/update', 'SecretaryController@minuteUpdate')->name('secretary.minute.update');
        Route::get('minute/destroy/{id}', 'SecretaryController@minuteDestroy')->name('secretary.minute.destroy');
    });
    // Supllier management
    Route::prefix('supplier')->group(function () {
        Route::get('list', 'SupplierController@index')->name('supplier.list');
        Route::get('create', 'SupplierController@create')->name('supplier.create');
        Route::get('edit/{id}', 'SupplierController@edit')->name('supplier.edit');
        // Route::get('view/{id}', 'SupplierController@view')->name('supplier.view');
        Route::post('store', 'SupplierController@store')->name('supplier.store');
        Route::post('update', 'SupplierController@update')->name('supplier.update');
        Route::get('destroy/{id}', 'SupplierController@destroy')->name('supplier.destroy');
    });
    // Human Resource
    Route::prefix('employee')->group(function () {
        Route::get('list', 'EmployeeController@index')->name('employee.list');
        Route::get('create', 'EmployeeController@create')->name('employee.create');
        Route::get('edit/{employee_code}', 'EmployeeController@edit')->name('employee.edit');
        Route::get('view/{employee_code}', 'EmployeeController@view')->name('employee.view');
        Route::post('store', 'EmployeeController@store')->name('employee.store');
        Route::post('update', 'EmployeeController@update')->name('employee.update');
        Route::get('destroy/{id}', 'EmployeeController@destroy')->name('employee.destroy');
        
        Route::get('docs/{employee_code}/create', 'EmployeeController@createdocs')->name('employee.docs.create');
        Route::post('docs/{employee_code}/store', 'EmployeeController@storedocs')->name('employee.docs.store');
        Route::get('docs/destroy/{id}', 'EmployeeController@destroydocs')->name('employee.docs.destroy');
    });
    // Progress report
    Route::prefix('progress')->group(function () {
        Route::get('report/list', 'ProjectController@progressReportList')->name('progress.report.list');
        Route::get('report/create', 'ProjectController@progressReportCreate')->name('progress.report.create');
        Route::post('report/create', 'ProjectController@progressReportStore')->name('progress.report.store');
        Route::get('report/view/{id}', 'ProjectController@progressReportView')->name('progress.report.view');
    });
    // Branches
    Route::prefix('branches')->group(function () {
        Route::get('list', 'BranchController@index')->name('branches.list');
        Route::get('create', 'BranchController@create')->name('branches.create');
        Route::get('edit/{id}', 'BranchController@edit')->name('branches.edit');
        Route::post('store', 'BranchController@store')->name('branches.store');
        Route::post('update', 'BranchController@update')->name('branches.update');
        Route::get('destroy/{id}', 'BranchController@destroy')->name('branches.destroy');
    });
    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('change-password', 'SettingsController@passwordView')->name('settings.password')->middleware('password.confirm');
        Route::post('change-password', 'SettingsController@changePassword')->name('settings.password.change');
    });
});

Route::get('permissions', function () {
    $permissions = [
        [
            "title" => "View Project",
            "code" => "project_view",
        ],
        [
            "title" => "Create Project",
            "code" => "project_create",
        ],
        [
            "title" => "Edit Project",
            "code" => "project_edit",
        ],
        [
            "title" => "Delete Project",
            "code" => "project_delete",
        ],
        [
            "title" => "Add Project Milestone",
            "code" => "project_add_milestone",
        ],
        [
            "title" => "Add Project Expenses",
            "code" => "project_expenses",
        ],
        [
            "title" => "View Equipments",
            "code" => "store_view",
        ],
        [
            "title" => "Add Equipment",
            "code" => "store_create",
        ],
        [
            "title" => "Update Equipment",
            "code" => "store_edit",
        ],
        [
            "title" => "Delete Equipment",
            "code" => "store_delete",
        ],
        [
            "title" => "Store Request",
            "code" => "store_request",
        ],
        [
            "title" => "Approve/Reject Store Request",
            "code" => "store_approval",
        ],
        [
            "title" => "Delete Store Request",
            "code" => "store_request_delete",
        ],
        [
            "title" => "View Suppliers",
            "code" => "supplier_view",
        ],
        [
            "title" => "Create Supplier",
            "code" => "supplier_create",
        ],
        [
            "title" => "Update Supplier",
            "code" => "supplier_edit",
        ],
        [
            "title" => "Delete Supplier",
            "code" => "supplier_delete",
        ],
        [
            "title" => "View Employee",
            "code" => "employee_view",
        ],
        [
            "title" => "Create Employee",
            "code" => "employee_create",
        ],
        [
            "title" => "Update Employee",
            "code" => "employee_edit",
        ],
        [
            "title" => "Delete Employee",
            "code" => "employee_delete",
        ],
        [
            "title" => "View Report",
            "code" => "progress_view",
        ],
        [
            "title" => "Upload Report",
            "code" => "progress_create",
        ],
        [
            "title" => "Delete Report",
            "code" => "progress_delete",
        ],
        [
            "title" => "View Letters",
            "code" => "letter_view",
        ],
        [
            "title" => "Upload Letters",
            "code" => "letter_create",
        ],
        [
            "title" => "Delete Letters",
            "code" => "letter_delete",
        ],
        [
            "title" => "View Minutes",
            "code" => "minute_view",
        ],
        [
            "title" => "Update Minutes",
            "code" => "minute_edit",
        ],
        [
            "title" => "Upload Minutes",
            "code" => "minute_create",
        ],
        [
            "title" => "Delete Minutes",
            "code" => "minute_delete",
        ],
        [
            "title" => "View Notification",
            "code" => "notification_view",
        ],
        [
            "title" => "Update Notification",
            "code" => "notification_edit",
        ],
        [
            "title" => "Upload Notification",
            "code" => "notification_create",
        ],
        [
            "title" => "Delete Notification",
            "code" => "notification_delete",
        ],
    ];
    foreach ($permissions as $key => $value) {
        \App\Permission::create($value);
    }
    return "Done";
});
