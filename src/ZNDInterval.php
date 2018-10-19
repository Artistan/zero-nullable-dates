<?php

namespace Artistan\ZeroNullDates;

/**
 * Representation of date interval. A date interval stores either a fixed amount of
 * time (in years, months, days, hours etc) or a relative time string in the format
 * that DateTime's constructor supports.
 *
 * @link https://php.net/manual/en/class.dateinterval.php
 */
class ZNDInterval
{
	/**
	 * Number of years
	 *
	 * @var int
	 */
	public $y;

	/**
	 * Number of months
	 *
	 * @var int
	 */
	public $m;

	/**
	 * Number of days
	 *
	 * @var int
	 */
	public $d;

	/**
	 * Number of hours
	 *
	 * @var int
	 */
	public $h;

	/**
	 * Number of minutes
	 *
	 * @var int
	 */
	public $i;

	/**
	 * Number of seconds
	 *
	 * @var int
	 */
	public $s;

	/**
	 * Number of microseconds
	 *
	 * @since 7.1.0
	 * @var float
	 */
	public $f;

	/**
	 * Is 1 if the interval is inverted and 0 otherwise
	 *
	 * @var int
	 */
	public $invert;

	/**
	 * Total number of days the interval spans. If this is unknown, days will be FALSE.
	 *
	 * @var mixed
	 */
	public $days;

	/**
	 * @ param string $interval_spec
	 * @link https://php.net/manual/en/dateinterval.construct.php
	 */
	public function __construct(/*$interval_spec*/)
	{
	}

	/**
	 * Formats the interval
	 *
	 * @ param $format
	 * @return string
	 * @link https://php.net/manual/en/dateinterval.format.php
	 */
	public function format(/*$format*/)
	{
		return '';
	}

	/**
	 * Sets up a DateInterval from the relative parts of the string
	 *
	 * @ param string $time
	 * @return ZNDInterval
	 * @link https://php.net/manual/en/dateinterval.createfromdatestring.php
	 */
	public static function createFromDateString(/*$time*/)
	{
		return (new ZNDInterval());
	}

	public function __wakeup()
	{
	}

	public static function __set_state(/*$an_array*/)
	{
	}
}