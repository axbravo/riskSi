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
// Authentication routes...




// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::post('auth/logout', 'Auth\AuthController@postLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'ClientController@store');
Route::get('/', 'PagesController@home');

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('admin/', ['uses'=>'PagesController@adminHome','as'=>'admin.home']);

    Route::get('admin/attendance', 'BusinessController@attendance');

    Route::get('admin/config/system', 'BusinessController@system');
    Route::post('admin/config/system', ['uses'=>'BusinessController@systemUpdate','as'=>'config.system.update']);

    Route::get('admin/risk/new', 'RiskController@create');
    Route::post('admin/risk/new', 'RiskController@store');

    Route::get('admin/password', 'AdminController@passwordAdmin');
    Route::post('admin/password', 'AdminController@passwordUpdateAdmin');

    Route::get('admin/client', 'ClientController@index');
    Route::post('admin/client/desactive', 'ClientController@desactive');

    Route::get('admin/analist', ['as'=>'admin.analista','uses'=>'AdminController@analist']);
    Route::get('admin/analist/{id}/edit', 'AdminController@editAnalist');
    Route::post('admin/analist/{id}/edit', 'AdminController@updateAnalist');
    Route::get('admin/analist/{id}/delete', 'AdminController@destroyAnalist');

    Route::get('admin/riskmanager', ['as'=>'admin.riskmanager','uses'=>'AdminController@riskmanager']);
    Route::get('admin/riskmanager/{id}/edit', 'AdminController@editRiskManager');
    Route::post('admin/riskmanager/{id}/edit', 'AdminController@updateRiskManager');
    Route::get('admin/riskmanager/{id}/delete', 'AdminController@destroyRiskManager');

    Route::get('admin/projectManager', ['as'=>'admin.projectManager','uses'=>'AdminController@projectManager']);
    Route::get('admin/projectManager/{id}/edit', 'AdminController@editprojectManager');
    Route::post('admin/projectManager/{id}/edit', 'AdminController@updateprojectManager');
    Route::get('admin/projectManager/{id}/delete', 'AdminController@destroyprojectManager');

    Route::get('admin/portmanager', ['as'=>'admin.portmanager','uses'=>'AdminController@portmanager']);
    Route::get('admin/portmanager/{id}/edit', 'AdminController@editPortManager');
    Route::post('admin/portmanager/{id}/edit', 'AdminController@updatePortManager');
    Route::get('admin/portmanager/{id}/delete', 'AdminController@destroyPortManager');

    Route::get('admin/user/new', 'AdminController@newUser');
    Route::post('admin/user/new', 'AdminController@store');

    Route::get('admin/admin', 'AdminController@admin');
    Route::get('admin/admin/{id}/edit', 'AdminController@editAdmin');
    Route::post('admin/admin/{id}/edit', 'AdminController@updateAdmin');
    //
    Route::get('admin/admin/{id}/delete', 'AdminController@destroy');

    
    Route::get('admin/rbs', ['as' => 'admin.rbs.index', 'uses' =>'RbsController@index']);
    Route::get('admin/rbs/new', 'RbsController@create');
    Route::post('admin/rbs/new', ['as' => 'rbs.store', 'uses' =>'RbsController@store']);
    Route::get('admin/rbs/{id}/edit', ['as' => 'rbs.edit', 'uses' =>'RbsController@edit']);
    Route::post('admin/rbs/{id}/edit', ['as' => 'rbs.update', 'uses' =>'RbsController@update']);
    Route::post('admin/rbs/{id}/delete', ['as' => 'rbs.delete', 'uses' =>'RbsController@destroy']);
    Route::get('admin/rbs/{id}/subrbs', ['as' => 'rbs.index', 'uses' =>'RbsController@indexSub']);

    Route::get('admin/distribution', ['as' => 'admin.distribution.index', 'uses' =>'DistributionController@index']);
    Route::get('admin/distribution/new', 'DistributionController@create');
    Route::post('admin/distribution/new', ['as' => 'distribution.store', 'uses' =>'DistributionController@store']);
    Route::get('admin/distribution/{id}/edit', ['as' => 'distribution.edit', 'uses' =>'DistributionController@edit']);
    Route::post('admin/distribution/{id}/edit', ['as' => 'distribution.update', 'uses' =>'DistributionController@update']);
    Route::post('admin/distribution/{id}/delete', ['as' => 'distribution.delete', 'uses' =>'DistributionController@destroy']);

    Route::get('admin/iteration', ['as' => 'admin.iteration.index', 'uses' =>'DistributionController@indexIter']);
    Route::get('admin/iteration/new', 'DistributionController@createIter');
    Route::post('admin/iteration/new', ['as' => 'iteration.store', 'uses' =>'DistributionController@storeIter']);
    Route::get('admin/iteration/{id}/edit', ['as' => 'iteration.edit', 'uses' =>'DistributionController@editIter']);
    Route::post('admin/iteration/{id}/edit', ['as' => 'iteration.update', 'uses' =>'DistributionController@updateIter']);
    Route::post('admin/iteration/{id}/delete', ['as' => 'iteration.delete', 'uses' =>'DistributionController@destroyIter']);

    Route::get('admin/variable', ['as' => 'admin.variable.index', 'uses' =>'DistributionController@indexVar']);
    Route::get('admin/variable/new', 'DistributionController@createVar');
    Route::post('admin/variable/new', ['as' => 'variable.store', 'uses' =>'DistributionController@storeVar']);
    Route::get('admin/variable/{id}/edit', ['as' => 'variable.edit', 'uses' =>'DistributionController@editVar']);
    Route::post('admin/variable/{id}/edit', ['as' => 'variable.update', 'uses' =>'DistributionController@updateVar']);
    Route::post('admin/variable/{id}/delete', ['as' => 'variable.delete', 'uses' =>'DistributionController@destroyVar']);

    Route::get('admin/checklistItems', ['as' => 'admin.checklistItems.index', 'uses' =>'RiskController@indexCheck']);
    Route::get('admin/checklistItems/new', 'RiskController@createCheck');
    Route::post('admin/checklistItems/new', ['as' => 'checklistItems.store', 'uses' =>'RiskController@storeCheck']);
    Route::get('admin/checklistItems/{id}/edit', ['as' => 'checklistItems.edit', 'uses' =>'RiskController@editCheck']);
    Route::post('admin/checklistItems/{id}/edit', ['as' => 'checklistItems.update', 'uses' =>'RiskController@updateCheck']);
    Route::post('admin/checklistItems/{id}/delete', ['as' => 'checklistItems.delete', 'uses' =>'RiskController@destroyCheck']);


})  ;


Route::group(['middleware' => ['auth', 'analist']], function () {

    Route::get('analist/', ['uses'=>'PagesController@analistHome','as'=>'analist.home']);
    Route::get('analist/activity/{id}/edit', ['as' => 'activity.edit', 'uses' =>'ProjectController@editAnalist']);
    Route::post('analist/activity/{id}/edit', ['as' => 'activity.update', 'uses' =>'ProjectController@updateAnalist']);
    Route::get('analist/activity/subactivities', ['as' => 'activity.indexSubAnalist', 'uses' =>'ProjectController@indexSubAnalist']);
    Route::get('analist/taskrisk/{id}/edit', ['as' => 'taskrisk.edit', 'uses' =>'RiskController@editRiskAnalist']);
    Route::post('analist/taskrisk/{id}/edit', ['as' => 'taskrisk.update', 'uses' =>'RiskController@updateRiskAnalist']);
    Route::get('analist/taskrisk/subrisks', ['as' => 'taskrisk.indexAnalist', 'uses' =>'RiskController@indexSubAnalist']);
})  ;   

Route::group(['middleware' => ['auth', 'riskmanager']], function () {

    Route::get('riskmanager/', ['uses'=>'PagesController@riskmanagerHome','as'=>'riskmanager.home']);
    Route::get('riskmanager/risktask', ['as' => 'riskmanager.risktask.indexRiskM', 'uses' =>'RiskController@indexRiskM']);
    Route::get('riskmanager/risktask/new', 'RiskController@createRiskM');
    Route::post('riskmanager/risktask/new', ['as' => 'risktask.store', 'uses' =>'RiskController@storeRiskM']);
    Route::get('riskmanager/risktask/{id}/check', ['as' => 'risktask.check', 'uses' =>'RiskController@checkRiskM']);
    Route::post('riskmanager/risktask/{id}/check', ['as' => 'risktask.checkPost', 'uses' =>'RiskController@checkPostRiskM']);
    Route::get('riskmanager/risktask/{id}/edit', ['as' => 'risktask.edit', 'uses' =>'RiskController@editRiskM']);
    Route::post('riskmanager/risktask/{id}/edit', ['as' => 'risktask.update', 'uses' =>'RiskController@updateRiskM']);
    Route::post('riskmanager/risktask/{id}/delete', ['as' => 'risktask.delete', 'uses' =>'RiskController@destroyRiskM']);
    Route::get('riskmanager/risktask/{id}/subrisks', ['as' => 'risktask.indexRiskM', 'uses' =>'RiskController@indexSubRiskM']);

    Route::get('riskmanager/impact', ['as' => 'riskmanager.impact.indexImpact', 'uses' =>'RiskController@indexImpact']);
    Route::get('riskmanager/impact/new', 'RiskController@createImpact');
    Route::post('riskmanager/impact/new', ['as' => 'impact.store', 'uses' =>'RiskController@storeImpact']);
    Route::get('riskmanager/impact/{id}/edit', ['as' => 'impact.edit', 'uses' =>'RiskController@editImpact']);
    Route::post('riskmanager/impact/{id}/edit', ['as' => 'impact.update', 'uses' =>'RiskController@updateImpact']);
    Route::post('riskmanager/impact/{id}/delete', ['as' => 'impact.delete', 'uses' =>'RiskController@destroyImpact']);

    Route::get('riskmanager/probability', ['as' => 'riskmanager.probability.indexProbability', 'uses' =>'RiskController@indexProbability']);
    Route::get('riskmanager/probability/new', 'RiskController@createProbability');
    Route::post('riskmanager/probability/new', ['as' => 'probability.store', 'uses' =>'RiskController@storeProbability']);
    Route::get('riskmanager/probability/{id}/edit', ['as' => 'probability.edit', 'uses' =>'RiskController@editProbability']);
    Route::post('riskmanager/probability/{id}/edit', ['as' => 'probability.update', 'uses' =>'RiskController@updateProbability']);
    Route::post('riskmanager/probability/{id}/delete', ['as' => 'probability.delete', 'uses' =>'RiskController@destroyProbability']);

     Route::get('riskmanager/risklevel', ['as' => 'riskmanager.risklevel.indexRisklevel', 'uses' =>'RiskController@indexRisklevel']);
    Route::get('riskmanager/risklevel/new', 'RiskController@createRiskLevel');
    Route::post('riskmanager/risklevel/new', ['as' => 'risklevel.store', 'uses' =>'RiskController@storeRisklevel']);
    Route::get('riskmanager/risklevel/{id}/edit', ['as' => 'risklevel.edit', 'uses' =>'RiskController@editRisklevel']);
    Route::post('riskmanager/risklevel/{id}/edit', ['as' => 'risklevel.update', 'uses' =>'RiskController@updateRisklevel']);
    Route::post('riskmanager/risklevel/{id}/delete', ['as' => 'risklevel.delete', 'uses' =>'RiskController@destroyRisklevel']);
})  ;   

Route::group(['middleware' => ['auth', 'portmanager']], function () {

    Route::get('portmanager/', ['uses'=>'PagesController@portmanagerHome','as'=>'portmanager.home']);

    Route::get('portmanager/project', ['as' => 'portmanager.project.indexPort', 'uses' =>'ProjectController@indexPort']);
    Route::get('portmanager/project/new', 'ProjectController@createPort');
    Route::post('portmanager/project/new', ['as' => 'project.store', 'uses' =>'ProjectController@storePort']);
    Route::get('portmanager/project/{id}/analyse', ['as' => 'project.analyse', 'uses' =>'ProjectController@analyse']);

    Route::get('portmanager/project/{id}/edit', ['as' => 'project.edit', 'uses' =>'ProjectController@editPort']);
    Route::post('portmanager/project/{id}/edit', ['as' => 'project.update', 'uses' =>'ProjectController@updatePort']);
    Route::post('portmanager/project/{id}/delete', ['as' => 'project.delete', 'uses' =>'ProjectController@destroy']);
    Route::get('portmanager/project/{id}/subactivities', ['as' => 'project.indexPort', 'uses' =>'ProjectController@indexSubPort']);
    //Route::get('portmanager/project/{id}/subactivities', ['as' => 'project.route', 'uses' =>'ProjectController@criticRoute']);

    Route::get('portmanager/itemrisk', ['as' => 'portmanager.itemrisk.indexPortM', 'uses' =>'RiskController@indexPortM']);
    Route::get('portmanager/itemrisk/new', 'RiskController@createPortM');
    Route::post('portmanager/itemrisk/new', ['as' => 'itemrisk.store', 'uses' =>'RiskController@storePortM']);
    Route::get('portmanager/itemrisk/{id}/check', ['as' => 'itemrisk.check', 'uses' =>'RiskController@checkPortM']);
    Route::get('portmanager/itemrisk/{id}/edit', ['as' => 'itemrisk.edit', 'uses' =>'RiskController@editPortM']);
    Route::post('portmanager/itemrisk/{id}/edit', ['as' => 'itemrisk.update', 'uses' =>'RiskController@updatePortM']);
    Route::post('portmanager/itemrisk/{id}/delete', ['as' => 'itemrisk.delete', 'uses' =>'RiskController@destroyPortM']);
    Route::get('portmanager/itemrisk/{id}/subrisks', ['as' => 'itemrisk.indexPortM', 'uses' =>'RiskController@indexSubPortM']);

})  ;   

Route::group(['middleware' => ['auth', 'projectmanager']], function () {

    Route::get('projectManager/', ['uses'=>'PagesController@projectmanagerHome','as'=>'projectmanager.home']);

    Route::get('projectManager/projects', ['as' => 'projectmanager.projects.index', 'uses' =>'ProjectController@index']);
    Route::get('projectManager/projects/new', 'ProjectController@create');
    Route::post('projectManager/projects/new', ['as' => 'projects.store', 'uses' =>'ProjectController@store']);
    Route::get('projectManager/projects/{id}/analyse', ['as' => 'projects.createanalyse', 'uses' =>'ProjectController@createanalyse']);
    Route::post('projectManager/projects/{id}/analyse', ['as' => 'projects.analyse', 'uses' =>'ProjectController@analyse']);
    Route::get('projectManager/projects/cuantitative', ['as' => 'projectmanager.projects.cuantitative','uses' =>'ProjectController@cuantitative']);

    Route::get('projectManager/projects/{id}/edit', ['as' => 'projects.edit', 'uses' =>'ProjectController@edit']);
    Route::post('projectManager/projects/{id}/edit', ['as' => 'projects.update', 'uses' =>'ProjectController@update']);
    Route::post('projectManager/projects/{id}/delete', ['as' => 'projects.delete', 'uses' =>'ProjectController@destroy']);
    Route::get('projectManager/projects/{id}/subactivities', ['as' => 'projects.index', 'uses' =>'ProjectController@indexSub']);

    Route::get('projectManager/task', ['as' => 'projectManager.task.index', 'uses' =>'RiskController@index']);
    Route::get('projectManager/task/new', 'RiskController@create');
    Route::post('projectManager/task/new', ['as' => 'task.store', 'uses' =>'RiskController@store']);
    Route::get('projectManager/task/{id}/check', ['as' => 'task.check', 'uses' =>'RiskController@check']);
    Route::post('projectManager/task/{id}/check', ['as' => 'task.checkPost', 'uses' =>'RiskController@checkPost']);
    Route::get('projectManager/task/{id}/edit', ['as' => 'task.edit', 'uses' =>'RiskController@edit']);
    Route::post('projectManager/task/{id}/edit', ['as' => 'task.update', 'uses' =>'RiskController@update']);
    Route::get('projectManager/task/{id}/responseplan', ['as' => 'task.editresponse', 'uses' =>'RiskController@editresponse']);
    Route::post('projectManager/task/{id}/responseplan', ['as' => 'task.updateresponse', 'uses' =>'RiskController@updateresponse']);

    Route::get('projectManager/responseplan/new', 'ProjectController@createresponse');
    Route::post('projectManager/responseplan/new', ['as' => 'projects.store', 'uses' =>'ProjectController@storeresponse']);

    Route::post('projectManager/task/{id}/delete', ['as' => 'task.delete', 'uses' =>'RiskController@destroy']);
    Route::get('projectManager/task/{id}/subrisks', ['as' => 'task.indexRiskR', 'uses' =>'RiskController@indexSub']);
})  ; 

Route::get('token',function(){
    return csrf_token();
});


