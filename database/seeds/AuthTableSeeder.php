<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AuthTableSeeder extends Seeder
{
    protected $adminEmail;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedUsers();
        $this->seedRolesAndPermissions();
        $this->assignRoleToUser('admin', 'admin');
        $this->assignRoleToUser('staff', 'demo');
        $this->seedActivityLog();

    }

    public function seedUsers()
    {
        factory(User::class)->create([
          'name' => 'admin',
          'email' => $this->generateEmail('admin'),
          'password' => Hash::make('admin123'),
          'remember_token' => str_random(10),
        ]);

        factory(User::class)->create([
          'name' => 'demo',
          'email' => $this->generateEmail('demo'),
          'password' => Hash::make('demo123'),
          'remember_token' => str_random(10),
        ]);
    }

    public function seedRolesAndPermissions()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        Permission::create(['name' => 'view_settings']);
        Permission::create(['name' => 'view_roles_and_permissions']);
        Permission::create(['name' => 'view_users']);
        Permission::create(['name' => 'view_activities']);

        Role::create(['name' => 'Officer']);
        Role::create(['name' => 'Staff']);
        $adminRole = Role::create(['name' => 'Admin']);

        $adminRole->givePermissionTo(Permission::all());
    }

    public function assignRoleToUser(string $role, string $name)
    {
        $role = Role::where('name', $role)->firstOrFail();
        $user = User::where('name', $name)->firstOrFail();

        $user->syncRoles([$role->name]);
    }

    public function seedActivityLog()
    {
        $faker = Faker::create();
        for ($i=0; $i < 75; $i++) {
            activity()->log($faker->sentence);
        }

    }

    public function generateEmail(string $username) : string
    {
        return $username . '@' . strtolower(env('APP_NAME', 'domain')) . '.test';
    }

}
