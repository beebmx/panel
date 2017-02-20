<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Panel version
    |--------------------------------------------------------------------------
    |
    | Specified the version of the current panel administration
    |
    */
    
    'version' => '2.0.8',
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
    
    'disk' => 'public',
    
    /*
    |-----------------------------------------------------------------------------------
    | Google Maps API Key
    |-----------------------------------------------------------------------------------
    |
    | If you have need to use Geolocation Field, you required an API Key.
    | You can obtain an API Key here: https://console.developers.google.com
    |
    */
    
    'maps_api' => env('PANEL_MAPS_API_KEY', ''),
    
];