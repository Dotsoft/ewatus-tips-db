<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'categories';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['parent_id', 'title', 'description'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['tips'];

  /**
   * The attributes to be appended.
   *
   * @var array
   */
  protected $appends = array('tips_count');

  public function parent()
  {
      return $this->belongsTo('App\Category', 'parent_id');
  }

  public function children()
  {
      return $this->hasMany('App\Category', 'parent_id');
  }

  public function tips()
  {
      return $this->hasMany('App\Tip', 'category_id');
  }

  public function getTipsCountAttribute()
  {
      return $this->tips->count();
  }

  /**
   * Get the category's title attribute.
   *
   * @param string $value
   * @return array
   */
  public function getTitleAttribute($value)
  {
      return json_decode($value, true);
  }

  /**
   * Set the category's title attribute.
   *
   * @param array $value
   * @return string
   */
  public function setTitleAttribute($value)
  {
      $this->attributes['title'] = json_encode($value);
  }

  /**
   * Get the category's description attribute.
   *
   * @param string $value
   * @return array
   */
  public function getDescriptionAttribute($value)
  {
      return json_decode($value, true);
  }

  /**
   * Set the category's description attribute.
   *
   * @param array $value
   * @return string
   */
  public function setDescriptionAttribute($value)
  {
      $this->attributes['description'] = json_encode($value);
  }

}
