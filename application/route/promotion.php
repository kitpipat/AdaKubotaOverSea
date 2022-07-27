<?php

//Voucher (วอร์เชอร์)
$route ['voucher/(:any)/(:any)']     = 'promotion/voucher/Voucher_controller/index/$1/$2';
$route ['voucherFormSearchList']     = 'promotion/voucher/Voucher_controller/FSxCVOCFormSearchList';
$route ['voucherPageAdd']            = 'promotion/voucher/Voucher_controller/FSxCVOCAddPage';
$route ['voucherDataTable']          = 'promotion/voucher/Voucher_controller/FSxCVOCDataTable';
$route ['voucherPageEdit']           = 'promotion/voucher/Voucher_controller/FSvCVOCEditPage';
$route ['voucherEventAdd']           = 'promotion/voucher/Voucher_controller/FSaCVOCAddEvent';
$route ['voucherEventEdit']          = 'promotion/voucher/Voucher_controller/FSaCVOCEditEvent';
$route ['voucherEventDelete']        = 'promotion/voucher/Voucher_controller/FSaCVOCDeleteEvent';

//type voucher (ประเภทวอร์เชอร)
$route ['vouchertype/(:any)/(:any)']     = 'promotion/vouchertype/Vouchertype_controller/index/$1/$2';
$route ['vouchertypeFormSearchList']     = 'promotion/vouchertype/Vouchertype_controller/FSxCVOCFormSearchList';
$route ['VoucherTypePageAdd']            = 'promotion/vouchertype/Vouchertype_controller/FSxCVOCAddPage';
$route ['vouchertypeDataTable']          = 'promotion/vouchertype/Vouchertype_controller/FSxCVOTDataTable';
$route ['vouchertypePageEdit']           = 'promotion/vouchertype/Vouchertype_controller/FSvCVOTEditPage';
$route ['vouchertypeEventAdd']           = 'promotion/vouchertype/Vouchertype_controller/FSaCVOTAddEvent';
$route ['vouchertypeEventEdit']          = 'promotion/vouchertype/Vouchertype_controller/FSaCVOTEditEvent';
$route ['vouchertypeEventDelete']        = 'promotion/vouchertype/Vouchertype_controller/FSaCVOTDeleteEvent';


//Coupon (คูปอง)
$route ['coupon/(:any)/(:any)']     = 'coupon/coupon/Coupon_controller/index/$1/$2';
$route ['couponFormSearchList']     = 'coupon/coupon/Coupon_controller/FSxCCPNFormSearchList';
$route ['couponPageAdd']            = 'coupon/coupon/Coupon_controller/FSxCCPNAddPage';
$route ['couponDataTable']          = 'coupon/coupon/Coupon_controller/FSxCCPNDataTable';
$route ['couponPageEdit']           = 'coupon/coupon/Coupon_controller/FSvCCPNEditPage';
$route ['couponEventAdd']           = 'coupon/coupon/Coupon_controller/FSaCCPNAddEvent';
$route ['couponEventEdit']          = 'coupon/coupon/Coupon_controller/FSaCCPNEditEvent';
$route ['couponEventDelete']        = 'coupon/coupon/Coupon_controller/FSaCCPNDeleteEvent';


//type Coupon (ประเภทคูปอง)
$route ['coupontype/(:any)/(:any)']      = 'coupon/coupontype/Coupontype_controller/index/$1/$2';
$route ['CoupontypeFormSearchList']      = 'coupon/coupontype/Coupontype_controller/FSxCCPTFormSearchList';
$route ['CoupontypePageAdd']             = 'coupon/coupontype/Coupontype_controller/FSxCCPTAddPage';
$route ['CoupontypeDataTable']           = 'coupon/coupontype/Coupontype_controller/FSxCCPTDataTable';
$route ['CoupontypePageEdit']            = 'coupon/coupontype/Coupontype_controller/FSvCCPTEditPage';
$route ['CoupontypeEventAdd']            = 'coupon/coupontype/Coupontype_controller/FSaCCPTAddEvent';
$route ['CoupontypeEventEdit']           = 'coupon/coupontype/Coupontype_controller/FSaCCPTEditEvent';
$route ['CoupontypeEventDelete']         = 'coupon/coupontype/Coupontype_controller/FSaCCPTDeleteEvent';


//cardcoupon (คูปองบัตร)
$route ['cardcoupon/(:any)/(:any)']         = 'coupon/cardcoupon/Cardcoupon_controller/index/$1/$2';
$route ['CardCouponPageAdd']                = 'coupon/cardcoupon/Cardcoupon_controller/FSxCCCLAddPage';
$route ['CardCouponEventAdd']               = 'coupon/cardcoupon/Cardcoupon_controller/FSaCCCLAddEvent';
$route ['CardCouponPageEdit']               = 'coupon/cardcoupon/Cardcoupon_controller/FSvCCCLEditPage';
$route ['CardCouponFormSearchList']         = 'coupon/cardcoupon/Cardcoupon_controller/FSxCCCLFormSearchList';
$route ['CardCouponDataTable']              = 'coupon/cardcoupon/Cardcoupon_controller/FSxCCCLDataTable';
$route ['CardCouponEventEdit']              = 'coupon/cardcoupon/Cardcoupon_controller/FSaCCCLEditEvent';
$route ['CardCouponEventDelete']            = 'coupon/cardcoupon/Cardcoupon_controller/FSaCCCLDeleteEvent';



