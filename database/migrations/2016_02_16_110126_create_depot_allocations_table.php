<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepotAllocationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('depot_allocations', function (Blueprint $table) {
      $table->string('id', 36);						// GUID
      $table->string('depot_id', 36);		// GUID

      $table->integer('bbls')->default('0');
      $table->integer('bbls_revised')->default('0');
      $table->timestamp('month_year')->nullable();
      $table->text('comments')->nullable();

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
    Schema::drop('depot_allocations');
  }
}
