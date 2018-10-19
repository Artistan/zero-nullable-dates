
## ZNDCarbon
Laravel Models with nullable carbon dates,
this also allow for returning a date object. When the value is null/zeros that will format to ''.

### example
```php

	// my_date on new model is null...
	// this will just be null value
	// so you can use the null coalesce operator to set a string
	
	echo $user->my_date->format('Y-m-d H:i:s') ?? 'Set a Date';
	 

```


This is useful for old databases that do not have NO_ZERO_IN_DATE, NO_ZERO_DATE
so they may have 0000-00-00 type dates.

Add ZNDTrait and a couple arrays to define nullable dates to allow for zero and nullable dates.
  
You may also set null_all_dates on your model to set all to nullable without the arrays  

Ultimately you can just set them all to `$nullable`, the addition of `$zero_datetime` and `$zero_date` are for testing that the database is updating as expected.


```php
use Artistan\ZeroNullDates\ZNDTrait;

/**
 *  @see tests/Database/ZeroNullableUser.php
 */
class ZeroNullableUser extends Authenticatable
{
    use Notifiable;
    use ZNDTrait;  
    
    /**
     * The attributes that are zero-datetimes
     *
     * @var array
     */
    public static $zero_datetime = [
        'created_date',
    ];

    /**
     * The attributes that are zero-dates
     *
     * @var array
     */
    public static $zero_date = [
        'created_date_time',
        'created_date_time_zoned',
    ];

    /**
     * The attributes that are nullable dates
     *
     * @var array
     */
    public static $nullable = [
        'created_date_time_null',
        'created_date_time_zoned_null',
        'created_date_null',
        'created_at',
        'updated_at',
    ];
}
```

The unit tests are dynamic and test 288 assertions 

 test for all combinations of what things are set for date columns....
 all combinations of mutators, castings, and dates
 
| mutator | cast | date |
|---------|------|------|
|    x    |      |      |
|         |  x   |      |
|         |      |  x   |
|    x    |  x   |      |
|    x    |      |  x   |
|         |  x   |  x   |
|    x    |  x   |  x   |



notes on current laravel functionality dealing with toArray, attribute accessors, and dates

#toArray vs accessor

## if you use $model->{camel_key} (getAttributeValue), then it will
- model->{key} > getAttribute(key) > getAttributeFromArray(key)
    - get the original attribute
- mutate : if hasGetMutator > mutateAttribute
    - this is the accessor get{CasedKey}Attribute
    - mutate it if there is a mutator RETURN IT HERE
- cast : if hasCast > castAttribute
    - cast it if there is a cast method RETURN IT HERE
- date format : if matches getDates > asDateTime
    - finaly make a date (carbon) object from it `IF NOT NULL` RETURN IT HERE
- return value
 
note: the appends variables ARE mutated attributes that do not exist in the model attributes...

## if you get attributes via $model->toArray then it will
- addDateAttributesToArray via getArrayableAttributes
    - so this is cast to a string AFTER carbon dating, no other processing will be applied
- addMutatedAttributesToArray via getMutatedAttributes
    - so AFTER dates transformed from carbon, then it will try mutating the formated data
    - can mutate the already "date formated" data since it passes that value to the `mutateAttribute`
- addCastAttributesToArray
    - this will cast a value to whatever type is specified
    - if date it will serialize it to the format specified
    - note, this is AFTER dates have already been carbon dated and formated by mutator
- getArrayableAppends
    - this will add any mutators that are not directly related to a model attibutue

## date mutators.

these are both mutators and accessors, or mutates in and out

- get from db sends us a carbon date

## data analysis

when date keys are set for dates that allow ZERO dates the formatting for 000-00-00 or variations of that fail.
`-0001-11-30 00:00:00` is the default result...  

## ZNDCarbon
using NULL as the data point when it is a zero nullable date  
```
private static $empty_date = ['0', 0, false, '', '0000-00-00', '0000-00-00 00:00:00'];
```

### mysql mode
`mysql`
```sql
SELECT @@sql_mode
```

### homestead box setup for testing
`vim /etc/mysql/mysql.conf.d/mysqld.cnf`
```conf
sql_mode="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"
```



### notes on dev package setup 

- example package
https://medium.com/@lasselehtinen/getting-started-on-laravel-package-development-a62110c58ba1
- package setup
https://stackoverflow.com/a/44023017/372215
- test setup
https://github.com/orchestral/testbench
- .env file in tests directory for configuration of your tests
- `ln -s vendor/laravel/laravel/config` in tests directory to allow access to config files
    - laravel does not have a seperate "config" path from the base path, damn it.
