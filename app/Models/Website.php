<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Website extends Model implements HasMedia
{
    use HasMediaTrait;
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

	public function services()
	{
		return $this->hasMany('App\Models\Service', 'website_id');
	}

    public function template()
    {
        return $this->belongsTo('App\Models\Template', 'template_id');
    }
}
