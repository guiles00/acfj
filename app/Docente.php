<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model {

	//
	protected $table = 'docente';
	protected $primaryKey = 'doc_id';
	public $timestamps = false;
	
}
