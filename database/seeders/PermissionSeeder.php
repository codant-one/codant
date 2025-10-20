<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Role;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [ 

            ['name' => 'user_view', 'description' => 'Ver Usuarios', 'custom' => 0],
            ['name' => 'user_create', 'description' => 'Crear Usuarios', 'custom' => 0],
            ['name' => 'user_edit', 'description' => 'Editar Usuarios', 'custom' => 0],
            ['name' => 'user_delete', 'description' => 'Eliminar Usuarios', 'custom' => 0],
            
            ['name' => 'rol_view', 'description' => 'Ver Roles', 'custom' => 0],
            ['name' => 'rol_create', 'description' => 'Crear Roles', 'custom' => 0],
            ['name' => 'rol_edit', 'description' => 'Editar Roles', 'custom' => 0],
            ['name' => 'rol_delete', 'description' => 'Eliminar Roles', 'custom' => 0],

            ['name' => 'permission_view', 'description' => 'Ver Permisos', 'custom' => 0],
            ['name' => 'permission_create', 'description' => 'Crear Permisos', 'custom' => 0],
            ['name' => 'permission_edit', 'description' => 'Editar Permisos', 'custom' => 0],
            ['name' => 'permission_delete', 'description' => 'Eliminar Permisos', 'custom' => 0],

            ['name' => 'client_view', 'description' => 'Ver Clientes', 'custom' => 0],
            ['name' => 'client_create', 'description' => 'Crear Clientes', 'custom' => 0],
            ['name' => 'client_edit', 'description' => 'Editar Clientes', 'custom' => 0],
            ['name' => 'client_delete', 'description' => 'Eliminar Clientes', 'custom' => 0],

        ]; 

        $permissions = [];

        foreach($data as $permission){
            $permission['guard_name'] = 'web';
            $permission['created_at'] = Carbon::now();
            $permission['updated_at'] = Carbon::now();
            $permissions[] = $permission;
        }

        $data = Permission::insert($permissions);

        $permission_ids = [];

        foreach(Permission::all() as $all_permission) {
            $permission_ids[] = $all_permission->id;
        }

        // Asigne all permissions to ROL SuperAdmin
        $superadmin = Role::where('name', 'SuperAdmin')->first();
        $superadmin->syncPermissions($permission_ids);

        $users = [ 
            'user_view',
            'user_create',
            'user_edit'           
        ];

        $roles = [
            'rol_view',
            'rol_create',
            'rol_edit'            
        ];

        $permissions_ = [
            'permission_view'           
        ];

        $clients = [
            'client_view',
            'client_create', 
            'client_edit'
        ];


        $admin = Role::where('name', 'Administrador')->first();

        $admin->givePermissionTo(
            array_merge($users, $roles, $permissions_, $clients)
        );

    }
}
