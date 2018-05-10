<?php

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


//TESTING URLS
Route::resource('/jono','ngacallloggingform');
Route::resource('/consolidated','singlePaneController');


//'Escalation Tracker Routes
//Route::resource('/Testing','formController');
Route::post('coppermigrationsadmin/import', 'coppermigrationsadmin@add')->name('migrationsimport');

Route::get('/linetester', function () {
    return view('forms/linetest');
})->middleware('allowed');

Route::get('/coppermigrationsadmin', function () {
    return view('forms.coppermigrationsadmin');
});

Route::get('/coppermigrations', function () {
    return view('forms.coppermigrations');
});


route::get('copperfindmigration','coppermigrationsadmin@findMigrationbyID');
route::get('copperfindmigrationpres','coppermigrationsadmin@findPreTestsbyID');
route::get('copperfindmigrationposts','coppermigrationsadmin@findPostTestsbyID');
route::get('copperupdatemigration','coppermigrationsadmin@updateMigrationsbyID');
route::get('coppersavepretest','coppermigrationsadmin@saveTestResultsPre');
route::get('coppersaveposttest','coppermigrationsadmin@saveTestResultsPost');
route::get('calcratealt','coppermigrationsadmin@calculateAltRate');

route::get('/lineTest','lineTest@getProductInfo');
route::get('/findASID','lineTest@findByASID')->middleware('throttle:3');
route::get('/startTest','lineTest@startTest');
route::get('/getTest','lineTest@getTestResults');



Route::get('/logEscalation', function() {
	
	$escalationtypes = App\escalationtypes::all();
	
	$eotypes = App\escalationordertypes::all();
	
	$test = 'TESTING';
	
	$rsps = App\Rsp::all();
	
	$escsources = App\escalationsources::all();
	
	$products = App\escalationproducts::all();
	
	$channels = App\escalationchannels::all();
	
	$teams = App\escalationteams::all();
	
    return view('forms.logescalation', compact('eotypes','rsps','products', 'teams'), compact('escalationtypes','escsources','channels'));
});

Route::get('/findEscalation', function() {
	
	$escalationtypes = App\escalationtypes::all();
	
	$eotypes = App\escalationordertypes::all();
	
	$test = 'TESTING';
	
	$rsps = App\Rsp::all();
	
	$escsources = App\escalationsources::all();
	
	$products = App\escalationproducts::all();
	
	$channels = App\escalationchannels::all();
	
	$teams = App\escalationteams::all();
	
    return view('forms.findescalation', compact('eotypes','rsps','products', 'teams'), compact('escalationtypes','escsources','channels'));
});



Route::post('/logescalation/store','storeescalations@store')->name('logescalation.submit');

route::get('/findEscalationbyID','storeescalations@findEscalation');
route::get('/findLogsByID','storeescalations@findLogs');
route::get('/storeinteraction','storeescalations@storeinteraction');
route::get('/pullInteractions','storeescalations@findInteractions');
route::get('/findSubTypes','storeescalations@findSubtypes');
route::get('/storefuplog','storeescalations@storefuplog');
route::get('/findfuplogs','storeescalations@findFuplogs');
route::get('/updateEscalation','storeescalations@update');
//'End Escalation Tracker Routes

//New Reporting Functions

route::get('/ngacallreportgenerate','ngacallreporter@ngacallquery');
route::get('/callsbytype','ngacallreporter@callsbytype');
route::get('/callsbytypemonth','ngacallreporter@callsbytypemonth');
route::get('/workbytype','ngacallreporter@workbytype');
route::get('/workbytypemonth','ngacallreporter@workbytypemonth');
route::get('/workbyrep','ngacallreporter@workbyrep');
route::get('/workbyrepmonth','ngacallreporter@workbyrepmonth');
route::get('/workbyrsp','ngacallreporter@workbyrsp');
route::get('/workbyrspmonth','ngacallreporter@workbyrspmonth');
route::get('/callsbyrep','ngacallreporter@callsbyrep');
route::get('/callsbyrepmonth','ngacallreporter@callsbyrepmonth');
route::get('/callsbyrsp','ngacallreporter@callsbyrsp');
route::get('/callsbyrspmonth','ngacallreporter@callsbyrspmonth');

route::get('/escbytype','ngacallreporter@escbytype');
route::get('/escbytypemonth','ngacallreporter@escbytypemonth');

//


Route::get('/', function () {
    return view('welcome');
});

Route::get('/MCILookup', function () {
    return view('forms.MCILookup');
});

Auth::routes();

//Route::get('/fibreTrainer', 'TrainerController@index');

Route::get('/fibreTrainer', function () {
    return view('fibreTrainer');
});

/*'HomeController@index'*/
Route::get('/home', function() {
	$posts = App\Post::all();
	return view('home', compact('posts'));
});

Route::get('/homeReport', function() {
	//$posts = App\Post::all();
	return view('homeReport');
});

Route::get('/register',function() {
	return redirect('/login');
});

Route::get('/mciqueue', function() {
	return view('components.mciqueue');
});

Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function() {
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/', 'AdminController@index')->name('admin.dashboard');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  // Password reset routes
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});

Route::get('/test', function() {
	$posts = App\Post::all();
    return view('test', compact('posts'));
});

//Route::get('/Testing', function() {
//	
//    return view('Testing');
//});

Route::get('/NGACallLogger', function() {
	$reasons = App\ngacallreason::all();
	$rsps = App\Rsp::all();
    return view('forms.NGACallLogger', compact('reasons'), compact('rsps'));
});


// for log a QA sheet 
Route::get('/ngaQAlogger', function() {
	
	//$agentNames = App\user::where('role_id','=','5')->get();//get users =  roleid = 5  =>  standeard-user

	$agentNames = app\user::all();
	
	$managerNames = App\user::where('role_id','=','3')->get();//$managerNames = App\user::where('role_id','=','3')->get();
	
	$rsps = App\Rsp::all();
	
	
	'ngaqalogging@qafunction';
	
    return view('forms.ngaqalogger', compact('managerNames'),compact('agentNames'),compact('rsps'));
});


Route::get('/ngaQAlogger2', function () {
    return view('forms.ngaQAlogger2');
});
route::get('/findUserName2','ngaqalogging@findUserName2');
route::get('/findTaskType','ngaqalogging@findTaskType');
route::get('/findRSP','ngaqalogging@findRSP');
route::get('/findQA','ngaqalogging@findQA');
route::get('/skillM','ngaqalogging@skillM');
route::post('/submitNewQa','ngaqalogging@submitNewQa');

route::get('/findUserName','ngaqalogging@findUserName');

route::get('/findPortal','ngaqalogging@findPortal');

//QA report

Route::get('/ngaqaReporter', function() {
	$reasons = App\ngacallreason::all();
	$rsps = App\Rsp::all();
    return view('forms.ngaqaReporter', compact('reasons'), compact('rsps'));
});

route::get('/findAgents','ngaqaReporting@findAgents');

route::get('/findAgents2','ngaqaReporting@findAgents2');

route::get('/displayChart','ngaqaReporting@displayChart');
//finish 

//PM 
Route::get('/pmMate', function() {
	$reasons = App\ngacallreason::all();
	$rsps = App\Rsp::all();
    return view('forms.pmMate', compact('reasons'), compact('rsps'));
});

Route::post("/pmMate/query", 'pmMateing@query')->name('pmMate.submit');

route::get('/displayOrder','pmMateing@displayOrder');

route::get('/displayOrder2','pmMateing@displayOrder2');

route::get('/displayOrder3','pmMateing@displayOrder3');

//for home page QA more
route::get('/getMoreQa','ngaqamore@index');

//todo list 
/*Route::get('/todolist',function() {
	return view('forms.todo');
});*/

//get document link 


//Route::get('/aboutMe','linkAppController@index');

// get document link end

Route::resource('api/todos','TodosController');



Route::get('/todo',function ()
	{ 
		return view('forms.todo');
	}
);

//Route::get('/todo2','TodoAppController@index');

//BBIP - bulk tracker
Route::get('/bulkTracker', function() {

$monthCounts = App\bulkorders::all();
    return view('forms.bulkTrack')->with('monthCounts',$monthCounts);
});

route::get('/getByRSPName','bulkTracking@getByRSPName');

route::get('/getByMonth','bulkTracking@getByMonth');


route::get('/populate','bulkTracking@populate');

route::get('/siteBasic','bulkTracking@siteBasic');

route::get('/overView','bulkTracking@overView');

route::get('/storedOrders','bulkTracking@storedOrders');

route::get('/deleteOrder','bulkTracking@deleteOrder');

route::get('/updateOrder','bulkTracking@updateOrder');

route::get('/editMe','bulkTracking@editMe');

route::get('/editDetail','bulkTracking@editDetail');

route::get('/btCode','bulkTracking@btCode');

//*******************BBIP Bulk TRacker Admin Panel ******************
Route::get('/bulkTrackerAdmin', function() {

$monthCounts = App\bulkorders::all();
    return view('forms.bulkTrackAdmin')->with('monthCounts',$monthCounts);
});


//Route::get('/bulkTrackerAdmin', 'bulkTrackingAdmin@index')->name('index');
Route::post('bulkTrackerAdmin/import', 'bulkTrackingAdmin@add')->name('import');

Route::post('bulkTrackerAdmin/importOrder', 'bulkTrackingAdmin@addOrder')->name('importOrder');

route::get('/getSiteCode','bulkTrackingAdmin@getSiteCode');

//*******************BBIP Bulk TRacker Admin Panel End******************


// BBIP end siteBasic


//feedback 
Route::get('/NGAFeedBack',function() {

	return view('forms.NGAFeedBack');
});

route::get('/disPlayFeedbackSheet','ngaFeedBacking@findFeedBackSheet');

route::get('/disPlayFeedbackSheet2','ngaFeedBacking@findFeedBackSheet2');

route::get('/disPlayFeedbackSheet3','ngaFeedBacking@findFeedBackSheet3');


//end 

//me -> getBCP return View::make("user/regprofile",compact('students'));
Route::get('/aboutMe', function () {
    return view('forms.me');
});

Route::get('/superMe', function () {
    return view('forms.superMe');
});


// ******************CA uploader START ******************
Route::get('/FMigration', function () {
    return view('forms.FMigration2');
});

Route::post('FMigration/import', 'FMigration@add')->name('import');

//Route::get('/callPython','callPython@showMe');
//Route::get('/callPython','callPython@aboutPython');

Route::post('/callPython','callPython@aboutPython');
Route::delete('/callPythonD','callPython@destroy');
Route::delete('/callPythonD2','callPython@destroy2');

Route::delete('/callPythonDP','callPython@query');
Route::get('/callPythonF','callPython@displayOrder'); 
Route::get('/callPythonFA','callPython@displayAllOrders'); 
Route::post('/callPythonM','callPython@update');

//Route::get('/newTable','newTable@displayOrder2'); 
Route::get('/newTable','newTable@displayOrder3');
// ******************FMigration uploader END******************


Route::get('/superQAs','superMesQAController@index');

Route::get('/superMes','superMesController@index');
//Route::resource('api/superMes','superMesController');


Route::resource('api/links','linksController');

Route::resource('api/taskLists','taskListController');

Route::resource('api/FTEs','FTEsController');

route::get('/getBCP','meing@getBCP');

route::get('/updateME','meing@updateME');

route::get('/downLoadOne','meing@downLoadOne');
//me -> getSkill
route::get('/getSkill','meing@getSkill');

route::get('/updateSkill','meing@updateSkill');

route::get('/getOne','meing@getOne');

route::get('/updateOne','meing@updateOne');

route::get('/updateOneDraft','meing@updateOneDraft');

route::get('/testEmail','meing@testEmail');

route::get('/testEmail2','meing@testEmail2');
//end me 




Route::get('/NGATicksheet', function() {
	$rsps = App\Rsp::all();
	$reasons = App\Ngaworkreason::all();
	return view('forms.NGATicksheet', compact('rsps'), compact('reasons'));
});

route::get('/getOrderDetil','ngaticksheets@getOrderDetil');



Route::get('NGACallReporting',function() {

	return view('forms.NGACallReporter');
});

Route::post("/store", 'NGACalllogging@store')->name('NGACallLogging.submit');

//for QA
Route::post("/ngaqalogger/store", 'ngaqalogging@store')->name('ngaqalogging.submit');


//end for QA

Route::post("/NGAFeedBack/store",'ngaFeedBacking@store')->name('ngaFeedBack.submit');




Route::post('/NGACallReporting/query', 'NGACallReporter@query')->name('NGACallReporter.submit');

Route::post('/NGACallReporting/querymonth', 'NGACallReporter@querymonth')->name('NGACallReporter.submit');

Route::post('/NGATicksheet/store','NGATicksheets@store')->name('NGATicksheet.submit');


Route::post('/MCILookup/store','ngamcilookuptext@store')->name('MCILookup.submit');
Route::post('/MCILookup/storeit','ngamcislogged@storeit')->name('MCIStore.submit');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
