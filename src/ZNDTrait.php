<?php

namespace Artistan\ZeroNullDates;

use Illuminate\Support\Carbon;

/**
 * Trait ZNDTrait
 * handles "null" date that would throw errors when chaining calls on the null date.
 *
 * @example $model->deleted_at->format('Y-m-d');
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait ZNDTrait
{
	protected $null_all_dates = false;

	protected $nullable_dates = false;

	/**
	 * @param bool $reset - reset the cached list of nullable keys
	 * @return array|bool
	 */
	protected function nullable_dates($reset = false)
	{
		if ($this->nullable_dates === false || $reset) {
			$this->nullable_dates = array_merge((self::$zero_date ?? []), (self::$zero_datetime ?? []),
				$this->null_all_dates ? $this->dates : [], (self::$nullable ?? []));
		}

		return $this->nullable_dates;
	}

	/**
	 * @param $column
	 * @return bool
	 */
	protected function is_nullable($column)
	{
		if (in_array($column, $this->nullable_dates())) {
			return true;
		}

		return false;
	}

	/**
	 * Return a timestamp as ZNDTrait (DateTime) object.
	 *
	 * @param  string $key
	 * @return \Illuminate\Support\Carbon
	 */
	public function getAttribute($key)
	{
		$value = parent::getAttribute($key);
		// if attribute is null and it is a nullable, we want a ZNDCarbon
		// then there is no need to check for if it is a date object or not!
		if (is_null($value) && $this->is_nullable($key)) {
			return new ZNDCarbon();
		}

		return $value;
	}

	/**
	 * Set a given attribute on the model.
	 * return a ZNDCarbon instance for null dates.
	 *
	 * @param  string $key
	 * @param  mixed $value
	 * @return mixed
	 */
	public function setAttribute($key, $value)
	{
		// if nullable and empty (zero || null)...
		if ($this->is_nullable($key) and empty($value)) {
			// set to a nullable carbon date if it is a nullable attribute
			$value = new ZNDCarbon($value);
		}
		
		return parent::setAttribute($key, $value);
	}

	/**
	 * Return a timestamp as ZNDTrait (DateTime) object.
	 *
	 * @param  mixed $value
	 * @return ZNDCarbon
	 */
	protected function asDateTime($value)
	{
		if (ZNDCarbon::date_value_is_empty($value)) {
			return new ZNDCarbon();
		}

		if ($value instanceof ZNDCarbon) {
			return $value;
		}

		$instance = parent::asDateTime($value);
		if ($instance instanceof Carbon) {
			$instance = new ZNDCarbon($instance);

			return $instance;
		}

		return new ZNDCarbon();
	}

	/**
	 * Cast an attribute to a native PHP type.
	 * check for date types and return a nullable ZNDCarbon object
	 *
	 * @param  string $key
	 * @param  mixed $value
	 * @return mixed
	 */
	protected function castAttribute($key, $value)
	{
		$type = $this->getCastType($key);

		switch ($type) {
			case 'date':
			case 'datetime':
			case 'custom_datetime':
			case 'timestamp':
				if (ZNDCarbon::date_value_is_empty($value)) {
					// castAttribute returns null values, but we want a ZNDCarbon date object
					return null;
				}
		}

		return parent::castAttribute($key, $value);
	}

	/**
	 * Get an attribute array of all arrayable attributes.
	 * NOTE: this does NOT change the underlying attributes, just returns formatted array
	 *
	 * @return array
	 */
	protected function getArrayableAttributes()
	{
		$fix_dates = array_intersect_key($this->attributes, array_flip($this->nullable_dates()));
		$copy = $this->attributes;
		array_walk($fix_dates, function ($key) use ($copy) {
			$copy[$key] = null;
		});

		return $this->getArrayableItems($copy);
	}
}
