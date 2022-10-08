<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Tobuli\Repositories\User\UserRepositoryInterface as User;
use Illuminate\Database\Seeder;
use Tobuli\Services\PermissionService;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'email_verified_at' => $now,
            'password' => '$2y$10$BO6MZeEzr11yswqtcF3qze85R8RRLQ7d43PNLy6JdF3CgATTQ1KT.',
            'group_id' => 1,
            'map_id' => config('tobuli.main_settings.default_map'),
            'available_maps' => serialize(config('tobuli.main_settings.available_maps')),
            'open_device_groups' => '["0"]',
            'open_geofence_groups' => '["0"]'
        ]);

        $permissions = (new PermissionService())->getByGroupId(PermissionService::GROUP_ADMIN);

        $users = DB::table('users')->get();

        foreach ($users as $user) {
            $user_permissions = [];

            foreach ($permissions as $name => $modes)
            {
                $user_permissions[] = array_merge([
                    'user_id' => $user->id,
                    'name' => $name,
                ], $modes);
            }

            DB::table('user_permissions')->insert($user_permissions);
        }

    }
}