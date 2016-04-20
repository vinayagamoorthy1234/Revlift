<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('rates', function (Blueprint $table) {
      $table->string('id', 36);						// GUID
      $table->string('billing_office_id', 36);	// GUID

      $table->string('name', 255)->nullable();
			$table->decimal('chain_up_fee', 19,4)->nullable();
			$table->decimal('chain_up_pay', 19,4)->nullable();
			$table->decimal('demm_fee', 19,4)->nullable();
			$table->decimal('divert_fee', 19,4)->nullable();
			$table->decimal('reject_fee', 19,4)->nullable();
			$table->decimal('split_fee', 19,4)->nullable();
			$table->decimal('masking_fee', 19,4)->nullable();
			$table->string('fsc_formula')->nullable();
			$table->double('min_bbls')->nullable();
			$table->double('nc_demm_hrs')->nullable();
      $table->double('discount')->nullable();
      $table->boolean('is_default')->nullable();

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
    Schema::drop('rates');
  }
}
