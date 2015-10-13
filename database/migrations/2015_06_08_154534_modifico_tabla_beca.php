<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificoTablaBeca extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('beca', function(Blueprint $table)
		{
			$table->string('nro_tramite');
			$table->integer('tipo_beca_id');
			$table->integer('alumno_id');
			$table->integer('estado_id');
			$table->string('md5');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('beca', function(Blueprint $table)
		{
			//
		});
	}

}
