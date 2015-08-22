<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'locales';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['subtag', 'description'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['id'];
}
