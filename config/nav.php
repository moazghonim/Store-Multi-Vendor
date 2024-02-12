<?php

return [
    [

        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard.dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard.dashboard',
    ],

    [
        'icon' => 'fas fa-tags nav-icon',
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'new',
        'active' => 'dashboard.categories.*',
        'ability' => 'categories.index',
    ],

    [
        'icon' => 'fas fa-box nav-icon',
        'route' => 'dashboard.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*',
        'ability' => 'products.index',
    ],

    [
        'icon' => 'fas fa-receipt nav-icon',
        'route' => 'dashboard.orders.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*',
        'ability' => 'orders.index',
    ],
    [
        'icon' => 'fas fa-shield nav-icon',
        'route' => 'dashboard.roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.index',
    ],

    [
        'icon' => 'fas fa-users nav-icon',
        'route' => 'dashboard.users.index',
        'title' => 'Users',
        'active' => 'dashboard.users.*',
        'ability' => 'users.index',
    ],

    [
        'icon' => 'fas fa-users nav-icon',
        'route' => 'dashboard.admins.index',
        'title' => 'Admins',
        'active' => 'dashboard.amins.*',
        'ability' => 'admins.index',
    ],
];
