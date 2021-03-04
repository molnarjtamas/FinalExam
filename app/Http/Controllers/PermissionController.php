<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function check($permissionName)
    {
        $permissions = Auth::user()->getAllPermissions()->pluck('name');
        abort_unless(in_array($permissionName,$permissions->toArray()),403);
        return response('',204);
    }
}
