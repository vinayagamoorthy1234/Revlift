<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTankStrappingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tank_strappings', function (Blueprint $table) {
			$table->string('id', 36);						// GUID
      $table->string('tank_id', 36);			// GUID

			$table->integer('qtr')->nullable();
			$table->double('rate')->nullable();
			$table->double('rateAbove')->nullable();
			$table->double('cumulative_bbls')->nullable();
			$table->string('source')->nullable();

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
    Schema::drop('tank_strappings');
  }
}
