<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->Listen(BuildingMenu::class, function(BuildingMenu $event){
            $event->menu->add('MENU DE NAVEGACION');

            $role = Auth::user()->role;

            $event->menu->add(
                [
                    'text'  => 'Escritorio',
                    'route' => 'home',
                    'icon'  => 'fas fa-tachometer-alt'
                ],
                [
                    'text'  => 'Perfil',
                    'route' => 'profile',
                    'icon'  => 'fas fa-user'
                ]
            );

            switch ($role) {
                case 'administrator':
                    $event->menu->add(
                        [
                            'text'  => 'Usuarios',
                            'route' => 'users.index',
                            'icon'  => 'fas fa-users-cog'
                        ],
                        [
                            'text'  => 'Creditos',
                            'route' => 'sales.index',
                            'icon'  => 'fas fa-credit-card'
                        ]
                    );
                break;
                case 'sales':
                    $event->menu->add(
                        [
                            'text'  => 'Puntos de Ventas',
                            'route' => 'users.index',
                            'icon'  => 'fas fa-users-cog'
                        ],
                        [
                            'text'  => 'Creditos a puntos de Venta',
                            'route' => 'sales.index',
                            'icon'  => 'fas fa-credit-card'
                        ]
                    );
                break;

                case 'sales_point':
                    $event->menu->add(
                        [
                            'text'  => 'Creditos a Conductores',
                            'route' => 'provider-credits.index',
                            'icon'  => 'fas fa-credit-card'
                        ]
                    );
                break;
            }

        });
    }
}
