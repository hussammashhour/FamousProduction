<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class CurrentUserInfo extends Widget
{
    protected static string $view = 'filament.widgets.current-user-info';

    protected int | string | array $columnSpan = 'full';

    public function getUser()
    {
        return Auth::user();
    }

    public function getUserRoles()
    {
        $user = Auth::user();
        return $user ? $user->roles->pluck('name')->join(', ') : 'No roles assigned';
    }

    public function getMemberSince()
    {
        $user = Auth::user();
        return $user ? $user->created_at->diffForHumans() : 'Unknown';
    }
}
