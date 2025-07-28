<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\UserResource;
use App\Providers\Filament\Log;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\BookingStatusChart;
use App\Filament\Widgets\TopServicesChart;
use App\Filament\Widgets\LatestBookings;
use App\Filament\Widgets\LatestReviews;
use App\Filament\Widgets\SupportTicketsOverview;
use App\Filament\Widgets\CurrentUserInfo;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
        ->brandName('Famous Production')
        ->brandLogo(asset('images/famous_logoB.png'))
        ->darkModeBrandLogo(asset('images/famous_logoW.png'))
        ->brandLogoHeight('60px')
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
            'primary' => Color::Zinc,      // neutral black/gray tone
            'gray' => Color::Zinc,         // replaces slate with darker zinc
            'danger' => Color::Rose,       // muted dark red
            'info' => Color::Sky,          // softer than bright blue
            'success' => Color::Lime,      // works better on dark bg than Emerald
            'warning' => Color::Amber,     // warmer than bright orange
        ])
            ->discoverResources(
                  in: app_path('Filament/Resources'),
                  for: 'App\\Filament\\Resources',)
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                CurrentUserInfo::class,
                StatsOverview::class,
                RevenueChart::class,
                BookingStatusChart::class,
                TopServicesChart::class,
                LatestBookings::class,
                LatestReviews::class,
                SupportTicketsOverview::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ]);
        }
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
