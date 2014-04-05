<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Machines
 *
 * @author noah
 */
class Machines extends Eloquent{
    //put your code here
    
    public $table = "machines";
    
    public function pictures()
    {
       return $this->hasMany('Mpictures', "machine_id");
    }
    
   
}
