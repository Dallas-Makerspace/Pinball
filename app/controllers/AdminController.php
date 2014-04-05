<?php


/**
 * Description of AdminController
 *
 * @author noah
 */
class AdminController extends BaseController
{

    
    public function getAdminPanel()
    {
        try
        {
       
        $users = User::all()->toArray();
        $scores = Scores::all();
        $scoreTable = array();
        foreach($scores as $score):
            $scored = array();
            $scored['id'] = $score->id;
            $scored['score'] = $score->score;
            $scored['datecreated'] = date("n/j/Y g:i A", strtotime($score->created_at));
            $scored['machine_name'] = $score->machine->name;
            $scored['username'] = $score->user->username;
            $scoreTable[] = $scored;
        endforeach;
        $machines = Machines::all()->toArray();
        $selectUser = array();
        foreach($users as $user):
            $selectUser[$user['id']] = $user['username'];
        endforeach;
        $selectMachine = array();
        foreach($machines as $machine):
            $selectMachine[$machine['id']] = $machine['name'];
        endforeach;
        $machines = Machines::all()->toArray();
        return View::make('adminlayout.index')
                ->with('title', 'Admin Panel')
                ->with('usertable', $users)
                ->with('machines',$machines)
                ->with('scores', $scoreTable)
                ->with('selectMachine', $selectMachine)
                ->with('addSelection', $selectUser);
        } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
    }
    public function postDisableEnableUser()
    {
        try
        {
        $validator = Validator::make(Input::all(), array('id' => 'required|numeric'));
        if($validator->passes()):
            $user = User::where('id', '=', Input::get('id'))->get();
            $user = $user->first();
            $user->enabled = ($user->enabled == true)? false : true;
            if($user->save()):
                 return Response::json(array('success' => true, 'enabled' => $user->enabled));
            endif;

        endif;
        } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }
       

    }
    
    public function postChangeAdminRole()
    {
        try
        {
        $validator = Validator::make(Input::all(), array('id' => 'required|numeric'));
        if($validator->passes()):
            $user = User::where('id', '=', Input::get('id'))->get();
            $user = $user->first();
            Log::info(Input::get('id'));
            Log::info(print_r($user->toArray(), true));
            $user->isAdmin = ($user->isAdmin == true)? false : true;
            if($user->save()):
                 return Response::json(array('success' => true, 'isAdmin' => $user->isAdmin));
            endif;

        endif;
        
        return Response::json(array('success' => false));
        } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }
    }


    
    
    public function postAdminResetPassword()
    {
        try
        {
        $validator = Validator::make(Input::all(), array('id' => 'required|numeric'));
        
        if($validator->passes()):
            $user = User::where('id', '=', Input::get('id'))->get();
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
                        return Response::json(array('success' => true));
                    endif;
                    
                endif;
            endif;
            
        endif;
        
        return Response::json(array('success' => false));
         } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }

    }
    
    public function postUser()
    {
        try
        {
        $validator = Validator::make(Input::all(),
                array(
                    'username' => 'required|min:4|unique:users',
                    'email' =>  'required|email|min:4|unique:users'
                    )
                );
             
             
        
        if($validator->passes()):
            
             $password = str_random(10);
             $user = new User();
             $user->username = Input::get('username');
             $user->email = Input::get('email');
             $user->password = Hash::make($password);
             $user->isAdmin = false;
             $user->created_at = date('Y-m-d H:m:s');
             $user->updated_at = date('Y-m-d H:m:s');
             $user->enabled = true;
             if($user->save()):
                 
                 Mail::send('emails.adminregister', array('username' => $user->username, 'password' => $password), function($message) use($user)
                {
                    $message->to($user->email, 'Awesome Pinball Player')->subject('Welcome to pinball highscore website!');
                });
                 
                 return Response::json(array('error' => "0", 'user' => $user->toArray() ));
             endif;
             
            else:
            
            return Response::json(array('error' => "1", 'errorMessages' => $validator->errors()->toArray()));
            
        endif;
        
        return Response::json(array('error' => "1", 'errorMessages' => 'There was emailing or inserting user into database, please contact support.'));
 } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }
    }
    
    

    
    public function postMachine()
    {
        try
        {
            $validator = Validator::make(Input::all(), array(
               'picture' => 'required|mimes:jpeg,gif,png',
               'name' => 'required|max:255',
               'description' => 'required'));
         
            Log::info(print_r(Input::all(), true));

        if($validator->passes() ):
           $machine = new Machines();
           $machine->name = Input::get('name');
           $machine->description = Input::get('description');
           $machine->isActive = true;
           if($machine->save()):
               $files = Input::file('picture');
               $counter = 1;
               
               foreach($files as $file):
                   $ext = $file->getMimeType();
                   $filename = md5($machine->id . "_" . $counter ) . $this->mimeToExt($ext);
                   $info = $file->move(public_path() . "/web/images/pinball/" , $filename);
                   $counter += 1;
                   $pmachine = new Mpictures();
                   $pmachine->machine_id = $machine->id;
                   $pmachine->pic_url = $filename;
                   
                   if(!$pmachine->save()):
                       throw new Exception("Error inserting picture information into the database.");
                   endif;

                   
               endforeach;
               
                  return Response::json(array('success' => true, 'machine' => $machine->toArray() ));

           endif;
        endif;
        
        $errors = $validator->errors()->toArray();
              
        $errors['picture'] = str_replace("[]", "", $errors['picture[]']);
        unset($errors['picture[]']);
                              
        return Response::json(array('success' => false, 'errors' => $errors));
         } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }
        

    }
    
    public function getMachineJson($id)
    {
        try
        {
        $machine = Machines::where('id', '=', $id)->get()->first();
        
        return Response::json($machine->toArray());
         } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }
    }
    
    public function putMachine()
    {
        try
        {
                $validator = Validator::make(Input::all(), 
                array('machine_id' => 'required|numeric', 'name' => 'required', 'description' => 'required'));
                if($validator->passes()):

                    $machine = Machines::where('id', '=', Input::get('machine_id'))->get()->first();
                    if($machine != null):
                        $machine->name = Input::get('name');
                        $machine->description = Input::get('description');
                        if($machine->save()):                            
                            if(Input::hasFile('picture')):

                             $picsToDelete =  Mpictures::where('machine_id', '=', $machine->id);
                             Log::info(print_r($picsToDelete, true));
                             foreach($picsToDelete as $pic):
                                 unlink( public_path() . "/web/images/pinball/" . $pic->pic_url);
                             endforeach;   

                             $picsToDelete->delete();
                             $counter = 0;
                                $files = Input::get('picture');
                                foreach($files as $file):
                                    
                                    $ext = $file->getMimeType();
                                    $filename = md5($machine->id . "_" . $counter ) . $this->mimeToExt($ext);
                                    $info = $file->move(public_path() . "/web/images/pinball/" , $filename);
                                    $counter += 1;
                                    $pmachine = new Mpictures();
                                    $pmachine->machine_id = $machine->id;
                                    $pmachine->pic_url = $filename;

                                    if(!$pmachine->save()):
                                        throw new Exception("Error inserting picture information into the database.");
                                    endif;                   
                                
                                endforeach;


                            endif;
                                return Response::json(array('success' => true, 'machine' => $machine->toArray() ));
                        endif;
                    endif;

                endif;
        
                return Response::json(array('success' => false, 'errors' => $validator->errors()->toArray()));

         } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }
      
    }
   
    public function changeStatusMachine($id)
    {
        try
        {
        $machine = Machines::where('id', '=', $id)->firstOrFail();
        $machine->isActive = ($machine->isActive == true) ? false : true;
        if($machine->save()):
            return Response::json(array('success' => true, 'isActive' => $machine->isActive));
        endif;
        
        return Response::json(array('success' => false));
        } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }
        
    }
    
    
    public function adminCreateScore()
    {
        try
        {
        $validator = Validator::make(Input::all(), 
                array(
                    'username' => 'required|numeric',
                    'score' => 'required|numeric',
                    'time' => 'required',
                    'picture' => 'required|mimes:jpeg,gif,png',
                    'machine' => 'required|numeric'
                    ));
        if($validator->passes()):
         
             $file = Input::file('picture');
             $ext = $file->getMimeType();
             $filename =  md5(date('U')) . $this->mimeToExt($ext);
             $file->move(public_path() . "/web/images/highscore/" , $filename);
             $score = new Scores();
             $score->user_id = Input::get('username');
             $score->machine_id = Input::get('machine');
             $score->created_at = strtotime(Input::get('time'));
             $score->picture_url = $filename;
             $score->score = Input::get('score');
             $scoreArray = $score->toArray();
             $scoreArray['username'] = $score->user->username;
             $scoreArray['machinename'] = $score->machine->name;
             if($score->save() === true):
                 $scoreTurnToArray = $score->toArray();
                 Log::info(print_r($scoreTurnToArray, true));
                 $scoreArray['datecreated'] = date('n/j/Y g:i A', strtotime($score->created_at));
                 $scoreArray['id'] = $scoreTurnToArray['id'];

                 return Response::json(array('success' => true, 'score' => $scoreArray));
             endif;
        endif;
                        
        return Response::json(array('success' => false, 'errors' => $validator->errors()->toArray()));
        } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }

    }
    
    
    
    
    
    public function deleteScore($id)
    {
        try
        {
        $score = Scores::where('id', '=', $id)->get();
        $firstScore = $score->first();
        if($firstScore != null):
            unlink(public_path() . "/web/images/highscore/" . $firstScore->picture_url);
            $firstScore->delete();
        endif;
        return Response::json( array('success' => true, 'deleteId' => $id));
        } 
        catch (Exception $ex) 
        {
             return Response::json(array('success' => false, 'errorsbad' => $ex->getMessage()));
        }
    }
    
  
}
