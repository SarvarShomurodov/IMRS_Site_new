<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role_admin = Role::where('name', 'admin')->first();
      $role_user  = Role::where('name', 'user')->first();

      $admin = new User();
      $admin->name = 'Administrator';
      $admin->email = 'admin@admin.com';
      $admin->password = Hash::make('11111111');
      $admin->save();
      $admin->roles()->attach($role_admin);

      $user = new User();
      $user->name = 'User ';
      $user->email = 'user@user.com';
      $user->password = Hash::make('11111111');
      $user->save();
      $user->roles()->attach($role_user);
    }
}
