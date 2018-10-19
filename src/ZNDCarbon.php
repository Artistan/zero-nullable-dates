<?php

namespace Artistan\ZeroNullDates;

use Illuminate\Support\Carbon;

/**
 * Class ZNDCarbon
 *
 * @package Artistan\ZeroNullDates
 */
class ZNDCarbon extends Carbon
{
	/**
	 * @var array
	 */
	private static $empty_date = ['0', 0, false, '', '0000-00-00', '0000-00-00 00:00:00'];

	/**
	 * @var string
	 */
	private $original_string = null;

	/**
	 * @var boolean
	 */
	private $is_date = false;

	/**
	 * Create a new ZNDCarbon instance.
	 *
	 * if column is nullable, we suggest you do not set it as a zero_date column.
	 *
	 * Please see the testing aids section (specifically static::setTestNow())
	 * for more on the possibility of this constructor returning a test instance.
	 *
	 * @param \DateTime|\DateTimeInterface|string|null $time
	 * @param \DateTimeZone|string|null $tz
	 */
	public function __construct($time = null, $tz = null)
	{
		if ($time instanceof Carbon || $time instanceof \DateTime || $time instanceof \DateTimeInterface) {
			$time = $this->original_string = (string) $time->format('Y-m-d H:i:s');
			$this->is_date = true;
		} elseif(self::date_value_not_empty($time)) {
			$this->original_string = $time;
			$this->is_date = true;
		} else {
			$this->original_string = $time;
			$this->is_date = false;
			// default to NOW (null) date.
			$time = null;
		}
		parent::__construct($time,$tz);
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public static function date_value_is_empty($value)
	{
		return in_array($value, self::$empty_date);
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public static function date_value_not_empty($value)
	{
		return ! in_array($value, self::$empty_date);
	}

	/**
	 * Check if an attribute exists on the object
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	public function __isset($name)
	{
		if ($this->is_date) {
			return parent::__isset($name);
		}

		return false;
	}

	/**
	 * Get a part of the Carbon object
	 *
	 * @param string $name
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return string|int|\DateTimeZone
	 */
	public function __get($name)
	{
		if ($this->is_date) {
			return parent::__get($name);
		}

		return null;
	}

	/**
	 * Set a part of the ZNDCarbon object
	 *
	 * @param string $name
	 * @param string|int|\DateTimeZone $value
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return void
	 */
	public function __set($name, $value)
	{
		if (! $this->is_date) {
			$this->__construct(date('Y-m-d H:i:s'));
		}
		parent::__set($name, $value);
	}

	/**
	 * Format the instance as a string using the set format
	 *
	 * @return string|null
	 */
	public function __toString()
	{
		if ($this->is_date) {
			return parent::__toString();
		}

		return null;
	}

	/**
	 * @return int
	 */
	public function getOffset()
	{
		if ($this->is_date) {
			return parent::getOffset();
		}

		return 0;
	}

	/**
	 * @param string $format
	 * @return string
	 */
	public function format($format)
	{
		if ($this->is_date) {
			return parent::format($format);
		}

		return null;
	}

	/**
	 * @param \DateTimeInterface $datetime2
	 * @param bool $absolute
	 * @return ZNDInterval|\DateInterval
	 */
	public function diff($datetime2, $absolute = false)
	{
		if ($this->is_date) {
			return parent::diff($datetime2, $absolute);
		}

		return (new ZNDInterval());
	}

	/**
	 * @return int
	 */
	public function getTimestamp()
	{
		if ($this->is_date) {
			return parent::getTimestamp();
		}

		return 0;
	}

	/**
	 * Get default array representation
	 *
	 * @return array
	 */
	public function toArray()
	{
		if ($this->is_date) {
			return parent::toArray();
		}

		return [
			'year' => null,
			'month' => null,
			'day' => null,
			'dayOfWeek' => null,
			'dayOfYear' => null,
			'hour' => null,
			'minute' => null,
			'second' => null,
			'micro' => null,
			'timestamp' => null,
			'formatted' => null,
			'timezone' => null,
		];
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfDay()
	{
		$this->make_date();

		return parent::startOfDay();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfDay()
	{
		$this->make_date();

		return parent::endOfDay();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfMonth()
	{
		$this->make_date();

		return parent::startOfMonth();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfMonth()
	{
		$this->make_date();

		return parent::endOfMonth();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfQuarter()
	{
		$this->make_date();

		return parent::startOfQuarter();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfQuarter()
	{
		$this->make_date();

		return parent::endOfQuarter();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfYear()
	{
		$this->make_date();

		return parent::startOfYear();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfYear()
	{
		$this->make_date();

		return parent::endOfYear();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfDecade()
	{
		$this->make_date();

		return parent::startOfDecade();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfDecade()
	{
		$this->make_date();

		return parent::endOfDecade();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfCentury()
	{
		$this->make_date();

		return parent::startOfCentury();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfCentury()
	{
		$this->make_date();

		return parent::endOfCentury();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfWeek()
	{
		$this->make_date();

		return parent::startOfWeek();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfWeek()
	{
		$this->make_date();

		return parent::endOfWeek();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfHour()
	{
		$this->make_date();

		return parent::startOfHour();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfHour()
	{
		$this->make_date();

		return parent::endOfHour();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function startOfMinute()
	{
		$this->make_date();

		return parent::startOfMinute();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function endOfMinute()
	{
		$this->make_date();

		return parent::endOfMinute();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function midDay()
	{
		$this->make_date();

		return parent::midDay();
	}

	/**
	 * @param null $dayOfWeek
	 * @return \Illuminate\Support\Carbon
	 */
	public function next($dayOfWeek = null)
	{
		$this->make_date();

		return parent::next($dayOfWeek);
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function nextWeekday()
	{
		$this->make_date();

		return parent::nextWeekday();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function previousWeekday()
	{
		$this->make_date();

		return parent::previousWeekday();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function nextWeekendDay()
	{
		$this->make_date();

		return parent::nextWeekendDay();
	}

	/**
	 * @return \Illuminate\Support\Carbon
	 */
	public function previousWeekendDay()
	{
		$this->make_date();

		return parent::previousWeekendDay();
	}

	/**
	 * @param null $dayOfWeek
	 * @return \Illuminate\Support\Carbon
	 */
	public function previous($dayOfWeek = null)
	{
		$this->make_date();

		return parent::previous($dayOfWeek);
	}

	/**
	 * @param null $dayOfWeek
	 * @return \Illuminate\Support\Carbon
	 */
	public function firstOfMonth($dayOfWeek = null)
	{
		$this->make_date();

		return parent::firstOfMonth($dayOfWeek);
	}

	/**
	 * @param null $string
	 * @return \Illuminate\Support\Carbon
	 */
	public function lastOfMonth($string = null)
	{
		$this->make_date();

		return parent::lastOfMonth($string);
	}

	/**
	 * @param int $nth
	 * @param int $dayOfWeek
	 * @return mixed
	 */
	public function nthOfMonth($nth, $dayOfWeek)
	{
		$this->make_date();

		return parent::nthOfMonth($nth, $dayOfWeek);
	}

	/**
	 * @param null $dayOfWeek
	 * @return \Illuminate\Support\Carbon
	 */
	public function firstOfQuarter($dayOfWeek = null)
	{
		$this->make_date();

		return parent::firstOfQuarter($dayOfWeek = null);
	}

	/**
	 * @param null $dayOfWeek
	 * @return \Illuminate\Support\Carbon
	 */
	public function lastOfQuarter($dayOfWeek = null)
	{
		$this->make_date();

		return parent::lastOfQuarter($dayOfWeek = null);
	}

	/**
	 * @param int $nth
	 * @param int $dayOfWeek
	 * @return mixed
	 */
	public function nthOfQuarter($nth, $dayOfWeek)
	{
		$this->make_date();

		return parent::nthOfQuarter($nth, $dayOfWeek);
	}

	/**
	 * @param null $dayOfWeek
	 * @return \DateTime|\DateTimeInterface|\Illuminate\Support\Carbon|null|string
	 */
	public function firstOfYear($dayOfWeek = null)
	{
		$this->make_date();

		return parent::firstOfYear($dayOfWeek);
	}

	/**
	 * @param null $dayOfWeek
	 * @return \DateTime|\DateTimeInterface|\Illuminate\Support\Carbon|null|string
	 */
	public function lastOfYear($dayOfWeek = null)
	{
		$this->make_date();

		return parent::lastOfYear($dayOfWeek);
	}

	/**
	 * @param int $nth
	 * @param int $dayOfWeek
	 * @return \DateTime|\DateTimeInterface|mixed|null|string
	 */
	public function nthOfYear($nth, $dayOfWeek)
	{
		$this->make_date();

		return parent::nthOfYear($nth, $dayOfWeek);
	}

	/**
	 * @param \Carbon\Carbon|\DateTimeInterface|null $date
	 * @return \DateTime|\DateTimeInterface|\Illuminate\Support\Carbon|null|string
	 */
	public function average($date = null)
	{
		$this->make_date();

		return parent::average($date);
	}

	/**
	 * @param null $date
	 * @return bool|null
	 */
	public function isBirthday($date = null)
	{
		if ($this->is_date) {
			return parent::isBirthday($date);
		}

		return false;
	}

	/**
	 * @return bool|null
	 */
	public function isLastOfMonth()
	{
		if ($this->is_date) {
			return parent::isLastOfMonth();
		}

		return false;
	}

	/**
	 * @return string
	 */
	public function serialize()
	{
		$this->make_date();

		return parent::serialize();
	}

	/**
	 * update the local is_date when a modifier is called so that it is then a valid date.
	 */
	private function make_date()
	{
		if (! $this->is_date) {
			$this->is_date = true;
			//$this->__construct();
		}
	}
}