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
//ADMIN URL
$route['admin'] = 'admin/login/index';
$route['admin/logout'] = 'admin/login/logout';
$route['admin/dashboard'] = 'admin/login/dashboard';
$route['admin/profile'] = 'admin/login/profile';
$route['admin/manage_events'] = 'admin/manage_events/index';
$route['admin/company-logo'] = 'admin/manage_home/Company_logo/index';
$route['admin/career'] = 'admin/manage_home/Career_tips/index';
$route['admin/our-services'] = 'admin/manage_home/Our_services/index';
$route['admin/banner'] = 'admin/manage_home/Banner/index';
$route['admin/email-template'] = 'admin/Email_template/index';
$route['admin/chat_details/(:any)/(:any)'] = "admin/chat/adminShowMessage_list/$1/$2";
$route['admin/deletepostdetail'] = "admin/Post_job/deletepostdetail";
$route['admin/update-postjob/(:any)'] = "admin/Post_job/update_post_job/$1";
//API URLS
$route['api/registration'] = 'api/Authentication/registration';
$route['api/email-verification/(:any)'] = "api/Authentication/emailVerification/$1";
$route['api/login'] = 'api/Authentication/login';
$route['api/send_forget_password'] = 'api/Authentication/send_forget_password';
$route['api/homeList'] = "api/Home/home_list";
$route['api/add_prayer'] = "api/User_dashboard/add_prayer";
$route['api/edit_prayer'] = "api/User_dashboard/edit_prayer";
$route['api/update_prayer'] = "api/User_dashboard/update_prayer";
$route['api/prayerListByEachOrganizer'] = "api/User_dashboard/prayerListByEachOrganizer";
$route['api/prayer_details'] = "api/User_dashboard/prayer_details";
$route['api/userJoinedEvent'] = "api/User_dashboard/userJoinedEvent";
$route['api/userlikedEvent'] = "api/User_dashboard/userlikedEvent";

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





$route['api/home_list'] = 'api/Home/home_list';
$route['api/vendor_lists'] = "api/Home/vendor_lists";
$route['api/vendor_detail'] = "api/Home/vendor_details";
$route['api/product_details'] = "api/Home/product_details";
$route['api/freelancer_lists'] = "api/Home/freelancer_lists";
$route['api/freelancer_detail'] = "api/Home/freelancer_details";
$route['api/post_details'] = 'api/Home/post_details';
$route['api/vendor_pricing'] = 'api/Home/vendor_pricing';
$route['api/freelancer_pricing'] = 'api/Home/freelancer_pricing';
$route['api/about'] = 'api/Home/about';
$route['api/contact'] = 'api/Home/contact';
$route['api/save_contact'] = 'api/Home/save_contact';
$route['api/privacy'] = 'api/Home/privacy';
$route['api/term_and_conditions'] = 'api/Home/term_and_conditions';
$route['api/careertips_details'] = 'api/Home/careertips_details';
$route['api/search_job'] = 'api/Home/search_job';
$route['api/user_subscription_details'] = "api/User_dashboard/subscription_details";
$route['api/user_subscription'] = "api/User_dashboard/userSubscription";
$route['api/getUserSubscriptionDetails'] = "api/User_dashboard/getUserSubscriptionDetails";
$route['api/user_profile'] = "api/User_dashboard/profile_settings";
$route['api/update_profile'] = "api/User_dashboard/update_profile";
$route['api/education_list'] = "api/User_dashboard/education_list";
$route['api/save_education'] = "api/User_dashboard/save_education";
$route['api/get_educationDetails'] = "api/User_dashboard/get_educationDetails";
$route['api/update_education'] = "api/User_dashboard/update_education";
$route['api/delete_education'] = "api/User_dashboard/delete_education";
$route['api/workexperience_list'] = "api/User_dashboard/workexperience_list";
$route['api/save_workexperience'] = "api/User_dashboard/save_workexperience";
$route['api/get_workexperience'] = "api/User_dashboard/get_workexperience";
$route['api/update_workexperience'] = "api/User_dashboard/update_workexperience";
$route['api/delete_workexperience'] = "api/User_dashboard/delete_workexperience";
$route['api/myjob'] = "api/User_dashboard/myjob";
$route['api/save_postjob'] = "api/User_dashboard/save_postjob";
$route['api/edit_post_job'] = "api/User_dashboard/edit_post_job";
$route['api/update_post_job'] = "api/User_dashboard/update_post_job";
$route['api/save_postbid'] = "api/User_dashboard/save_postbid";
$route['api/jobbid'] = "api/User_dashboard/jobbid";
$route['api/delete_job'] = "api/User_dashboard/delete_job";
$route['api/products'] = "api/User_dashboard/products";
$route['api/delete_product'] = "api/User_dashboard/delete_product";
$route['api/delete_product_image'] = "api/User_dashboard/delete_product_image";
$route['api/save_employer_rating'] = "api/User_dashboard/save_employer_rating";
$route['api/chatUser_list'] = "api/User_dashboard/chatUser_list";
$route['api/showmessage_count'] = "api/User_dashboard/showmessage_count";
$route['api/showmessageCountEach'] = "api/User_dashboard/showmessageCountEach";
$route['api/showmessage_list'] = "api/User_dashboard/showmessage_list";
//$route['api/home_list'] = 'api/Home/home_list';