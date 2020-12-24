<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            [
//                'name' => 'admin',
//                'email' => 'admin.tung@gmail.com',
//                'password' => bcrypt('123456'),
//                'created_at' => now(),
//                'updated_at' => now(),
//                'email_verified_at' => now(),
//            ],
//        ]);

        // DB::table('permissions')->insert([
        //     ['name' => 'review_post'],
        //     ['name' => 'update_post'],
        //     ['name' => 'delete_post'],
        //     ['name' => 'restore_post'],
        //     ['name' => 'force_delete_post'],
        // ]);

        // DB::table('roles')->insert([
        //     ['name' => 'admin'],
        //     ['name' => 'user']
        // ]);
        // DB::table('role_user')->insert(
        //     [
        //         'role_id' => 1,
        //         'user_id' => 3,
        //     ],
        // );
        // DB::table('permission_role')->insert([
        //     ['permission_id' => 1, 'role_id' => 1],
        //     ['permission_id' => 2, 'role_id' => 1],
        //     ['permission_id' => 3, 'role_id' => 1],
        //     ['permission_id' => 4, 'role_id' => 1],
        //     ['permission_id' => 5, 'role_id' => 1],
        // ]);

//        Profile::create(
//            [
//                'user_id'=>1,
//                'first_name'=> "tung",
//                'last_name'=> "phung",
//                'subject' => "admin",
//                'status' => "private",
//            ],
//
//        );
    }
}
