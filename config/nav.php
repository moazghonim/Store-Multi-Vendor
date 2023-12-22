<?php

return [
    [

        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard',
    ],

    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'categories',
        'title' => 'Categories',
        'badge' => 'new',
        'active' => 'categories.*',
    ],

    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'products',
        'title' => 'Products',
        'active' => 'products.*',
    ],

    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'orders',
        'title' => 'Orders',
        'active' => 'orders.*',
    ]
];
