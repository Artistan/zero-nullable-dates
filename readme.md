



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
 
note: the appends variables ARE mutate attributes that do not exist in the model attributes...

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

### mysql mode
`mysql`
```sql
SELECT @@sql_mode
```

### homestead box
`vim /etc/mysql/mysql.conf.d/mysqld.cnf`
```conf
sql_mode="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"
```



### notes on dev package setup 

https://medium.com/@lasselehtinen/getting-started-on-laravel-package-development-a62110c58ba1
https://stackoverflow.com/a/44023017/372215