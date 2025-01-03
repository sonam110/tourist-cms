<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AppSetting;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use Str;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('appsettings')->delete();
        // $appSetting = new Appsetting();
        // $appSetting->app_name    = 'Tourist Cms';
        // $appSetting->app_logo    = 'assets/images/logo.png';
        // $appSetting->email       = 'info@gmail.com';
        // $appSetting->address     = 'bhopal,India';
        // $appSetting->mobilenum   = '1234567898';
        // $appSetting->app_key       = Str::random(35);
        // $appSetting->save();

        // /*------------Default Role-----------------------------------*/
        // $role1 = Role::create([
        //    'id' => '1',
        //    'name' => 'Admin',
        //    'guard_name' => 'web'
        // ]);
        
        /*-----------Create Admin-------------*/
        $adminUser = new User();
        $adminUser->id                  = '1';
        $adminUser->role_id             = '1';
        $adminUser->name                = 'Admin';
        $adminUser->email               = 'admin@gmail.com';
        $adminUser->password            = \Hash::make(12345678);
        $adminUser->userType            = 'admin';
        $adminUser->email               = 'admin@gmail.com';
        $adminUser->email_verified_at   = date('Y-m-d H:i:s');
        $adminUser->mobile              = '9899751999';
        $adminUser->status              = 1;
        $adminUser->locktimeout              = 10;
        $adminUser->save();

        $adminRole = Role::where('id','1')->first();
        $adminUser->assignRole($adminRole);
        
        
    }
}
