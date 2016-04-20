<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depot extends Model
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
    'code',
    'name',
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
   * Get the account this depot belongs to
   * @return collection
   */
  public function account()
  {
  	return $this->belongsTo('App\Account');
  }

  /**
   * Get the headers for the depot
   * @return collection
   */
  public function headers()
  {
  	return $this->hasMany('App\DepotHeader');
  }

  /**
   * Get the allocations for the depot
   * @return collection
   */
  public function allocations()
  {
  	return $this->hasMany('App\DepotAllocation');
  }

  /**
   * Get all the milages to the leases
   * @return collection
   */
  public function mileages()
  {
  	return $this->hasMany('App\LeaseMileage');
  }
}
