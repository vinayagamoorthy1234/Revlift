<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepotAllocation extends Model
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
    'depot_id',
    'month_year',
    'bbls',
    'bbls_revised',
    'comments',
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
   * Get the depot for the allocation
   * @return collection
   */
  public function depot()
  {
  	return $this->belongsTo('App\Depot');
  }
}
