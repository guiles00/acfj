<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobbit extends Model {

	//
	 protected $table = 'hobbit';

	 function Comarcas(){
	 	return $this->hasOne('App\Comarca');
	 }
}
