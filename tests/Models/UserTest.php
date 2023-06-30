<?php

namespace Kodeine\Metable\Tests\Models;

use Kodeine\Metable\Metable;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kodeine\Metable\Tests\Casts\UserCastedObject;
use Kodeine\Metable\Tests\Traits\HasUserCasts;

class UserTest extends Model
{
	use Metable;
	use HasUserCasts;
	
	public $defaultMetaValues = [
		'default_meta_key' => 'default_meta_value',
	];
	
	public $hideMeta = false;
	
	public $disableFluentMeta = false;

	protected $casts = [
		'state' => UserCastedObject::class,
	];
	
	/**
	 * This is dummy relation to itself.
	 *
	 * @return HasOne
	 */
	public function dummy(): HasOne {
		return $this->hasOne( static::class, 'user_id', 'id' );
	}
	
	public function getAccessorMeta($value): string {
		return 'accessed_' . $value;
	}
	
	public function setMutatorMeta($value) {
		$this->setMeta( 'mutator', 'mutated_' . $value );
	}
	
	public static function boot() {
		
		static::setEventDispatcher( new Dispatcher() );
		parent::boot();
	}
}