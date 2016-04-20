<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->string('id', 36);						// UUID
			$table->string('account_id', 36);		// UUID
			
			$table->string('firstname');
			$table->string('lastname');
			$table->string('username');
			$table->string('password');
			$table->string('email');
			$table->string('phone')->nullable();
			$table->text('description')->nullable();
			$table->string('role');
			
			$table->rememberToken();
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
		Schema::drop('users');
	}
}
