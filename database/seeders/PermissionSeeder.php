<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        // Limpiar permisos existentes si se desea empezar desde cero
        // DB::table('permissions')->truncate();
        
        $permissions = [
            // Usuarios
            ['name' => 'user_view', 'description' => 'Ver usuarios', 'custom' => 0],
            ['name' => 'user_create', 'description' => 'Crear usuarios', 'custom' => 0],
            ['name' => 'user_edit', 'description' => 'Editar usuarios', 'custom' => 0],
            ['name' => 'user_delete', 'description' => 'Eliminar usuarios', 'custom' => 0],
            
            // Roles
            ['name' => 'rol_view', 'description' => 'Ver roles', 'custom' => 0],
            ['name' => 'rol_create', 'description' => 'Crear roles', 'custom' => 0],
            ['name' => 'rol_edit', 'description' => 'Editar roles', 'custom' => 0],
            ['name' => 'rol_delete', 'description' => 'Eliminar roles', 'custom' => 0],

            // Permisos
            ['name' => 'permission_view', 'description' => 'Ver permisos', 'custom' => 0],
            ['name' => 'permission_create', 'description' => 'Crear permisos', 'custom' => 0],
            ['name' => 'permission_edit', 'description' => 'Editar permisos', 'custom' => 0],
            ['name' => 'permission_delete', 'description' => 'Eliminar permisos', 'custom' => 0],

            // Clientes
            ['name' => 'client_view', 'description' => 'Ver clientes', 'custom' => 0],
            ['name' => 'client_create', 'description' => 'Crear clientes', 'custom' => 0],
            ['name' => 'client_edit', 'description' => 'Editar clientes', 'custom' => 0],
            ['name' => 'client_delete', 'description' => 'Eliminar clientes', 'custom' => 0],

            ['name' => 'skill_view', 'description' => 'Ver skill', 'custom' => 0],
            ['name' => 'skill_create', 'description' => 'Crear skill', 'custom' => 0],
            ['name' => 'skill_edit', 'description' => 'Editar skill', 'custom' => 0],
            ['name' => 'skill_delete', 'description' => 'Eliminar skill', 'custom' => 0],

            ['name' => 'ally_view', 'description' => 'Ver aliado', 'custom' => 0],
            ['name' => 'ally_create', 'description' => 'Crear aliado', 'custom' => 0],
            ['name' => 'ally_edit', 'description' => 'Editar aliado', 'custom' => 0],
            ['name' => 'ally_delete', 'description' => 'Eliminar aliado', 'custom' => 0],

        ]; 
        // Crear o actualizar permisos
        $this->createOrUpdatePermissions($permissions);

        // Asignar permisos a roles
        $this->assignPermissionsToRoles();
    }

    /**
     * Crear o actualizar permisos en la base de datos
     *
     * @param array $permissions
     * @return void
     */
    private function createOrUpdatePermissions(array $permissions)
    {
        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate(
                ['name' => $permissionData['name']], // Buscar por nombre
                [
                    'description' => $permissionData['description'],
                    'custom' => $permissionData['custom'],
                    'guard_name' => 'web',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }

    /**
     * Asignar permisos a los roles correspondientes
     *
     * @return void
     */
    private function assignPermissionsToRoles()
    {
        // Obtener todos los permisos
        $allPermissions = Permission::all();
        $allPermissionIds = $allPermissions->pluck('id')->toArray();

        // Asignar todos los permisos al SuperAdmin
        $superAdmin = Role::where('name', 'SuperAdmin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions($allPermissionIds);
        }

        // Definir permisos específicos para el Administrador
        $adminPermissions = [
            'user_view',
            'user_create',
            'user_edit',
            'rol_view',
            'rol_create',
            'rol_edit',
            'permission_view',
            'client_view',
            'client_create',
            'client_edit',
            'skill_view',
            'skill_create',
            'skill_edit',
            'ally_view',
            'ally_create',
            'ally_edit',
        ];


        // Asignar permisos específicos al Administrador
        $admin = Role::where('name', 'Administrador')->first();
        if ($admin) {
            $admin->syncPermissions($adminPermissions);
        }
    }
}
