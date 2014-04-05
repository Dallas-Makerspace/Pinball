<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Scores
 *
 * @author noah
 */

class Scores extends Eloquent{
    //put your code here
    
    protected $table = 'scores';
    
    public function user()
    {
      return  $this->belongsTo('User', 'user_id');
    }
    
    public function machine()
    {
       return $this->belongsTo('Machines', 'machine_id');
    }
}
