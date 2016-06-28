<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoCheque extends Model {

	//
	protected $table = 'pago_cheque';
	protected $primaryKey = 'pago_cheque_id';
	public $timestamps = false;
	
}
