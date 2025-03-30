<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;
////////////////////////////////////////////

//-- Controller Classes --//
use App\Http\Controllers\ErrorsController;
use App\Http\Controllers\Auth\ExpiredPasswordController;

use App\Http\Controllers\Common\InfrastructureController;
use App\Http\Controllers\Common\MaintenanceController;
use App\Http\Controllers\Common\DownloadsController;
use App\Http\Controllers\Common\ReportsController;

use App\Http\Controllers\Elab\SampleCurationController;

use App\Http\Controllers\Users\RolesController;
use App\Http\Controllers\Users\PermissionsController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Users\ProfileController;
//----------------------//

//-- Livewire Classes --//


use App\Livewire\Samples\ResearchSamples;
use App\Livewire\Samples\AddRepository;
use App\Livewire\Samples\AddToSamples;
use App\Livewire\Samples\BulkImportSamples;

use App\Livewire\Reagents\ManageReagents;
use App\Livewire\Reagents\MakeNewReagent;
use App\Livewire\Reagents\RemakeReagent;
use App\Livewire\Reagents\UpdateReagentUsage;

use App\Livewire\Elab\Common\ManageTasks;
use App\Livewire\Elab\Common\LogBook;

use App\Livewire\Elab\Elabnotes\ResprojectThemes;
use App\Livewire\Elab\Elabnotes\ResearchProtocols;
use App\Livewire\Elab\Elabnotes\ResearchProcedures;

use App\Livewire\Elab\Inventory\ManageInventory;
use App\Livewire\Elab\Inventory\AddToInventory;
use App\Livewire\Elab\Inventory\AddInventoryCategory;
use App\Livewire\Elab\Inventory\BulkImportInventory;
use App\Livewire\Elab\Inventory\UpdateConsumption;
use App\Livewire\Elab\Inventory\ReviewConsumption;
use App\Livewire\Elab\Inventory\ReviewReplinishment;


//----------------------//

use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    ScopeSessions::class,
])->group(function () {

  //very important for the function of livewire.
  Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
  });
	//very important for the function of livewire.

  
    Route::get('/', function () {
      return view('welcome');
    });

		Auth::routes();

    //Route::get('/', function () {
			//dd(\App\Models\User::all());
    //    return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    //});

   	// -- Home Controller: Below two routes must be present here only after Auth -- //

    // -- These two routes are Non-authenticated -- //
    // -------------- //

    // -- These two routes are Non-authenticated -- //
    Route::middleware(['auth', 'verified',])->group(function () {
      Route::get('password/expired', 'App\Http\Controllers\Auth\ExpiredPasswordController@expired')
        ->name('password.expired');    

      Route::post('password/post_expired', 'App\Http\Controllers\Auth\ExpiredPasswordController@postExpired')
        ->name('password.post_expired');
    });
    // -------------- //

    /*
    Route::get('/home/passwordReset', [
      'middleware'  => ['auth', 'verified'],
      'uses' => 'App\Http\Controllers\HomeController@passwordReset'
    ])->name('home/passwordReset');

    Route::post('/home/pwupdate', [
      'middleware'  => ['auth', 'verified'],
      'uses' => 'App\Http\Controllers\HomeController@updatePassword'
    ])->name('home.pwupdate');
    */
    // -------------- //


  // -- These routes are Tenant function specific and fully Athenticated -- //
  Route::middleware(['auth', 'verified','isChecked','sessionOk'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('home/no_subscription', [App\Http\Controllers\HomeController::class, 'no_subscription'])->name('no-subscription-notice');
    
    //-- SAAS Subscription Error Routes --//
    Route::get('errors/error10000', [App\Http\Controllers\ErrorsController::class, 'error10000'])->name('error.error10000');
    Route::get('errors/error10001', [App\Http\Controllers\ErrorsController::class, 'error10001'])->name('error.error10001');
    Route::get('errors/error10002', [App\Http\Controllers\ErrorsController::class, 'error10002'])->name('error.error10002');
    Route::get('errors/error10010', [App\Http\Controllers\ErrorsController::class, 'error10010'])->name('error.error10010');
    //-- ----------------------- --//

    Route::resource('/profile',     ProfileController::class);
    Route::resource('/group-roles', RolesController::class);
    Route::resource('/permissions', PermissionsController::class);
    Route::resource('/group-users', UsersController::class);

    Route::resource('/infrastructure', InfrastructureController::class);
    Route::resource('/maintenance',    MaintenanceController::class);
    Route::resource('/reports',        ReportsController::class);
    Route::get('downloads/maintenanceFile/{file_info}', [App\Http\Controllers\Common\DownloadsController::class, 'maintenanceFile'])
              ->name('downloads.maintenanceFile');
    Route::get('downloads/resProjectFile/{report_uuid}', [App\Http\Controllers\Common\DownloadsController::class, 'resProjectFile'])
              ->name('downloads.resProjectFile');

    //-- Paid Subscription Based Routes --//
      Route::middleware(['subscribed'])->group(function () {
        
      });
    //-- ----------------------- --//

    //-- Controller Based Routes --//
      Route::resource('/research-projects', App\Http\Controllers\Elab\ResearchProjectsController::class);
      Route::resource('/curate-research-samples', App\Http\Controllers\Elab\SampleCurationController::class);
    //-- ----------------------- --//

    //-- Livewire Based Routes --//
      Route::get('/resproject-themes',      App\Livewire\Elab\Elabnotes\ResprojectThemes::class);
      Route::get('/research-protocols',     App\Livewire\Elab\Elabnotes\ResearchProtocols::class);
      Route::get('/research-procedures',    App\Livewire\Elab\Elabnotes\ResearchProcedures::class);

      Route::get('/manage-inventory',       App\Livewire\Elab\Inventory\ManageInventory::class);
      Route::get('/add-inventory-category', App\Livewire\Elab\Inventory\AddInventoryCategory::class);
      Route::get('/bulk-import-inventory',  App\Livewire\Elab\Inventory\BulkImportInventory::class);
      Route::get('/add-to-inventory',       App\Livewire\Elab\Inventory\AddToInventory::class);
      Route::get('/update-consumption',     App\Livewire\Elab\Inventory\UpdateConsumption::class);
      Route::get('/review-consumption',     App\Livewire\Elab\Inventory\ReviewConsumption::class);
      Route::get('/review-replinishment',   App\Livewire\Elab\Inventory\ReviewReplinishment::class);
      
      Route::get('/research-samples',       App\Livewire\Samples\ResearchSamples::class);
      Route::get('/add-repository',         App\Livewire\Samples\AddRepository::class);
      Route::get('/add-to-samples',         App\Livewire\Samples\AddToSamples::class);
      Route::get('/bulk-import-samples',    App\Livewire\Samples\BulkImportSamples::class);

      Route::get('/manage-reagents',       App\Livewire\Reagents\ManageReagents::class);
      Route::get('/make-new-reagent',      App\Livewire\Reagents\MakeNewReagent::class);
      Route::get('/remake-reagent',        App\Livewire\Reagents\RemakeReagent::class);
      Route::get('/update-reagent-usage',  App\Livewire\Reagents\UpdateReagentUsage::class);

      Route::get('/log-book',              App\Livewire\Elab\Common\LogBook::class);
      Route::get('/manage-tasks',          App\Livewire\Elab\Common\ManageTasks::class);
    //-- --------------------- --//



  }); // Braces: End of Tenancy Auth, Verified and isChecked //

}); // Braces: End of Tenancy route //
