<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
  use SoftDeletes, UuidForKey;

	public $incrementing = false;
  
  protected $primaryKey = "id";

  protected $casts = [
  	'id' => 'string',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
		'account_id',
		'ticket_number',
		'operator_id',
		'driver_id',
		'truck_id',
		'trailer_id',
		'lease_id',
		'depot_id',
		'header_id',
		'tank_id',
		'tmw_or_fob',
		'depot_time_on',
		'depot_time_off',
		'lease_time_on',
		'lease_time_off',
		'top_feet',
		'top_inches',
		'top_qtr_inches',
		'top_bbl',
		'bot_feet',
		'bot_inches',
		'bot_qtr_inches',
		'bot_bbl',
		'obs_temp',
		'top_temp',
		'bot_temp',
		'obs_gravity',
		'bsw',
		'sealon',
		'sealoff',
		'split_load',
		'rejected_load',
		'demm_hrs',
		'demm_reason',
		'divert_hrs',
		'divert_reason',
		'chain_up',
		'masking_up',
		'notes',
		'ticket_date',
		'void_date',
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

	/**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  /**
   * Get the account this shipment belongs to
   * @return collection
   */
  public function account()
  {
  	return $this->belongsTo('App\Account');
  }

  /**
   * Get the driver that ran this shipment
   * @return collection
   */
  public function driver()
  {
  	return $this->belongsTo('App\Driver');
  }

  /**
   * Get the operator that this shipment was for
   * @return collection
   */
  public function operator()
  {
  	return $this->belongsTo('App\Operator');
  }

	/**
   * Get the rate that this shipment used
   * @return collection
   */
  public function rate()
  {
  	return $this->belongsTo('App\Rate');
  }

	/**
   * Get the lease that this shipment was taken from
   * @return collection
   */
  public function lease()
  {
  	return $this->belongsTo('App\Lease');
  }

	/**
   * Get the depot that this shipment was taken to
   * @return collection
   */
  public function depot()
  {
  	return $this->belongsTo('App\Depot');
  }

	/**
   * Get the tank that this shipment was applied to
   * @return collection
   */
  public function tank()
  {
  	return $this->belongsTo('App\Tank');
  }

  /**
   * Get the truck that was used for this shipment
   * @return collection
   */
  public function truck()
  {
  	return $this->belongsTo('App\Truck');
  }

  /**
   * Get the trailer that was used for this shipment
   * @return collection
   */
  public function trailer()
  {
  	return $this->belongsTo('App\Trailer');
  }
}
