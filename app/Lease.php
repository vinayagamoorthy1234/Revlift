<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lease extends Model
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
    'operator_id',
    'number',
    'name',
    'state',
    'county',
    'latitude',
    'longitude',
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
   * Get the operator that owns this lease
   * @return collection
   */
  public function operator()
  {
  	return $this->belongsTo('App\Operator');
  }

  /**
   * Get the billing office that this lease is under
   * @return collection
   */
  public function billing_office()
  {
  	return $this->belongsTo('App\BillingOffice');
  }

  /**
   * Get all the mileages to the depots
   * @return collection
   */
  public function mileages()
  {
  	return $this->hasMany('App\LeaseMileage');
  }

  /**
   * Get all the tanks for this lease
   * @return collection
   */
  public function tanks()
  {
  	return $this->hasMany('App\Tank');
  }

  /**
   * Get all the shipments this lease has had
   * @return collection
   */
  public function shipments()
  {
  	return $this->hasMany('App\Shipment');
  }
}
