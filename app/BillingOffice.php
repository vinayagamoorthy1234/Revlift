<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingOffice extends Model
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
    'email',
    'phone',
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
   * Get the customer this office belongs to
   * @return collection
   */
  public function customer()
  {
  	return $this->belongsTo('App\Customer');
  }

  /**
   * Get the rates this office has
   * @return collection
   */
  public function rates()
  {
  	return $this->hasMany('App\Rate');
  }

  /**
   * Get the leases this office has
   * @return collection
   */
  public function leases()
  {
  	return $this->hasMany('App\Lease');
  }

}
