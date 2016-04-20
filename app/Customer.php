<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
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
    'name',
    'abbrev',
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
   * Get the account this customer belongs to
   * @return collection
   */
  public function account()
  {
  	return $this->belongsTo('App\Account');
  }

  /**
   * Get all the operators for the customer
   * @return collection
   */
  public function operators()
  {
  	return $this->hasMany('App\Operator');
  }

  /**
   * Get all the billing offices for the customer
   * @return collection
   */
  public function billing_offices()
  {
  	return $this->hasMany('App\BillingOffice');
  }

}
