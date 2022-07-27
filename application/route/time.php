<?php
$route ['timeStamp/(:any)/(:any)']                  = 'time/timeStamp/Timestamp_controller/index/$1/$2';
$route ['timeStampMainpage']                        = 'time/timeStamp/Timestamp_controller/FSvTimeStampMainpage';
$route ['timeStampMainInsert']                      = 'time/timeStamp/Timestamp_controller/FSvTimeStampInsert';
$route ['timeStampMainGetHistoryCheckinCheckout']   = 'time/timeStamp/Timestamp_controller/FSvTimeStampGetHistoryCheckinCheckout';
$route ['timeStampMainGetLastCheckinCheckout']      = 'time/timeStamp/Timestamp_controller/FSvTimeStampGetLastCheckinCheckout';
$route ['timeStampMainGetDetail']                   = 'time/timeStamp/Timestamp_controller/FSvTimeStampGetDetail';
$route ['timeStampMainGetDetailDataTable']          = 'time/timeStamp/Timestamp_controller/FSvTimeStampGetDataTable';
$route ['timeStampMainUpdate']                      = 'time/timeStamp/Timestamp_controller/FSvTimeStampUpdateinline';