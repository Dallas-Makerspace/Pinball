<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of machine_pictures
 *
 * @author noah
 */
class Mpictures extends Eloquent 
{
    public $table = "mpictures";
    
    public function machine()
    {
        return $this->belongsTo('Machines', 'machine_id');
    }
}
