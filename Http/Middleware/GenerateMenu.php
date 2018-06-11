<?php

namespace Modules\ECommerce\Http\Middleware;

use Closure;

class GenerateMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Create Admin Menu with default fields
        \Menu::make('AdminMenu', function ($menu) {
            $menu->add('Catalogue')->nickname('catalogue')
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>')->link->href('#');
            $menu->item('catalogue')->add('Products', ['route' => 'admin.product.index'])
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>');
            $menu->item('catalogue')->add('Category', ['route' => 'admin.category.index'])
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>');

            $menu->add('Orders')->nickname('orders')
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>')->link->href('#');
            $menu->item('orders')->add('Orders', ['route' => 'admin.order.index'])
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>');
            $menu->item('orders')->add('Invoices', ['route' => 'admin.invoice.index'])
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>');
        });

        \Menu::make('UserMenu', function ($menu) {
        });

        \Menu::make('ClientMenu', function ($menu) {
            $menu->add('My Orders')
                ->prepend('<i class="fa fa-dashboard"></i><span class="title">')->append('</span>');
        });
        return $next($request);
    }
}
