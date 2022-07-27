<?php 

//Event Hall
$route ['eventhall/(:any)/(:any)']       = 'eventhall/eventhall/Eventhall_controller/index/$1/$2';
$route ['EventhallSearchList']           = 'eventhall/eventhall/Eventhall_controller/FSxCEVNTHFormSearchList';
$route ['EventHallDataTable']            = 'eventhall/eventhall/Eventhall_controller/FSvCEVNTHCallPageDataTable';