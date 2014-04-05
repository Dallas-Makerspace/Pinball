<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

App::error(function(){
    Session::flash("global", "There was an error, please contact support");
    return View::make("home.error")
            ->with("title", "There was an error")
            ->with('active', array());
});


Route::get("error", array('as' => 'error', 'uses' => "HomeController@getError"));
    

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@getIndex'));

Route::get('pictures', array('as' => 'pictures', 'uses' => 'HomeController@getPictures'));

Route::get('profile/{username}', array('as' => 'publicProfile', 'uses' => 'HomeController@profilePublic'));

Route::get('getscore/{id}', array('as' => 'getScore', 'uses' => 'HomeController@getScore'));

Route::get('roster', array('as' => 'roster', 'uses' => 'HomeController@getRoster'));

Route::get('pinball', 
        array('as' => 'getMachines', 'uses' => 'HomeController@getMachines'));

Route::get('pinball/{id}', 
        array('as' => 'getMachine', 'uses' => 'HomeController@getMachine'));

Route::group(array('before' => 'auth'), function(){
    
    
    /** Get Routes **/
    

    /** User Routes **/
    Route::get('myprofile', 
            array('as' => 'myprofile', 'uses' => 'UserController@getMyProfile' ));
    
    Route::get('logout', 
            array('as' => 'logout', 'uses' => 'UserController@getLogout'));
    
    /** Record Score **/
    Route::get('record',
            array('as' => 'record' , 'uses' => 'HomeController@getHighScoreForm'));
    
    /*** Admin User Group **/
    
    Route::group(array('prefix' => 'admin'), function(){


                Route::group(array('before'=>'admin'), function(){  
                    
                            
                           Route::get('',
                                    array('as' => 'getAdminPanel', 'uses' => 'AdminController@getAdminPanel'));
                           
                           Route::post('adminResetPassword',
                                   array('as' => 'postAdminResetPassword', 
                                         'uses' => 'AdminController@postAdminResetPassword'));
                           Route::post('adminDisableUser', array('as' => 'postDisableUser', 'uses' => 'AdminController@postDisableEnableUser'));
                           
                           Route::post('postChangeAdminRole', array('as' => 'postChangeAdminRole', 'uses' => 'AdminController@postChangeAdminRole'));
                           
                           Route::get('getmachine/{id}',array('as' => 'getMachineJSON', 'uses' => 
                                      'AdminController@getMachineJson'));
                           
                           Route::get('machineStatus/{id}',
                                   array('as' => 'machineStatus','uses' => 'AdminController@changeStatusMachine'));
                           
                           Route::get('deletescore/{id}',
                                    array('as' => 'deletescore', 'uses' => 'AdminController@deleteScore'));

                });
       
    });
        
    /**  Post Routes **/
     
    Route::group(array('before' => 'csrf'), function(){
        
            Route::put('changepassword',
                    array('as' => 'putChangePassword', 'uses' => 'UserController@putChangePassword'));
            
            Route::put('changeprofile', 
                    array('as' => 'putChangeProfile', 'uses' => 'UserController@putChangeProfile'));
            
            Route::post('record', 
                    array('as' => 'addHighScore', 'uses' => 'HomeController@postHighScoreForm'));
       
            
            Route::group(array('prefix' => 'admin'), function(){

                        Route::group(array('before' => 'admin'), function(){
                            
                            
                            Route::post('adminpostuser',
                                    array('as' => 'adminpostuser', 'uses' => 'AdminController@postUser'));
                        
                           
                            Route::post('adminCreateadminCreateScoreScore',
                                   array('as' => 'adminCreateScore', 'uses' => 'AdminController@adminCreateScore'));

                            
                           Route::post('postmachine',
                                    array('as' => 'postMachine', 'uses' => 'AdminController@postMachine'));

                           Route::post('putmachine',
                                    array('as' => 'putMachine', 'uses' => 'AdminController@putMachine'));

                           
                           Route::post('postscore',
                                    array('as' => 'postscore', 'uses' => 'AdminController@adminCreateScore'));


                           
                            
                        });
                });
         }); 
    });
    
Route::group(array('before' => 'guest'), function(){
    
    /** User Get Function **/
    
    Route::get('forgetpassword',
            array('as' => 'forgetpassword', 'uses' => 'UserController@getForgetPassword'));
    
    Route::get('confirmpasswordreset/{code}/{user_id}',
            array('as' => 'confirmforgetpassword', 'uses' => 'UserController@getConfirmResetPassword'));
    
    Route::get('register', 
            array('as' => 'getCreateUser', 'uses' => 'UserController@getCreateUser'));
    
    Route::get('signin', 
            array('as' => 'getSignIn', 'uses' => 'UserController@getSignIn'));

    
    Route::group(array('before' => 'csrf'), function(){
        
       Route::post('forgetpasswordpost',
               array('as' => 'forgetpasspost', 'uses' => 'UserController@postForgetPassword'));
       
       Route::post('registeruser',
               array('as' => 'registeruser', 'uses' => 'UserController@postRegisterUser'));
       
       Route::post('postsignin',
               array('as' => 'postSignIn', 'uses' => 'UserController@postSignIn'));
       
   
       });
    
}); 




    




