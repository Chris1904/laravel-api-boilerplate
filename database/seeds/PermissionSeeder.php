<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $roles = [
        'admin',
        'staff',
        'user'
    ];

    protected $models = [
        'user',
    ];

    protected $types = [
        'view',
        'create',
        'update',
        'delete'
    ];

    public function run()
    {
        $this->truncate();

        $this->roles = collect($this->roles)->map(function ($role) {
            return Role::create(['name' => $role]);
        });

        collect($this->models)->each(function ($model) {
            $permissions = collect($this->types)->map(function ($type) use ($model) {
                return Permission::create(['name' => "{$type}_{$model}"]);
            });
            $this->roles->first()->givePermissionTo($permissions);
        });
    }

    /**
     * Truncate all tables related to permissions.
     *
     * @return void
     */
    public function truncate()
    {
        Schema::disableForeignKeyConstraints();

        Permission::truncate();
        Role::truncate();

        Schema::enableForeignKeyConstraints();
    }
}
