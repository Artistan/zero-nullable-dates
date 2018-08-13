<?php

namespace Artistan\ZeroNullDates\Tests\Database;

use Artistan\ZeroNullDates\Tests\TestCase;
use Artistan\ZeroNullDates\Tests\Database\ZeroNullableUser as TestUser;

class ModelTest extends TestCase
{
    private $current_config_set = [];

    // test for all combinations of what things are set for date columns....
    //| mutator | cast | date |
    //|---------|------|------|
    //|    x    |      |      |
    //|         |  x   |      |
    //|         |      |  x   |
    //|    x    |  x   |      |
    //|    x    |      |  x   |
    //|         |  x   |  x   |
    //|    x    |  x   |  x   |
    public function testVariations()
    {
        $change_settings_methods = [
            'key_mutator',
            'key_casting',
            'key_dates',
        ];
        $unique_callback_set = TestUser::unique_sets($change_settings_methods);
        foreach ($unique_callback_set as $set_of_callbacks) {
            // call the callbacks
            $this->current_config_set = $set_of_callbacks;
            // nullable
            $this->nullable();
            // zeroDate
            $this->zeroDate();
        }
    }

    public function nullable()
    {
        foreach (TestUser::$nullable as $key) {
            $this->checkDateAssertions($key, null);
        }
    }

    public function zeroDate()
    {
        foreach (TestUser::$zero_date as $key) {
            $this->checkDateAssertions($key, '0000-00-00');
        }
    }

    public function checkDateAssertions($key, $null_or_zeros)
    {
        /** @var TestUser $user */
        $user = TestUser::where($key, $null_or_zeros)->limit(1)->first();
        $this->add_callbacks_to_user($key, $user);
        $array = $user->toArray();
        $zeroDateArray = $array[$key];
        $zeroDateAttribute = $user->{$key};

        $this->assertNull($zeroDateAttribute, "Value of user->{$key} {$zeroDateAttribute}");
        $this->assertNull($zeroDateArray, "Value of user_array[{$key}] {$zeroDateArray}");
        $this->assertEquals($zeroDateAttribute, $zeroDateArray,
            "Value of user->{$key} not equal to user_array[{$key}]");

        // test that it will properly set the value to $null_or_zeros depending on the column settings.
        $this->checkSaveAssertions($key, $null_or_zeros, '0000-00-00');
        $this->checkSaveAssertions($key, $null_or_zeros, '0');
        $this->checkSaveAssertions($key, $null_or_zeros, null);
    }

    public function checkSaveAssertions($key, $value, $newValue)
    {
        $verbose_value = var_export($newValue, true);

        /** @var TestUser $user */
        $user = factory(TestUser::class)->make();
        // test setting the zero date attribute to null and saving it.
        $user->$key = $newValue;
        $saved = $user->save();
        $this->assertTrue($saved, "Saving new user with {$verbose_value} in zero date column did not work...");

        if (is_null($value)) {
            // test that it saved in the db as NULL, since that is what is expected!!!
            $user = TestUser::find($user->id);
            $this->assertNull($user->getOriginal($key),
                "Value of user->->getOriginal({$key}) did not save as null when set to {$verbose_value}".var_export($user,true));
        } else {
            // test that it saved in the db as a zero date, since that is what is expected!!!
            $user = TestUser::find($user->id);
            $this->assertStringStartsWith('0000-00-00', $user->getOriginal($key),
                "Value of user->->getOriginal({$key}) did not save as zero date when set to {$verbose_value}".var_export($user,true));
        }
    }

    public function listenSql()
    {
        \DB::listen(function (...$args) {
            dump('testSql');
            foreach ($args as $v) {
                foreach ($v as $b) {
                    if (gettype($b) != 'object') {
                        dump($b);
                    } else {
                        dump(get_class($b));
                    }
                }
            }
        });
    }

    public function add_callbacks_to_user($key, &$user)
    {
        foreach ($this->current_config_set as $callable) {
            $user->$callable($key);
        }
    }
}


