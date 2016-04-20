<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseRate extends Model
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
    'billing_office_id',
    'mileage',
    'base_rate',
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
   * Get the billing office that uses this rate
   * @return collection
   */
  public function billing_office()
  {
  	return $this->belongsTo('App\BillingOffice');
  }
}
