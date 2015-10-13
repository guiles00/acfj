<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreoTablaBeca extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beca', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nro_tramite');
			$table->integer('tipo_beca_id');
			$table->integer('alumno_id');
			$table->integer('estado_id');
			$table->string('md5');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('beca');
	}

}
