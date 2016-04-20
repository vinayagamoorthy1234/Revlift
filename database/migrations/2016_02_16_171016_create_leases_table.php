<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeasesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('leases', function (Blueprint $table) {
      $table->string('id', 36);									// GUID
			$table->string('operator_id', 36);				// GUID
			$table->string('billing_office_id', 36);	// GUID

			$table->string('number');
			$table->string('name');
			$table->string('state');
			$table->string('county');
			$table->string('section')->nullable();
			$table->double('latitude')->nullable();
			$table->double('longitude')->nullable();

			$table->timestamp('created_at')->nullable();
			$table->string('created_by', 36)->nullable();
			$table->timestamp('updated_at')->nullable();
			$table->string('updated_by', 36)->nullable();
			$table->softDeletes();
			$table->string('deleted_by', 36)->nullable();

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
    Schema::drop('leases');
  }
}
