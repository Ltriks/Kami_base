<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account')->insert([
            'username' => 'admin',
            'email' => 'admin@geek-zoo.com',
            'password' => bcrypt('123456'),
            'role_id' => 1,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time())
        ]);

        DB::table('roles')->insert([
            'name' => '普通用户',
            'slug' => 'user'
        ]);
        
        $cruds = ['create','update','delete','read'];
        //channel 只有read
        $controllers = ['accounts','groups','users','roles'];
        $permissions = [];

        foreach ($controllers as $ckey => $controller) {
            foreach ($cruds as $ikey => $crud) {
                $permissions[] = ['name' => $controller,'slug' => $controller.':'.$crud];
            }
        }
        DB::table('permissions')->insert($permissions);
     
        DB::table('permissions')->insert(['name' => 'permissions','slug' => 'permissions:read']);
        $results = DB::select('select id from permissions ');
        foreach ($results as $key => $result) {
            DB::table('permission_role')->insert(['permission_id' => $result->id,'role_id' => '1']);
        }
    }
}
