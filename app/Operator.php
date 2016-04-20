<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
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
    'customer_id',
    'name',
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
   * Get the customer for the operator
   * @return collection
   */
  public function customer()
  {
  	return $this->belongsTo('App\Customer');
  }

  /**
   * Get the leases this operator owns
   * @return collection
   */
  public function leases()
  {
  	return $this->hasMany('App\Lease');
  }

  /**
   * Get the shipments this operator has had
   * @return collection
   */
  public function shipments()
  {
  	return $this->hasMany('App\Shipment');
  }
}
