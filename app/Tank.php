<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tank extends Model
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
    'lease_id',
    'number',
    'size',
    'bbls_per_inch',
    'source',
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
   * Get the lease for this tank
   * @return collection
   */
  public function lease()
  {
  	return $this->belongsTo('App\Lease');
  }

  /**
   * Get the strappings for this tank
   * @return collection
   */
  public function strappings()
  {
  	return $this->hasMany('App\TankStrapping');
  }

  /**
   * Get the shipments this tank has had
   * @return collection
   */
  public function shipments()
  {
  	return $this->hasMany('App\Shipment');
  }
}
