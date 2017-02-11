<?php

return [
    /*
    |--------------------------------------------------------------------------
    | URL Admin
    |--------------------------------------------------------------------------
    |
    | Prefix of the Panel Administrator.
    | Default is 'panel'
    |
    */
    
    'version' => '2.0.2',
    /*
    |--------------------------------------------------------------------------
    | URL Admin
    |--------------------------------------------------------------------------
    |
    | Prefix of the Panel Administrator.
    | Default is 'panel'
    |
    */
    
    'prefix' => 'panel',
    
    /*
    |-----------------------------------------------------------------------------------
    | Proyect Name
    |-----------------------------------------------------------------------------------
    |
    | Specified the name of the proyect or customer.
    | This value it will be displayed in the header and dashboard.
    |
    */
    
    'name' => 'Bee business',
    
    /*
    |-----------------------------------------------------------------------------------
    | Proyect Logo
    |-----------------------------------------------------------------------------------
    |
    | Specified the path (in public directory) of the image for the proyect or customer.
    | This value it will be displayed in the header and dashboard.
    | Set null if you don't want to show any logo.
    |
    */
    
    'logo' => 'panel_assets/images/logo.svg',
    
    /*
    |-----------------------------------------------------------------------------------
    | Sidebar Order
    |-----------------------------------------------------------------------------------
    |
    | If 'sidebarOrder' is true, the sidebar will be order by the 'sidebarOrder' field
    | in the Blueprint.
    | If 'sidebarOrder' is false, the sidebar will be order by the name in Blueprint
    |
    */
    
    'sidebarOrder' => false,
    
    /*
    |-----------------------------------------------------------------------------------
    | Paginate
    |-----------------------------------------------------------------------------------
    |
    | This option define the default value for pagination if is not defined in Blueprint
    |
    */
    
    'paginate' => 10,
    
    /*
    |-----------------------------------------------------------------------------------
    | Disk
    |-----------------------------------------------------------------------------------
    |
    | This option define where the files will be storage
    |
    */
    
    'disk' => 'public'
    
];