<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author noah
 */
class UserController extends BaseController
{

    
    public function getLogout()
    {
        try
        {
        Auth::logout();	
        return Redirect::route('home');   
        } 
        catch (Exception $ex) 
        {
            Session::flash("global", "Please report this messeage: " . $ex->getMessage());
            return View::make("home.error")
                    ->with("title", "There was an error")
                    ->with('active', array());
        }
        
    }
    
    public function getForgetPassword()
    {
        try
        {
        return View::make('users.getForgetPassword')
                ->with('title', 'Forget Password')
                ->with('active', array());
        } 
        catch (Exception $ex) 
        {
            Session::flash("global", "Please report this messeage: " . $ex->getMessage());
            return View::make("home.error")
                    ->with("title", "There was an error")
                    ->with('active', array());
        }
    }
    
    public function getConfirmResetPassword($code, $user_id)
    {
        try
        {
       $userList = User::where('code' ,'=', $code)
                ->where('id', '=', $user_id)
                ->get();
       $user = $userList->first();
       if($user != null):
           
           $user->password = $user->temp_password;
           $user->temp_password = "";
           $user->code = "";
           if($user->save()):
                       return Redirect::route('home')->with('global', "Your password has been reset.");
           endif;
                      
       endif;
        
       return Redirect::route('home')->with('global', "There was an error in trying to reset the password.");
       } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
    }
    
    public function getCreateUser()
    {
        try
        {
        return View::make('users.getCreateUser')->
                with('title', 'Register')->
                with('active', array('getCreateUser'));
        } 
        catch (Exception $ex) 
        {
            Session::flash("global", "Please report this messeage: " . $ex->getMessage());
            return View::make("home.error")
                    ->with("title", "There was an error")
                    ->with('active', array());
        }
    }
    
   
    public function postSignIn()
    {
        try
        {
        $rules = array(
            'username' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        
        if($validator->passes()):
            
           $users = User::orWhere('username', '=', Input::get('username'))
                    ->orWhere("email","=", Input::get('username'))
                    ->get();
           

                if($users->count() === 1):

                    $currentUser = $users->first();
                    if($currentUser->enabled == true):
                        
                        

                        $isAuth = Auth::attempt(array(
                                    'username' => $currentUser->username, 
                                    'password' => Input::get('password')
                                ));
                    Log::info($isAuth);
                            if($isAuth === true):
                                  return Redirect::intended('/');
                            endif;
                    endif;
                endif;
            
            else:
            return Redirect::route('getSignIn')->withInput()->withErrors($validator);
              
        endif;
        
      return Redirect::route('getSignIn')->with('signinerror', true);
      } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
 
    }
    
    
    
    public function postForgetPassword()
    {
        try
        {
         $rules = array('email' => 'email|max:100|min:5|required');
         $validator =  Validator::make(Input::all(), $rules);
         if($validator->passes()):
            $user = User::where('email', '=', Input::get('email'))->get();
            $user = $user->first();
            if($user != null):
            $password = str_random(8);
            $code = str_random(60);
            
            $user->temp_password = Hash::make($password);
            $user->code = $code;
            if($user->save()):
                
                    $mail =  Mail::send('emails.resetpassword', array('code' => $code, 'password' => $password, 'user_id' => $user->id), function($message) use($user)
                     {
                         $message->to($user->email, 'Password Reset')->subject('Password Reset');
                     });
                
                    if($mail == true):
                        return  Redirect::route('home')->with('global', 'Your password has been sent to your email.');
                    endif;
                    
                endif;
            endif;
        endif;
        
       return  Redirect::route('forgetpassword')->withErrors($validator)->withInput();
} 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
    }
    
    public function getSignIn()
    {
        try
        {
       return   View::make('users.getSignIn')->
                with('title', 'Sign In')->
                with('active', array('getSignIn'));
       } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }

    }
    
    public function postRegisterUser()
    {
        try
        {
        $rules = array(
            'email' => 'email|unique:users|max:100|min:5|required',
            'username' => 'max:30|min:4|unique:users|alpha_num|required',
            'password' => 'min:6|max:20|required',
            'confirm_password' => 'same:password|required'
        );
        
        $validator =  Validator::make(Input::all(), $rules);
        if($validator->passes()):
            
             $user = array();
             $user['username'] = Input::get('username');
             $user['email'] = Input::get('email');
             $user['password'] = Hash::make(Input::get('password'));
             $user['isAdmin'] = false;
             $user['created_at'] = date('Y-m-d H:m:s');
             $user['updated_at'] = date('Y-m-d H:m:s');
             $user['enabled'] = true;
             User::insert($user);
            
            
              return  Redirect::route('home')->with('global', 'You have successfully registered.');
            
       endif;

            
              return  Redirect::route('getCreateUser')->withErrors($validator)->withInput();
              } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
            
    }
    
    
    
    
    
    
    
    
}
