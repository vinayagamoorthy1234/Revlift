<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
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
    'name',
    'chain_up_fee',
    'chain_up_pay',
    'demm_fee',
    'divert_fee',
    'reject_fee',
    'split_fee',
    'masking_fee',
    'fsc',
    'fsc_fraction',
    'min_bbls',
    'nc_demm_hrs',
    'discount',
    'is_default',
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
  /**
   * Get all the shipments this lease has had
   * @return collection
   */
  public function shipments()
  {
  	return $this->hasMany('App\Shipment');
  }
}
