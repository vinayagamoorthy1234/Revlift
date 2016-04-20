<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
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
    'id',
    'account_id',
    'truck_id',
    'type',
    'serial',
    'tag_number',
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [
    ''
  ];

	/**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  /**
   * Get the account for the device
   * @return collection
   */
  public function account()
  {
  	return $this->belongsTo('App\Account');
  }

  /**
   * Get the truck the device is assigned to
   * @return collection
   */
  public function truck()
  {
  	return $this->belongsTo('App\Truck');
  }
}
