<?php

use Illuminate\Database\Seeder;
use Artistan\ZeroNullDates\Tests\Database\ZeroNullableUser;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(ZeroNullableUser::date_sets() as $set){
            factory(ZeroNullableUser::class, 20)->states($set)->create();
        }
    }
}
