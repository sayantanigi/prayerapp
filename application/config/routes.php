<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['about_us'] = 'Home/about_us';
$route['portfolio'] = 'Home/portfolio';
$route['guidelines'] = 'Home/guidelines';
$route['terms_and_condition'] = 'Home/terms_and_condition';
$route['event_details/(:any)'] = 'Home/event_details/$1';
$route['portfolio_details/(:any)'] = 'Home/portfolio_details/$1';
$route['privacy_policy'] = 'Home/privacy_policy';
$route['download'] = 'Home/download';
$route['contact'] = 'Home/contact';
$route['delete_account'] = 'Home/delete_account';
$route['completed'] = 'Home/completed';
$route['checkout/(:any)/(:any)'] = 'Home/checkout/$1/$2';
$route['cancel'] = 'Home/cancel';
$route['email-verification/(:any)'] = 'Home/email_verification/$1';

//ADMIN URL
$route['admin'] = 'admin/login/index';
$route['admin/logout'] = 'admin/login/logout';
$route['admin/dashboard'] = 'admin/login/dashboard';
$route['admin/profile'] = 'admin/login/profile';
$route['admin/manage_events'] = 'admin/manage_events/index';
$route['admin/company-logo'] = 'admin/manage_home/Company_logo/index';
$route['admin/career'] = 'admin/manage_home/Career_tips/index';
$route['admin/our-services'] = 'admin/manage_home/Our_services/index';
$route['admin/banner'] = 'admin/Banner/index';
$route['admin/email-template'] = 'admin/Email_template/index';
$route['admin/chat_details/(:any)/(:any)'] = "admin/chat/adminShowMessage_list/$1/$2";
$route['admin/deletepostdetail'] = "admin/Post_job/deletepostdetail";
$route['admin/update-postjob/(:any)'] = "admin/Post_job/update_post_job/$1";
$route['admin/product-category'] = 'admin/Product_category/index';
$route['admin/all-product'] = 'admin/Product/index';

//API URLS
$route['api/registration'] = 'api/Authentication/registration';
$route['api/email-verification/(:any)'] = "api/Authentication/emailVerification/$1";
$route['api/login'] = 'api/Authentication/login';
$route['api/send_forget_password'] = 'api/Authentication/send_forget_password';
$route['api/set_new_password'] = 'api/Authentication/set_new_password';
$route['api/profile'] = 'api/User_dashboard/profile_settings';
$route['api/update_profile'] = 'api/User_dashboard/update_profile';
$route['api/updateProfilePics'] = 'api/User_dashboard/updateProfilePics';
$route['api/homeList'] = "api/Home/home_list";
$route['api/about_us'] = 'api/Home/about_us';
$route['api/privacy_policy'] = 'api/Home/privacy_policy';
$route['api/contact'] = 'api/Home/contact';
$route['api/save_contact'] = 'api/Home/save_contact';
$route['api/term_and_conditions'] = 'api/Home/term_and_conditions';
$route['api/add_prayer'] = "api/User_dashboard/add_prayer";
$route['api/edit_prayer'] = "api/User_dashboard/edit_prayer";
$route['api/update_prayer'] = "api/User_dashboard/update_prayer";
$route['api/prayerListByEachOrganizer'] = "api/User_dashboard/prayerListByEachOrganizer";
$route['api/prayer_details'] = "api/User_dashboard/prayer_details";
$route['api/userJoinedEvent'] = "api/User_dashboard/userJoinedEvent";
$route['api/userlikedEvent'] = "api/User_dashboard/userlikedEvent";
$route['api/userlikedPodcast'] = "api/User_dashboard/userlikedPodcast";
$route['api/likedPodcast'] = "api/User_dashboard/LikedPodcast";
$route['api/ListofupcomingPrayers'] = "api/User_dashboard/ListofupcomingPrayers";
$route['api/ListofPrayers'] = "api/User_dashboard/ListofPrayers";
$route['api/ListofnewPrayers'] = "api/User_dashboard/ListofnewPrayers";
$route['api/ListofupcomingPrayer'] = "api/User_dashboard/ListofupcomingPrayer";
$route['api/ListofPodcast'] = "api/User_dashboard/ListofPodcast";
$route['api/allVideoList'] = "api/User_dashboard/allVideoList";
$route['api/search_video'] = "api/User_dashboard/search_video";
$route['api/search_prayer'] = "api/User_dashboard/search_prayer";
$route['api/joinedPrayerDetails'] = "api/User_dashboard/joinedPrayerDetails";
$route['api/userJoinedPrayer'] = "api/User_dashboard/userJoinedPrayer";
$route['api/add_podcast'] = "api/User_dashboard/add_podcast";
$route['api/edit_podcast'] = "api/User_dashboard/edit_podcast";
$route['api/update_podcast'] = "api/User_dashboard/update_podcast";
$route['api/podcastListByEachOrganizer'] = "api/User_dashboard/podcastListByEachOrganizer";
$route['api/podcast_details'] = "api/User_dashboard/podcast_details";
$route['api/add_video'] = "api/User_dashboard/add_video";
$route['api/edit_video'] = "api/User_dashboard/edit_video";
$route['api/update_video'] = "api/User_dashboard/update_video";
$route['api/videoListByEachOrganizer'] = "api/User_dashboard/videoListByEachOrganizer";
$route['api/video_details'] = "api/User_dashboard/video_details";
$route['api/users_video_details'] = "api/User_dashboard/users_video_details";
$route['api/product_category'] = "api/User_dashboard/product_category";
$route['api/product_list'] = "api/User_dashboard/product_list";
$route['api/productByCategory'] = "api/User_dashboard/productByCategory";
$route['api/productDetails'] = "api/User_dashboard/productDetails";
$route['api/featured_product_list'] = "api/User_dashboard/featured_product_list";
$route['api/search_product'] = "api/User_dashboard/search_product";
$route['api/filter_search'] = "api/User_dashboard/filter_search";
$route['api/userAddress_list'] = "api/User_dashboard/userAddress_list";
$route['api/add_address'] = "api/User_dashboard/add_address";
$route['api/edit_address'] = "api/User_dashboard/edit_address";
$route['api/update_address'] = "api/User_dashboard/update_address";
$route['api/add_to_cart'] = "api/User_dashboard/add_to_cart";
$route['api/total_cart'] = "api/User_dashboard/total_cart";
$route['api/cart_list'] = "api/User_dashboard/cart_list";
$route['api/update_cart_list'] = 'api/User_dashboard/update_cart_list';
$route['api/remove_cart_list'] = 'api/User_dashboard/remove_cart_list';
$route['api/add_card'] = 'api/User_dashboard/add_card';
$route['api/get_card'] = 'api/User_dashboard/get_card';
$route['api/proceed_to_pay'] = 'api/User_dashboard/proceed_to_pay';
$route['api/add_social_post'] = 'api/User_dashboard/add_social_post';
$route['api/social_user_list'] = 'api/User_dashboard/social_user_list';
$route['api/socialListByUser'] = 'api/User_dashboard/social_listByUser';
$route['api/user_post_like'] = 'api/User_dashboard/user_post_like';
$route['api/user_post_dislike'] = 'api/User_dashboard/user_post_dislike';
$route['api/add_post_comment'] = 'api/User_dashboard/add_post_comment';
$route['api/user_post_details'] = 'api/User_dashboard/user_post_details';
$route['api/get_post_comment'] = 'api/User_dashboard/get_post_comment';
$route['api/addLikeForEachComment'] = 'api/User_dashboard/addLikeForEachComment';
$route['api/addDislikeForEachComment'] = 'api/User_dashboard/addDislikeForEachComment';
$route['api/add_post_comment_rply'] = 'api/User_dashboard/add_post_comment_rply';
$route['api/get_comment_reply'] = 'api/User_dashboard/get_comment_reply';
$route['api/delete_account'] = 'api/User_dashboard/deleteAccount';
$route['api/getOrganizationList'] = 'api/User_dashboard/getOrganizationList';
$route['api/donation_details'] = 'api/User_dashboard/donation_details';
$route['api/viewAllOrganization'] = 'api/User_dashboard/viewAllOrganization';
$route['api/organizationDetails'] = 'api/User_dashboard/organizationDetails';
$route['api/joined_organization'] = 'api/User_dashboard/joined_organization';
$route['api/checkout'] = 'api/User_dashboard/checkout';
$route['api/place_order'] = 'api/User_dashboard/place_order';
$route['api/order_list'] = 'api/User_dashboard/order_list';
$route['api/add_donation'] = 'api/User_dashboard/add_donation';
$route['api/donation_list'] = 'api/User_dashboard/donation_list';
$route['api/postPrayerWall'] = 'api/User_dashboard/postPrayerWall';
$route['api/ListAllPostonWall'] = 'api/User_dashboard/ListAllPostonWall';
$route['api/postwall_like'] = 'api/User_dashboard/postwall_like';
$route['api/set_alarm'] = 'api/User_dashboard/set_alarm';
$route['api/alarmList'] = 'api/User_dashboard/alarmList';
$route['api/editAlarm'] = 'api/User_dashboard/editAlarm';
$route['api/updateAlarm'] = 'api/User_dashboard/updateAlarm';
$route['api/alarmActiveInactive'] = 'api/User_dashboard/alarmActiveInactive';
$route['api/deletealarm'] = 'api/User_dashboard/deletealarm';