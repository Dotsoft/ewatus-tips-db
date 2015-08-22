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
  protected $fillable = ['category_id', 'title', 'description'];

  /**
   * Get the tip's title attribute.
   *
   * @param string $value
   * @return array
   */
  public function getTitleAttribute($value)
  {
      return json_decode($value, true);
  }

  /**
   * Set the tip's title attribute.
   *
   * @param array $value
   * @return string
   */
  public function setTitleAttribute($value)
  {
      $this->attributes['title'] = json_encode($value);
  }

  /**
   * Get the tip's description attribute.
   *
   * @param string $value
   * @return array
   */
  public function getDescriptionAttribute($value)
  {
      return json_decode($value, true);
  }

  /**
   * Set the tip's description attribute.
   *
   * @param array $value
   * @return string
   */
  public function setDescriptionAttribute($value)
  {
      $this->attributes['description'] = json_encode($value);
  }
}
