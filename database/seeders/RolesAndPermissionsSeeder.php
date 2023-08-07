<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Create roles
        $roles = ['administrator', 'moderator', 'user'];

        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }

        // Define permissions
        $permissions = [
            'create blog post',
            'edit blog post',
            'delete blog post',
            'see blog post',
            'user management', // For the administrator role
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        // Create a user
        $user = User::create([
            'name' => 'Abdellah',
            'email' => 'abdellah.aminialaoui@abam.com',
            'password' => bcrypt('abdoucandoit'), // Replace this with a secure password
        ]);

        // Assign roles and permissions to the user
        $user->assignRole('administrator'); // Assign the administrator role to the user

        $administratorRole = Role::findByName('administrator');
        $administratorRole->givePermissionTo(['create blog post', 'edit blog post', 'delete blog post', 'user management']);

        $moderatorRole = Role::findByName('moderator');
        $moderatorRole->givePermissionTo(['create blog post', 'edit blog post', 'delete blog post']);

        $userRole = Role::findByName('user');
        $userRole->givePermissionTo('see blog post');
    }
}
