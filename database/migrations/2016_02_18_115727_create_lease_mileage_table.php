<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaseMileageTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('lease_mileage', function (Blueprint $table) {
      $table->string('id', 36);						// GUID
      $table->string('depot_id', 36);			// GUID
      $table->string('lease_id', 36);			// GUID

      $table->double('mileage');

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
    Schema::drop('lease_mileage');
  }
}
