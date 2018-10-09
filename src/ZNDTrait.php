<?php

namespace Artistan\ZeroNullDates;

/**
 * Trait ZNDTrait
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait ZNDTrait {

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        // if a zero date column, then set to zero date if null or empty or whatever
        // if column is nullable, we suggest you do not set it as a zero_date column.
        if (in_array($key, self::$zero_date) && empty($value)) {
            $value = '0000-00-00';
        } else {
            if (in_array($key, array_merge($this->dates,self::$nullable))) {
                // ELSE we assume that any other date is nullable if empty or setting as zero date.
                if(empty($value) || in_array($value,
                        ['0000-00-00', '0000-00-00 00:00:00'])) {
                    $value = null;
                }
            }
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * @param string $key
     * @return array|mixed
     */
    public function getAttribute($key)
    {
        if (! empty($this->attributes[$key]) && in_array($this->attributes[$key],
                ['0000-00-00', '0000-00-00 00:00:00'])) {
            return null;
        }

		// handle date attributes that are still empty (new model)...
		if (empty($this->attributes[$key]) && in_array($key, array_merge($this->dates))) {
			return null;
		}

        return parent::getAttribute($key);
    }

    /**
     * Get an attribute array of all arrayable attributes.
     * NOTE: this does NOT change the underlying attributes, just returns formatted array
     *
     * @return array
     */
    protected function getArrayableAttributes()
    {
        $fix_dates = array_intersect($this->attributes, ['0000-00-00', '0000-00-00 00:00:00']);
        array_walk($fix_dates, function (&$item1) {
            $item1 = null;
        });

        return $this->getArrayableItems(array_merge($this->attributes, $fix_dates));
    }
}