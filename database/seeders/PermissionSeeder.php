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
            ['name' => 'user_view', 'description' => 'Ver Usuarios', 'custom' => 0],
            ['name' => 'user_create', 'description' => 'Crear Usuarios', 'custom' => 0],
            ['name' => 'user_edit', 'description' => 'Editar Usuarios', 'custom' => 0],
            ['name' => 'user_delete', 'description' => 'Eliminar Usuarios', 'custom' => 0],
            
            // Roles
            ['name' => 'rol_view', 'description' => 'Ver Roles', 'custom' => 0],
            ['name' => 'rol_create', 'description' => 'Crear Roles', 'custom' => 0],
            ['name' => 'rol_edit', 'description' => 'Editar Roles', 'custom' => 0],
            ['name' => 'rol_delete', 'description' => 'Eliminar Roles', 'custom' => 0],

            // Permisos
            ['name' => 'permission_view', 'description' => 'Ver Permisos', 'custom' => 0],
            ['name' => 'permission_create', 'description' => 'Crear Permisos', 'custom' => 0],
            ['name' => 'permission_edit', 'description' => 'Editar Permisos', 'custom' => 0],
            ['name' => 'permission_delete', 'description' => 'Eliminar Permisos', 'custom' => 0],

            // Clientes
            ['name' => 'client_view', 'description' => 'Ver Clientes', 'custom' => 0],
            ['name' => 'client_create', 'description' => 'Crear Clientes', 'custom' => 0],
            ['name' => 'client_edit', 'description' => 'Editar Clientes', 'custom' => 0],
            ['name' => 'client_delete', 'description' => 'Eliminar Clientes', 'custom' => 0],

            ['name' => 'skill_view', 'description' => 'Ver Skill', 'custom' => 0],
            ['name' => 'skill_create', 'description' => 'Crear Skill', 'custom' => 0],
            ['name' => 'skill_edit', 'description' => 'Editar Skill', 'custom' => 0],
            ['name' => 'skill_delete', 'description' => 'Eliminar Skill', 'custom' => 0],

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
            $this->command->info('Permisos asignados al SuperAdmin: ' . count($allPermissionIds));
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
            'skill_edit'
        ];


        // Asignar permisos específicos al Administrador
        $admin = Role::where('name', 'Administrador')->first();
        if ($admin) {
            $admin->syncPermissions($adminPermissions);
            $this->command->info('Permisos asignados al Administrador: ' . count($adminPermissions));
        }
    }
}
