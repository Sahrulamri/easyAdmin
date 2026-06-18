<?php

namespace App\Helpers;

use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Sidebar
{

  public function generate()
{
    $menus = $this->menus();

    $arrMenu = [];

    foreach ($menus as $menu) {

        $menu['visibility'] = true;

        $menu['url'] = Route::has($menu['key'].'.index')
            ? route($menu['key'].'.index')
            : '#';

        $menu['base_key'] = $menu['key'];
        $menu['key'] = $menu['key'].'.index';

        $arrMenu[] = $menu;
    }

    return $arrMenu;
}


  public function menus(){
    $role = "admin";
    if(config('idev.enable_role',true)){
      $role = Auth::user()->role->name;
    }
    return
      [
        [
          'name' => 'Dashboard',
          'icon' => 'ti ti-dashboard',
          'key' => 'dashboard',
          'base_key' => 'dashboard',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Role',
          'icon' => 'ti ti-key',
          'key' => 'role',
          'base_key' => 'role',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'User',
          'icon' => 'ti ti-users',
          'key' => 'user',
          'base_key' => 'user',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],

      [
        'name' => 'Product',
        'icon' => 'ti ti-menu',
        'key' => 'product',
        'base_key' => 'product',
        'override_visibility' => true,
        'ajax_load' => false,
        'childrens' => []
      ],

      [
        'name' => 'Transaction',
        'icon' => 'ti ti-receipt',
        'key' => 'transaction',
        'base_key' => 'transaction',
        'override_visibility' => true,
        'ajax_load' => false,
        'childrens' => []
      ],
      ];
  }


  public function defaultAllAccess($exclude = []) {
    return ['list', 'create','show', 'edit', 'delete','import-excel-default', 'export-excel-default','export-pdf-default'];
  }


  public function accessCustomize($menuKey)
  {
    $arrMenu = [
      'dashboard' => ['list'],
    ];

    return $arrMenu[$menuKey] ?? $this->defaultAllAccess();
  }

}
