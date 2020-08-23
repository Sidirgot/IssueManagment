<?php

Route::middleware('auth:api')->group(function() {
    
    Route::get('/userInfo', 'Api\Auth\LoggedInUserController@user')->name('logged.in.user');
    
    //Dashboard
    Route::get('/dashboard_information','Api\Team\DashboardController@dashboard' );

    Route::patch('/profile/update/{user}', 'Api\Team\ProfileController@update')->name('profile.update');

    // get all the assigned users projects
    Route::get('/teamProjects', 'Api\ProjectsController@assignedProjects')->name('assignedProjects');

    // anyone thats a part of the given project can see the project.
    Route::get('/projects/{project}', 'Api\ProjectsController@show')->name('projects.show');

    // get all the opened/clsoed issues for the given project.
    Route::get('/issues/opened/{project}', 'Api\IssuesStatusController@opened')->name('issues.opened');
    Route::get('/issues/closed/{project}', 'Api\IssuesStatusController@closed')->name('issues.closed');

    // get the projects issue by id with all the related followups
    Route::get('project/issue/{project}/{issue}', 'Api\ProjectIssueController@getIssue')->name('project.issue.followups');
    // update the issue status
    Route::patch('/issues/{project}/{issue}', 'Api\IssuesStatusController@status')->name('issue.status');
    //  issue followups routes
    Route::get('/followups/{project}/{issue}', 'Api\FollowupsController@index')->name('followups.index');
    Route::post('/followups/{issue}/{project}', 'Api\FollowupsController@store')->name('followups.store');
    Route::patch('/followups/{followup}', 'Api\FollowupsController@update')->name('followups.update');
    Route::delete('/followups/{followup}', 'Api\FollowupsController@destroy')->name('followups.destroy');

    // Project Issues
    Route::resource('/issues', 'Api\Team\ProjectIssuesController')->except(['store']);
    Route::post('/issues/{project}', 'Api\Team\ProjectIssuesController@store')->name('issues.store');
});

Route::middleware(['auth:api', 'role:manager'])->group(function() {
    // project resource routes
    Route::resource('/projects', 'API\Managers\ProjectsController')->except(['show']);

    //Dashboard
    Route::get('/dashborad/information','Api\Managers\DashboardController@dashboard' );

    // add tester / developer to a project
    Route::patch('/add/tester/{project}/{user}', 'API\Managers\ProjectTestersDevelopersController@assignTester')->name('assignTester');
    Route::patch('/add/developer/{project}/{user}', 'API\Managers\ProjectTestersDevelopersController@assignDeveloper')->name('assignDeveloper');
    // remove tester / developer from a project
    Route::patch('/remove/tester/{project}/{user}', 'API\Managers\ProjectTestersDevelopersController@removeTester')->name('removeTester');
    Route::patch('/remove/developer/{project}/{user}', 'API\Managers\ProjectTestersDevelopersController@removeDeveloper')->name('removeDeveloper');
    // update project status
    Route::patch('/status/{project}/{status}', 'API\Managers\ProjectStatusController@handleProjectStatus')->name('project.status');

    // user resource routes
    Route::resource('/users', 'API\Managers\UsersController');
    // get all the unassigned tester
    Route::get('/testers/{project}', 'API\Managers\ProjectTestersDevelopersController@unassignedTesters')->name('unassignedTesters');
    // get all the unassgined developers
    Route::get('/developers/{project}', 'API\Managers\ProjectTestersDevelopersController@unassignedDevelopers')->name('unassignedDevelopers');
});