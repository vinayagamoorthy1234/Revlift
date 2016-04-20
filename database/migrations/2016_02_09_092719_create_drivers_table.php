<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('drivers', function (Blueprint $table) {
			$table->string('id', 36);						// UUID
			$table->string('account_id', 36);		// UUID

			$table->string('firstname');
			$table->string('lastname');
			$table->string('ssnlast4');
			$table->double('rate')->nullable();

			$table->timestamp('created_at')->nullable();
			$table->string('created_by', 36)->nullable(); // UUID
			$table->timestamp('updated_at')->nullable();
			$table->string('updated_by', 36)->nullable(); // UUID
			$table->softDeletes();
			$table->string('deleted_by', 36)->nullable(); // UUID

			$table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('drivers');
	}
}
