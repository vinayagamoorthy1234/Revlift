<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaseMileage extends Model
{
  use SoftDeletes, UuidForKey;

	public $incrementing = false;
  
  protected $primaryKey = "id";

  protected $casts = [
  	'id' => 'string',
  ];

  protected $table = 'lease_mileage';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'depot_id',
    'lease_id',
    'mileage',
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
   * Get the depot for this mileage
   * @return collection
   */
  public function depot()
  {
  	return $this->belongsTo('App\Depot');
  }

  /**
   * Get the lease for this mileage
   * @return collection
   */
  public function lease()
  {
  	return $this->belongsTo('App\Lease');
  }
}
