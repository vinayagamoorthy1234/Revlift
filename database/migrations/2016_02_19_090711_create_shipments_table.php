<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('shipments', function (Blueprint $table) {
      $table->string('id', 36);						// GUID
      $table->string('account_id', 36);		// GUID

			$table->integer('ticket_number');
      $table->string('operator_id', 36)->nullable();	// GUID
      $table->string('driver_id', 36)->nullable();		// GUID
      $table->string('truck_id', 36)->nullable();			// GUID
      $table->string('trailer_id', 36)->nullable();		// GUID
      $table->string('lease_id', 36)->nullable();			// GUID
      $table->string('depot_id', 36)->nullable();			// GUID
      $table->string('header_id', 36)->nullable();		// GUID
      $table->string('tank_id', 36)->nullable();			// GUID
      
      $table->string('tmw_or_fob')->nullable();
			$table->timestamp('depot_time_on')->nullable();
			$table->timestamp('depot_time_off')->nullable();
			$table->timestamp('lease_time_on')->nullable();
			$table->timestamp('lease_time_off')->nullable();

			$table->smallInteger('top_feet');
			$table->smallInteger('top_inches');
			$table->smallInteger('top_qtr_inches');
			$table->double('top_bbl');
			$table->smallInteger('bot_feet');
			$table->smallInteger('bot_inches');
			$table->smallInteger('bot_qtr_inches');
			$table->double('bot_bbl');

			$table->integer('obs_temp');
			$table->integer('top_temp');
			$table->integer('bot_temp');
			$table->double('obs_gravity');
			$table->double('bsw');

			$table->tinyInteger('split_load')->nullable();
			$table->tinyInteger('rejected_load')->nullable();

			$table->double('demm_hrs')->nullable();
			$table->string('demm_reason')->nullable();
			$table->double('divert_hrs')->nullable();
			$table->string('divert_reason')->nullable();

			$table->tinyInteger('chain_up')->nullable();
			$table->tinyInteger('masking_up')->nullable();

			$table->text('notes')->nullable();

			$table->timestamp('ticket_date')->nullable();
			$table->timestamp('void_date')->nullable();

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
    Schema::drop('shipments');
  }
}
