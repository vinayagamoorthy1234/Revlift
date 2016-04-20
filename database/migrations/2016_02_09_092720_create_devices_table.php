<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devices', function (Blueprint $table) {
			$table->string('id', 36);						// UUID
			$table->string('account_id', 36);		// UUID
			$table->string('truck_id', 36);			// UUID
			$table->string('type')->nullable();
			$table->string('serial')->nullable();
			$table->string('tag_number')->nullable();

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
		Schema::drop('devices');
	}
}
