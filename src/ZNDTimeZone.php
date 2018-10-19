<?php

namespace Artistan\ZeroNullDates;

class ZNDTimeZone
{
	/**
	 * @ param string $timezone
	 *
	 * @link https://php.net/manual/en/datetimezone.construct.php
	 */
	public function __construct(/*$timezone*/)
	{
	}

	/**
	 * Returns the name of the timezone
	 *
	 * @return string
	 * @link https://php.net/manual/en/datetimezone.getname.php
	 */
	public function getName()
	{
		return 'Zero Null Date TimeZone';
	}

	/**
	 * Returns location information for a timezone
	 *
	 * @return array
	 * @link https://php.net/manual/en/datetimezone.getlocation.php
	 */
	public function getLocation()
	{
		return [];
	}

	/**
	 * Returns the timezone offset from GMT
	 *
	 * @ param \DateTime $datetime
	 *
	 * @return int
	 * @link https://php.net/manual/en/datetimezone.getoffset.php
	 */
	public function getOffset(/*\DateTime $datetime*/)
	{
		return 0;
	}

	/**
	 * Returns all transitions for the timezone
	 *
	 * @ param int $timestamp_begin [optional]
	 * @ param int $timestamp_end [optional]
	 *
	 * @return array
	 * @link https://php.net/manual/en/datetimezone.gettransitions.php
	 */
	public function getTransitions(/*$timestamp_begin = null, $timestamp_end = null*/)
	{
		return [];
	}

	/**
	 * Returns associative array containing dst, offset and the timezone name
	 *
	 * @return array
	 * @link https://php.net/manual/en/datetimezone.listabbreviations.php
	 */
	public static function listAbbreviations()
	{
		return ['dst' => 0, 'offset' => 0, 'timezone_id' => 'Zero Null Date TimeZone'];
	}

	/**
	 * Returns a numerically indexed array with all timezone identifiers
	 *
	 * @ param int $what
	 * @ param string $country
	 *
	 * @return array
	 * @link https://php.net/manual/en/datetimezone.listidentifiers.php
	 */
	public static function listIdentifiers(/*$what = \DateTimeZone::ALL, $country = null*/)
	{
		return [];
	}

	/**
	 * @link https://php.net/manual/en/datetime.wakeup.php
	 */
	public function __wakeup()
	{
	}

	public static function __set_state($an_array)
	{
	}
}
