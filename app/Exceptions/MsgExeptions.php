<?php

namespace App\Exceptions;

class MsgExeptions
{
    const CPF = [
        'NOT_FOUND' => ['TYPE' => 'NotFoundCpfException', 'MSG' => 'CPF is not found.'],
        'INVALID' => ['TYPE' => 'InvalidCpfException', 'MSG' => 'CPF is not valid.'],
        'EXISTS' => ['TYPE' => 'ExistsCpfException', 'MSG' => 'CPF already exists.'],
        'REQUIRED' => ['TYPE' => 'RequiredCpfException', 'MSG' => 'CPF is required.'],
        'CREATE' => ['TYPE' => 'CreateCpfException', 'MSG' => 'Error creating CPF.'],
        'REMOVE' => ['TYPE' => 'RemoveCpfException', 'MSG' => 'Error removing CPF.'],
    ];

    const USER = [
        'NOT_FOUND' => ['TYPE' => 'NotFoundUserException', 'MSG' => 'User is not found.'],
        'INVALID' => ['TYPE' => 'InvalidUserException', 'MSG' => 'User is not valid.'],
        'EXISTS' => ['TYPE' => 'ExistsUserException', 'MSG' => 'User already exists.'],
        'REQUIRED' => ['TYPE' => 'RequiredUserException', 'MSG' => 'User is required.'],
        'CREATE' => ['TYPE' => 'CreateUserException', 'MSG' => 'Error creating User.'],
        'REMOVE' => ['TYPE' => 'RemoveUserException', 'MSG' => 'Error removing User.'],
        'UPDATE' => ['TYPE' => 'UpdateUserException', 'MSG' => 'Error updating User.'],
    ];

    const ROLE = [
        'NOT_FOUND' => ['TYPE' => 'NotFoundRoleException', 'MSG' => 'Role is not found.'],
        'INVALID' => ['TYPE' => 'InvalidRoleException', 'MSG' => 'Role is not valid.'],
        'EXISTS' => ['TYPE' => 'ExistsRoleException', 'MSG' => 'Role already exists.'],
        'REQUIRED' => ['TYPE' => 'RequiredRoleException', 'MSG' => 'Role is required.'],
        'CREATE' => ['TYPE' => 'CreateRoleException', 'MSG' => 'Error creating Role.'],
        'REMOVE' => ['TYPE' => 'RemoveRoleException', 'MSG' => 'Error removing Role.'],
        'UPDATE' => ['TYPE' => 'UpdateRoleException', 'MSG' => 'Error updating Role.'],
    ];

    const PERMISSION = [
        'NOT_FOUND' => ['TYPE' => 'NotFoundPermissionException', 'MSG' => 'Permission is not found.'],
        'INVALID' => ['TYPE' => 'InvalidPermissionException', 'MSG' => 'Permission is not valid.'],
        'EXISTS' => ['TYPE' => 'ExistsPermissionException', 'MSG' => 'Permission already exists.'],
        'REQUIRED' => ['TYPE' => 'RequiredPermissionException', 'MSG' => 'Permission is required.'],
        'CREATE' => ['TYPE' => 'CreatePermissionException', 'MSG' => 'Error creating Permission.'],
        'REMOVE' => ['TYPE' => 'RemovePermissionException', 'MSG' => 'Error removing Permission.'],
        'UPDATE' => ['TYPE' => 'UpdatePermissionException', 'MSG' => 'Error updating Permission.'],
    ];
}
