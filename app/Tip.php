<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'tips';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['category_id', 'user_id', 'title', 'description'];
}
