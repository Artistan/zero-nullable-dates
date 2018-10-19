<?php

namespace Artistan\ZeroNullDates\Tests\Database;

use Illuminate\Support\Str;

/**
 * Class User
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\
 */
trait DynamicModelMethods
{


    /**
     * add a mutator to the key
     *
     * @param $key
     */
    public function key_mutator($key)
    {
        $key = Str::studly($key);
        $method = "get{$key}AttributExample";
        $this->{$method} = function ($value) {
            return "DATE: {$value}";
        };
    }

    /**
     * add a casting to the key
     *
     * @param $key
     */
    public function key_casting($key)
    {
        $this->casts[] = $key;
    }

    /**
     * add the date mutation to the key
     *
     * @param $key
     */
    public function key_dates($key)
    {
        $this->dates[] = $key;
    }

    /**
     * get unique sets of date keys
     *
     * @return array
     */
    public static function date_sets()
    {
        $array = self::date_keys();

        return self::unique_sets($array);
    }

    /**
     * get all date keys, nullable and zero_date
     *
     * @return array
     */
    public static function date_keys()
    {
        $nullable = static::$nullable??[];
        $zero_date = static::$zero_date??[];
		$zero_datetime = static::$zero_datetime??[];
        return array_merge($nullable,$zero_date,$zero_datetime);
    }

    /**
     * get all unique sets for an array
     *
     * @param array $array
     * @return array
     */
    public static function unique_sets(array $array)
    {
        // initialize by adding the first element
        $results = [[array_pop($array)]];

        foreach ($array as $element) {
            foreach ($results as $combination) {
                array_push($results, array_merge([$element], $combination));
            }
        }

        return $results;
    }


    ///////////////   these override model methods to allow dynamic creation of casts methods and more when testing.



    /**
     * Get the mutated attributes for a given instance.
     *
     * @return array
     */
    public function getMutatedAttributes()
    {
        $mutAt = $this->cacheMutatedAttributes2($this);

        return $mutAt;
    }

    /**
     * Extract and cache all the mutated attributes of a class.
     *
     * @param  mixed $obj
     * @return array
     */
    public function cacheMutatedAttributes2($obj)
    {
        return collect(static::getMutatorMethods2($obj))->map(function ($match) {
            return lcfirst(static::$snakeAttributes ? Str::snake($match) : $match);
        })->all();
    }

    /**
     * Get all of the attribute mutator methods.
     *
     * @param  mixed $obj
     * @return array
     */
    protected function getMutatorMethods2($obj)
    {
        preg_match_all('/(?<=^|;)get([^;]+?)Attribute(;|$)/',
            implode(';', get_class_methods($obj)).';'.implode(';', array_keys(get_object_vars($this))), $matches);

        return $matches[1];
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        // allow for dynamically adding a callable item to this object
        if (is_callable($value)) {
            $this->$key = $value;
        } else {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * Dynamically call the dynamically defined set mutators
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (is_callable($this->{$method.'Example'})) {
            dump($method);

            return $this->{$method.'Example'}($parameters);
        }

        return parent::__call($method, $parameters);
    }
}
