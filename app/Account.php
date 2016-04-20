<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
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
    'name',
    'owner',
    'contact_name',
    'contact_email',
    'contact_phone',
    'address',
    'city',
    'state',
    'zip_code',
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
   * Get all the users for the account
   * @return collection
   */
  public function users()
  {
  	return $this->hasMany('App\User');
  }

	/**
   * Get all the customers for the account
   * @return collection
   */
  public function customers()
  {
  	return $this->hasMany('App\Customer');
  }

	/**
   * Get all the depots for the account
   * @return collection
   */
  public function depots()
  {
  	return $this->hasMany('App\Depot');
  }

	/**
   * Get all the drivers for the account
   * @return collection
   */
  public function drivers()
  {
  	return $this->hasMany('App\Driver');
  }

	/**
   * Get all the shipments for the account
   * @return collection
   */
  public function shipments()
  {
  	return $this->hasMany('App\Shipment');
  }

	/**
   * Get all the trucks for the account
   * @return collection
   */
  public function trucks()
  {
  	return $this->hasMany('App\Truck');
  }

	/**
   * Get all the trailers for the account
   * @return collection
   */
  public function trailers()
  {
  	return $this->hasMany('App\Trailer');
  }

	/**
   * Get all the devices for the account
   * @return collection
   */
  public function devices()
  {
  	return $this->hasMany('App\Device');
  }
}
