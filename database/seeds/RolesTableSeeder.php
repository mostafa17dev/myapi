<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $owner = new Role();
        $owner->name  = 'owner';
        $owner->display_name = 'Product Owner';
        $owner->description = 'Product owner is the owner of a given project';
        $owner->save();

        $owner = new Role();
        $owner->name  = 'Admin';
        $owner->display_name = 'Admin user';
        $owner->description = 'Admin user has all authority';
        $owner->save();
    }
}
