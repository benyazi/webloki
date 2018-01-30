<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    'title','slug','content','menu_position', 'website_id'
    ];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	protected $table = 'pages';

	public function website()
	{
		return $this->belongsTo('App\Models\Website', 'website_id');
	}
}
