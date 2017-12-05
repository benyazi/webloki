<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'domain',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	protected $table = 'websites';

	public function pages()
	{
		return $this->hasMany('App\Models\Page', 'website_id');
	}
}
