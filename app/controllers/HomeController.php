<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
    
        

	public function getIndex()
        {
            try
            {
                $allScores = Scores::orderBy('created_at', 'desc')->get();
            $highscore = array();
            foreach($allScores as $score):
                $highscore[] = array(
                    'username' => $score->user->username, 
                    'machine_name' => $score->machine->name,
                    'machine_id' => $score->machine->id,
                    'id' => $score->id,
                    'datecreated' => date("n/j/Y g:i A", strtotime($score->created_at)),
                    'score' => $score->score
                    );
            endforeach;
            return View::make('home.getIndex')
                    ->with('title', 'Home Page')
                    ->with('active', array('home'))
                    ->with('highscore', $highscore);
            } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
            
        }
        
        public function getPictures()
        {
            try
            {
            $pictures = array();
            $scores = Scores::all();
            $machinePicList = Mpictures::all();
            foreach($machinePicList as $mpic):
                $pictures[] = array('title' => "Pinball Machine : " . $mpic->machine->name, 'pic' => '/web/images/pinball/' . $mpic->pic_url );
            endforeach;
            
            foreach($scores as $score):
              $pictures[] = 
                        array('title' => $score->user->username . ' score : ' . $score->score . ' on machine : ' . $score->machine->name,
                                'pic' => 'web/images/highscore/'. $score->picture_url);
            endforeach;
            
            return View::make('home.getPictures')
                    ->with('title', 'Pinball Roster')
                    ->with('active', array('pictures'))
                    ->with('picList', $pictures);
            } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
        }
        
        public function profilePublic($username)
        {
            try
            {
            $mainstats = DB::table('users')
                            ->addSelect((DB::raw('MAX(scores.score) max_score')))
                            ->addSelect((DB::raw('AVG(scores.score) avg_score')))
                            ->addSelect((DB::raw('SUM(scores.score) total_score')))
                            ->addSelect((DB::raw('COUNT(*) num_games')))
                            ->join('scores', 'users.id', '=', 'scores.user_id')
                            ->where('username', '=', $username)
                            ->get();
            
            $userInfo = User::where('username' , '=', $username)->get()->first();
            $scoreTable = array();
            $machinePictures = array();
            foreach($userInfo->scores as $score):
                $scoreTable[] = array(
                                      'score' => $score->score, 
                                      'date' => date("n/j/Y g:mm A", strtotime($score->created_at)),
                                      'machine' => $score->machine->name,
                                      'machine_id' => $score->machine->id
                                     );
                $machinePictures[] = array('image' => '/web/images/highscore/'. $score->picture_url,
                                           'title' => "Scored : " . $score->score . " <br /> Machine : " . $score->machine->name);                    
            endforeach;
           
            
            
            
            
            return View::make('home.profilepublic')
                    ->with('title', 'Username : ' . $username)
                    ->with('username', $username)
                    ->with('mainstats', $mainstats[0])
                    ->with('table', $scoreTable)
                    ->with('pics', $machinePictures)
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
        
        public function getRoster()
        {
            $mvp_table = DB::table('scores')
                        ->select((DB::raw('MAX(score) max_score')))
                        ->addSelect((DB::raw('AVG(score) avg_score')))
                        ->addSelect((DB::raw('users.username')))
                        ->join('users', 'users.id', '=', 'scores.user_id')
                        ->groupBy('user_id')
                        ->get();
             
            return View::make('home.getRoster')
                    ->with('title', 'Pinball Roster')
                    ->with('active', array('roster'))
                    ->with('mvp_table', $mvp_table);

        }
        
        public function getHighScoreForm()
        {
            try
            {
            $machines = Machines::all();
            $machineList = array();
            foreach($machines as $machine):
                $machineList[$machine->id] = $machine->name;
            endforeach;
            
            return View::make('home.getRecordScore')
                    ->with('title', 'Record Score')
                    ->with('machines', $machineList)
                    ->with('active', array('record'));
            } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
            
        }
        
        public function getMachines()
        {
            try
            {
            $machines = Machines::all();
            
            $info = array();
            foreach($machines as $machine):
               $info[] = array('pic' => '/web/images/pinball/'. $machines->first()->pictures[0]->pic_url, 'name' => $machine->name, 'id' => $machine->id);
            endforeach;
              return View::make('home.getMachines')
                    ->with('title', 'Pinball Machines')
                    ->with("machines", $info)
                    ->with('active', array('pinballs'));
              } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
        }
        
        public function postHighScoreForm()
        {
            try
            {
            $rules = array(
                'score' => 'required|max:1000000|min:100|numeric',
                'machine' => 'required',
                'time' => 'required',                
            );
            
            if(Input::get('picType') == "Upload"):
                     $rules['picture'] = 'mimes:jpeg,gif,png|required';

            else:
                   $rules['base64_img'] = 'required';

            endif;
                    
            
            $validator = Validator::make(Input::all(), $rules);
            if($validator->passes()):
                if(Input::get('picType') == "Upload"):
                   $file = Input::file('picture');     
                  
                   $ext = $file->getMimeType();
                   $filename = md5(date('U')) . $this->mimeToExt($ext);
                   $file->move(public_path() . "/web/images/highscore/" , $filename);
                 
                    else:
                        
                       $filename = md5(date('U')) .'.png';
                       file_put_contents(public_path() . "/web/images/highscore/" . $filename ,base64_decode(str_replace("data:image/png;base64,", "",Input::get('base64_img'))));
                
                endif;
                
                $score = new Scores();
                $score->picture_url = $filename;
                $score->score = Input::get('score');
                $score->machine_id = Input::get('machine');
                $score->user_id = Auth::getUser()->id;
                
                if($score->save()):
                    return Redirect::route('home')->with('global', "You have successfully submit your score");
                endif;
                
            endif;
            
           
            return Redirect::route('addHighScore')
                    ->with("score_errors","There was an error in submitting your score.")->withInput()->withErrors($validator);
            } 
            catch (Exception $ex) 
            {
                Session::flash("global", "Please report this messeage: " . $ex->getMessage());
                return View::make("home.error")
                        ->with("title", "There was an error")
                        ->with('active', array());
            }
        }
        
        
        public function getMachine($id)
        {
            try
            {
            $mainstats = DB::table('machines')
                            ->addSelect((DB::raw('MAX(scores.score) max_score')))
                            ->addSelect((DB::raw('AVG(scores.score) avg_score')))
                            ->addSelect((DB::raw('SUM(scores.score) total_score')))
                            ->addSelect((DB::raw('COUNT(*) num_games')))
                            ->join('scores', 'machines.id', '=', 'scores.machine_id')
                            ->where('machines.id', '=', $id)
                            ->get();
            
           $machine_scores = DB::select(DB::raw("SELECT users.username, MAX( scores.score ) max_score, DATE_FORMAT( scores.created_at, '%c/%e/%Y %h: %i %p' ) datecreated
                                                FROM scores
                                                INNER JOIN users ON users.id = scores.user_id
                                                Where scores.machine_id = :machine_id 
                                                GROUP BY users.id
                                                ORDER BY scores.score DESC "), array('machine_id' => $id));
            
            
            $machine = Machines::where('id', '=', $id)->get()->first();
            $pics = array();
            foreach($machine->pictures as $pic):
                $pics[] = array('image' => '/web/images/pinball/'. $pic->pic_url, 'title' => $machine->name);
            endforeach;
            
            return View::make('home.getMachine')
                    ->with('title', 'Pinball Machines')
                    ->with('machine_name', $machine->name)
                    ->with('pics', $pics)
                    ->with("score_table", $machine_scores)
                    ->with('mainstats', $mainstats[0])
                    ->with('machine_description', $machine->description)
                    ->with('active', array(''));
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