<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\NoMiddlewareController;
use App\Http\Controllers\AppsettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;
// use App\Http\Controllers\PackageController;



// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/storage-link', function () {
//     \Artisan::call('storage:link');
//     return redirect('/');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::controller(FrontController::class)->group(function () {
	Route::get('/', 'home')->name('home');
	// Route::get('about-us', 'aboutUs')->name('about-us');
	Route::get('contact-us', 'contactUs')->name('contact-us');
	Route::post('contact-us', 'contactUsStore')->name('contact-us');
	Route::get('faqs', 'faqs')->name('faqs');
	// Route::get('privacy-policy', 'privacyPolicy')->name('privacy-policy');
	// Route::get('terms-and-conditions', 'termsAndConditions')->name('terms-and-conditions');
	Route::get('careers', 'careers')->name('careers');
	Route::get('career/{slug?}', 'career')->name('career');
	Route::get('destinations', 'destinations')->name('destinations');
	Route::get('galleries', 'galleries')->name('galleries');
	Route::get('activities', 'activities')->name('activities');
	Route::get('activity-detail/{slug}', 'activityDetail')->name('activity-detail');
	Route::get('blogs', 'blogs')->name('blogs');
	Route::get('blog-detail/{slug}', 'blogDetail')->name('blog-detail');
	Route::get('vlogs', 'vlogs')->name('vlogs');
	Route::get('vlog-detail/{slug}', 'vlogDetail')->name('vlog-detail');
	Route::get('travel-courses', 'travelCourses')->name('travel-courses');
	Route::get('travel-course-detail/{slug}', 'travelCourseDetail')->name('travel-course-detail');

	Route::post('newsletter-save', 'newsletterSave')->name('newsletter-save');
	Route::post('comment-save', 'commentSave')->name('comment-save')->middleware('auth');
	Route::post('swich-language', 'swichLanguage')->name('swich-language');
	Route::post('swich-currency', 'swichCurrency')->name('swich-currency');

	Route::get('visa-inquiry', 'visaInquiry')->name('visa-inquiry');
	Route::get('insurance-inquiry', 'insuranceInquiry')->name('insurance-inquiry');

	Route::post('visa-save', 'visaSave')->name('visa-save');
	Route::post('insurance-save', 'insuranceSave')->name('insurance-save');
	Route::get('thankyou', 'thankyou')->name('thankyou');
	Route::get('testimonials', 'testimonials')->name('testimonials');

});

Route::controller(App\Http\Controllers\PackageController::class)->group(function () {
	Route::get('packages', 'packages')->name('packages');
	Route::get('packages-filter', 'packagesFilter')->name('packages-filter');
	Route::get('package-detail/{slug}', 'packageDetail')->name('package-detail');
	Route::post('booking-save', 'bookingSave')->name('booking-save')->middleware('auth');
	Route::post('rating-save', 'ratingSave')->name('rating-save');
	Route::post('apply-coupon', 'applyCoupon')->name('apply-coupon');
	Route::post('inquiry-store', 'inquiryStore')->name('inquiry-store');
});

Route::get('home',function(){
	return redirect('admin/login');
});

Route::get('admin/login', function () {
    if (\Auth::check()) {
    	if(auth()->user()->userType=='admin')
    	{
    		return redirect('admin/dashboard');
    	}
    	else
    	{
    		return redirect('user/dashboard');
    	}  
    }
    return view('admin.auth.login');
});

Route::get('sign-up', 'App\Http\Controllers\SignUpController@signUp')->name('sign-up');
Route::post('signup-save', 'App\Http\Controllers\SignUpController@signUpSave')->name('signup-save');
Route::post('user-login', 'App\Http\Controllers\AuthController@login')->name('user.login');
Route::post('verify-otp', 'App\Http\Controllers\AuthController@verifyOtp')->name('verify-otp');

Route::post('user-register', 'App\Http\Controllers\AuthController@register')->name('user.register');

Route::get('login/{provider}', [SocialAuthController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

Route::get('screen-lock/{currtime}/{id}/{randnum}', 'App\Http\Controllers\Admin\NoMiddlewareController@screenlock')->name('screenlock');
Route::get('email-verification/{id}/{hash}', 'SignUpController@emailVerify');

Auth::routes(['verify' => true]);



Route::group(['middleware' => 'auth'], function () {
	// Route::post('/logout', 'AdminController@logout')->name('logout');

	

	Route::group(['prefix' => 'user','namespace' => 'App\Http\Controllers\User'], function () {
		Route::get('dashboard', 'AccountController@dashboard')->name('user.dashboard');
		Route::get('edit-profile', 'AccountController@editprofile')->name('user.edit-profile');
		Route::post('update-profile', 'AccountController@updateprofile')->name('user.update-profile');
		Route::post('change-password', 'AccountController@changePassword')->name('user-change-password');
		Route::get('bookings', 'AccountController@bookings')->name('user.bookings');

		/*-------Blogs----------------------------*/
		Route::controller(BlogController::class)->group(function () {
			Route::get('blogs-list', 'index')->name('user.blogs-list');
			Route::get('add-blog', 'create')->name('user.blog-create');
			Route::get('edit-blog/{id}', 'edit')->name('user.blog-edit');
			Route::get('view-blog/{id}', 'show')->name('user.blog-view');
			Route::post('saveblog', 'store')->name('user.blog-save');
			Route::get('delete-blog/{id}', 'destroy')->name('user.blog-delete');
		});

		/*-------Blogs----------------------------*/
		Route::controller(VlogController::class)->group(function () {
			Route::get('vlogs-list', 'index')->name('user.vlogs-list');
			Route::get('add-vlog', 'create')->name('user.vlog-create');
			Route::get('edit-vlog/{id}', 'edit')->name('user.vlog-edit');
			Route::get('view-vlog/{id}', 'show')->name('user.vlog-view');
			Route::post('savevlog', 'store')->name('user.vlog-save');
			Route::get('delete-vlog/{id}', 'destroy')->name('user.vlog-delete');
		});
	});
	
	Route::group(['middleware' => 'admin', 'prefix' => 'admin','namespace' => 'App\Http\Controllers\Admin'], function () {
		/*--------------- App Settings ---------------------*/
		Route::get('app-setting', 'AppsettingController@appSetting')->name('app-setting');
		Route::post('app-setting-update', 'AppsettingController@appSettingUpdate')->name('app-setting-update');

		Route::get('home-page', 'AppsettingController@homePage')->name('home-page');
		Route::post('home-page-update', 'AppsettingController@homePageUpdate')->name('home-page-update');
		Route::post('remove-hero-image', 'AppsettingController@removeHeroImage')->name('remove-hero-image');
		Route::post('remove-banner-image', 'AppsettingController@removeBannerImage')->name('remove-banner-image');



		Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
		Route::get('/edit-profile', 'AdminController@editprofile')->name('edit-profile');
		Route::post('/change-password', 'AdminController@changePassword')->name('change-password');
		Route::post('/update-profile', 'AdminController@updateProfile')->name('update-profile');
		Route::get('need-help', 'NoMiddlewareController@needhelp')->name('need-help');

		/*-------Users----------------------------*/
		Route::controller(UserController::class)->group(function () {
			Route::get('users-list', 'index')->name('users-list');
			Route::get('add-user', 'create')->name('user-create');
			Route::get('edit-user/{uuid}', 'edit')->name('user-edit');
			Route::get('view-user/{uuid}', 'show')->name('user-view');
			Route::post('saveuser', 'store')->name('user-save');
			Route::get('delete-user/{uuid}', 'destroy')->name('user-delete');
			Route::post('actionUsers', 'action')->name('user-action');
		});


		/*-------Menus----------------------------*/
		Route::get('menus-list', 'MenuController@menus')->name('menus-list');
		Route::get('add-menu', 'MenuController@addmenu')->name('menu-create');
		Route::get('edit-menu/{id}', 'MenuController@editmenu')->name('menu-edit');
		Route::get('view-menu/{id}', 'MenuController@viewmenu')->name('menu-view');
		Route::post('savemenu', 'MenuController@savemenu')->name('menu-save');
		Route::get('delete-menu/{id}', 'MenuController@deletemenu')->name('menu-delete');
		Route::post('actionMenus', 'MenuController@actionMenus')->name('menu-action');
		Route::post('menu-update-status', 'MenuController@updateStatus')->name('menu-update-status');

		/*-------Destinations----------------------------*/
		Route::controller(DestinationController::class)->group(function () {
			Route::get('destinations-list', 'index')->name('destinations-list');
			Route::get('add-destination', 'create')->name('destination-create');
			Route::get('edit-destination/{id}', 'edit')->name('destination-edit');
			Route::get('view-destination/{id}', 'show')->name('destination-view');
			Route::post('savedestination', 'store')->name('destination-save');
			Route::get('delete-destination/{id}', 'destroy')->name('destination-delete');
			Route::post('actionDestinations', 'action')->name('destination-action');
		});

		/*-------Packages----------------------------*/
		Route::controller(PackageController::class)->group(function () {
			Route::get('packages-list', 'index')->name('packages-list');
			Route::get('add-package', 'create')->name('package-create');
			Route::get('edit-package/{id}', 'edit')->name('package-edit');
			Route::get('view-package/{id}', 'show')->name('package-view');
			Route::post('savepackage', 'store')->name('package-save');
			Route::get('delete-package/{id}', 'destroy')->name('package-delete');
			Route::post('actionPackages', 'action')->name('package-action');
			Route::post('action-setting', 'setting')->name('package-setting');
			Route::delete('package-image-delete', 'imageDestroy')->name('package-image-delete');
			Route::get('get-destinations', 'getDestinations')->name('get-destinations');
			Route::get('get-package-types', 'getPackageTypes')->name('get-package-types');

			Route::get('add-activity', 'create')->name('activity-create');
			Route::get('view-activity/{id}', 'show')->name('activity-view');
			Route::get('edit-activity/{id}', 'edit')->name('activity-edit');
			Route::post('saveactivity', 'store')->name('activity-save');
			Route::get('delete-activity/{id}', 'destroy')->name('activity-delete');
			Route::post('actionActivities', 'action')->name('activity-action');
		});


		/*-------Blogs----------------------------*/
		Route::controller(BlogController::class)->group(function () {
			Route::get('blogs-list', 'index')->name('blogs-list');
			Route::get('add-blog', 'create')->name('blog-create');
			Route::get('edit-blog/{id}', 'edit')->name('blog-edit');
			Route::get('view-blog/{id}', 'show')->name('blog-view');
			Route::post('saveblog', 'store')->name('blog-save');
			Route::get('delete-blog/{id}', 'destroy')->name('blog-delete');
			Route::post('actionBlogs', 'action')->name('blog-action');
		});

		/*-------Vlogs----------------------------*/
		Route::controller(VlogController::class)->group(function () {
			Route::get('vlogs-list', 'index')->name('vlogs-list');
			Route::get('add-vlog', 'create')->name('vlog-create');
			Route::get('edit-vlog/{id}', 'edit')->name('vlog-edit');
			Route::get('view-vlog/{id}', 'show')->name('vlog-view');
			Route::post('savevlog', 'store')->name('vlog-save');
			Route::get('delete-vlog/{id}', 'destroy')->name('vlog-delete');
			Route::post('actionVlogs', 'action')->name('vlog-action');
		});


		/*-------TravelCourses----------------------------*/
		Route::controller(TravelCourseController::class)->group(function () {
			Route::get('travel-courses-list', 'index')->name('travel-courses-list');
			Route::get('add-travel-course', 'create')->name('travel-course-create');
			Route::get('edit-travel-course/{id}', 'edit')->name('travel-course-edit');
			Route::get('view-travel-course/{id}', 'show')->name('travel-course-view');
			Route::post('save-travel-course', 'store')->name('travel-course-save');
			Route::get('delete-travel-course/{id}', 'destroy')->name('travel-course-delete');
			Route::post('action-travel-courses', 'action')->name('travel-course-action');
		});

		/*-------Categories----------------------------*/
		Route::controller(CategoryController::class)->group(function () {
			Route::get('categories-list', 'index')->name('categories-list');
			Route::get('add-category', 'create')->name('category-create');
			Route::get('edit-category/{id}', 'edit')->name('category-edit');
			Route::post('savecategory', 'store')->name('category-save');
			Route::get('delete-category/{id}', 'destroy')->name('category-delete');
			Route::post('actionCategories', 'action')->name('category-action');
		});


		/*-------career----------------------------*/
		Route::controller(CareerController::class)->group(function () {
			Route::get('career-list', 'index')->name('career-list');
			Route::get('add-career', 'create')->name('career-create');
			Route::get('edit-career/{id}', 'edit')->name('career-edit');
			Route::post('savecareer', 'store')->name('career-save');
			Route::get('delete-career/{id}', 'destroy')->name('career-delete');
			Route::post('actionCareer', 'action')->name('career-action');
		});


		/*---------------------------FAQ-------------------------*/
		Route::controller(FaqController::class)->group(function () {
		    Route::get('faqs-list', 'index')->name('faqs-list');
			Route::get('add-faq', 'create')->name('faq-create');
			Route::get('edit-faq/{id}', 'edit')->name('faq-edit');
			Route::post('savefaq', 'store')->name('faq-save');
			Route::get('delete-faq/{id}', 'destroy')->name('faq-delete');
		});

		/*---------------------------Service-------------------------*/
		Route::controller(ServiceController::class)->group(function () {
		    Route::get('services-list', 'index')->name('services-list');
			Route::get('add-service', 'create')->name('service-create');
			Route::get('edit-service/{id}', 'edit')->name('service-edit');
			Route::post('saveservice', 'store')->name('service-save');
			Route::get('delete-service/{id}', 'destroy')->name('service-delete');
			Route::post('actionServices', 'action')->name('service-action');
		});

		/*---------------------------Address-------------------------*/
		Route::controller(AddressController::class)->group(function () {
		    Route::get('addresses-list', 'index')->name('addresses-list');
			Route::get('add-address', 'create')->name('address-create');
			Route::get('edit-address/{id}', 'edit')->name('address-edit');
			Route::post('saveaddress', 'store')->name('address-save');
			Route::get('delete-address/{id}', 'destroy')->name('address-delete');
			Route::post('actionAddresses', 'action')->name('address-action');
		});

		/*---------------------------Role-------------------------*/
		Route::controller(RoleController::class)->group(function () {
		    Route::get('roles-list', 'index')->name('roles-list');
			Route::get('add-role', 'create')->name('role-create');
			Route::get('edit-role/{id}', 'edit')->name('role-edit');
			Route::post('saverole', 'store')->name('role-save');
			Route::get('delete-role/{id}', 'destroy')->name('role-delete');
			Route::post('actionRoles', 'action')->name('role-action');
		});

		/*---------------------------Permission-------------------------*/
		Route::controller(PermissionController::class)->group(function () {
		    Route::get('permissions-list', 'index')->name('permissions-list');
			Route::get('add-permission', 'create')->name('permission-create');
			Route::get('edit-permission/{id}', 'edit')->name('permission-edit');
			Route::post('savepermission', 'store')->name('permission-save');
			Route::get('delete-permission/{id}', 'destroy')->name('permission-delete');
			Route::post('actionPermissions', 'action')->name('permission-action');
		});

		/*---------------------------Language-------------------------*/
		Route::controller(LanguageController::class)->group(function () {
		    Route::get('languages-list', 'index')->name('languages-list');
			Route::get('add-language', 'create')->name('language-create');
			Route::get('edit-language/{id}', 'edit')->name('language-edit');
			Route::post('savelanguage', 'store')->name('language-save');
			Route::get('delete-language/{id}', 'destroy')->name('language-delete');
			Route::post('actionLanguages', 'action')->name('language-action');
		});

		/*-------Currencies----------------------------*/
		Route::controller(CurrencyController::class)->group(function () {
			Route::get('currencies-list', 'index')->name('currencies-list');
			Route::get('add-currency', 'create')->name('currency-create');
			Route::get('edit-currency/{id}', 'edit')->name('currency-edit');
			Route::post('savecurrency', 'store')->name('currency-save');
			Route::get('delete-currency/{id}', 'destroy')->name('currency-delete');
			Route::post('actionCurrencies', 'action')->name('currency-action');
		});

		/*-------PromotionAndDiscount----------------------------*/
		Route::controller(PromotionAndDiscountController::class)->group(function () {
			Route::get('promotion-and-discounts-list', 'index')->name('promotion-and-discounts-list');
			Route::get('add-promotion-and-discount', 'create')->name('promotion-and-discount-create');
			Route::get('edit-promotion-and-discount/{id}', 'edit')->name('promotion-and-discount-edit');
			Route::get('view-promotion-and-discount/{id}', 'show')->name('promotion-and-discount-view');
			Route::post('save-promotion-and-discount', 'store')->name('promotion-and-discount-save');
			Route::get('delete-promotion-and-discount/{id}', 'destroy')->name('promotion-and-discount-delete');
			Route::post('action-promotion-and-discounts', 'action')->name('promotion-and-discount-action');
		});

		/*-------Dynamic Page----------------------------*/
		Route::controller(DynamicPageController::class)->group(function () {
			Route::get('dynamic-pages-list', 'index')->name('dynamic-pages-list');
			Route::get('add-dynamic-page', 'create')->name('dynamic-page-create');
			Route::get('edit-dynamic-page/{id}', 'edit')->name('dynamic-page-edit');
			Route::get('view-dynamic-page/{id}', 'show')->name('dynamic-page-view');
			Route::post('save-dynamic-page', 'store')->name('dynamic-page-save');
			Route::get('delete-dynamic-page/{id}', 'destroy')->name('dynamic-page-delete');
			Route::post('action-dynamic-pages', 'action')->name('dynamic-page-action');
		});

		/*-------Contact Us----------------------------*/
		Route::controller(ContactUsController::class)->group(function () {
			Route::get('contact-us-list', 'index')->name('contact-us-list');
			Route::get('contact-us-delete/{id}', 'destroy')->name('contact-us-delete');
			Route::post('contact-us-action', 'action')->name('contact-us-action');
		});

		/*-------Review And Rating----------------------------*/
		Route::controller(ReviewAndRatingController::class)->group(function () {
			Route::get('review-and-ratings-list', 'index')->name('review-and-ratings-list');
			Route::get('add-review-and-rating', 'create')->name('review-and-rating-create');
			Route::get('edit-review-and-rating/{id}', 'edit')->name('review-and-rating-edit');
			Route::get('view-review-and-rating/{id}', 'show')->name('review-and-rating-view');
			Route::post('save-review-and-rating', 'store')->name('review-and-rating-save');
			Route::get('review-and-rating-delete/{id}', 'destroy')->name('review-and-rating-delete');
			Route::post('review-and-rating-action', 'action')->name('review-and-rating-action');
		});

		/*-------Newsletter----------------------------*/
		Route::controller(NewsletterController::class)->group(function () {
			Route::get('newsletter-list', 'index')->name('newsletter-list');
			Route::get('newsletter-delete/{id}', 'destroy')->name('newsletter-delete');
			Route::post('newsletter-action', 'action')->name('newsletter-action');
			Route::get('newsletter-export', 'export')->name('newsletter-export');
		});

		/*-------Booking----------------------------*/
		Route::controller(BookingInquiryController::class)->group(function () {
			Route::get('booking-inquiries-list', 'index')->name('booking-inquiries-list');
			Route::get('booking-inquiry-delete/{id}', 'destroy')->name('booking-inquiry-delete');
			Route::post('booking-inquiry-action', 'action')->name('booking-inquiry-action');
		});

		/*-------Booking----------------------------*/
		Route::controller(InquiryController::class)->group(function () {
			Route::get('inquiries-list', 'index')->name('inquiries-list');
			Route::get('inquiry-delete/{id}', 'destroy')->name('inquiry-delete');
		});

		/*-------EmailTemplate----------------------------*/
		Route::controller(EmailTemplateController::class)->group(function () {
			Route::get('email-templates-list', 'index')->name('email-templates-list');
			Route::get('add-email-template', 'create')->name('email-template-create');
			Route::get('edit-email-template/{id}', 'edit')->name('email-template-edit');
			Route::get('view-email-template/{id}', 'show')->name('email-template-view');
			Route::post('save-email-template', 'store')->name('email-template-save');
			Route::get('delete-email-template/{id}', 'destroy')->name('email-template-delete');
			Route::post('action-email-templates', 'action')->name('email-template-action');
		});

		/*-------ProFormaInvoice----------------------------*/
		Route::controller(ProFormaInvoiceController::class)->group(function () {
			Route::get('pro-forma-invoices-list', 'index')->name('pro-forma-invoices-list');
			Route::get('add-pro-forma-invoice', 'create')->name('pro-forma-invoice-create');
			Route::get('edit-pro-forma-invoice/{id}', 'edit')->name('pro-forma-invoice-edit');
			Route::get('view-pro-forma-invoice/{id}', 'show')->name('pro-forma-invoice-view');
			Route::post('save-pro-forma-invoice', 'store')->name('pro-forma-invoice-save');
			Route::get('delete-pro-forma-invoice/{id}', 'destroy')->name('pro-forma-invoice-delete');
			Route::post('action-pro-forma-invoices', 'action')->name('pro-forma-invoice-action');
			Route::get('pdf-pro-forma-invoice/{id}', 'pdf')->name('pro-forma-invoice-pdf');
		});

		/*---------------------------Activity-------------------------*/
		Route::controller(ActivityController::class)->group(function () {
		    Route::get('activities-list', 'index')->name('activities-list');
			// Route::get('add-activity', 'create')->name('activity-create');
			// Route::get('view-activity', 'show')->name('activity-view');
			// Route::get('edit-activity/{id}', 'edit')->name('activity-edit');
			// Route::post('saveactivity', 'store')->name('activity-save');
			// Route::get('delete-activity/{id}', 'destroy')->name('activity-delete');
			// Route::post('actionActivities', 'action')->name('activity-action');
		});

		/*-------BankDetail----------------------------*/
		Route::controller(BankDetailController::class)->group(function () {
			Route::get('bank-details-list', 'index')->name('bank-details-list');
			Route::get('add-bank-detail', 'create')->name('bank-detail-create');
			Route::get('edit-bank-detail/{id}', 'edit')->name('bank-detail-edit');
			Route::get('view-bank-detail/{id}', 'show')->name('bank-detail-view');
			Route::post('save-bank-detail', 'store')->name('bank-detail-save');
			Route::get('delete-bank-detail/{id}', 'destroy')->name('bank-detail-delete');
			Route::post('action-bank-details', 'action')->name('bank-detail-action');
		});

		/*-------Booking----------------------------*/
		Route::controller(VisaController::class)->group(function () {
			Route::get('visas-list', 'index')->name('visas-list');
			Route::get('visa-delete/{id}', 'destroy')->name('visa-delete');
			Route::post('visa-action', 'action')->name('visa-action');
		    Route::get('visa-destinations', 'visaDestinations')->name('visa-destinations');
			Route::post('save-visa-destination', 'visaDestinationStore')->name('visa-destination-save');
			Route::get('delete-visa-destination/{id}', 'visaDestinationDestroy')->name('visa-destination-delete');
		});

		/*-------Booking----------------------------*/
		Route::controller(InsuranceController::class)->group(function () {
			Route::get('insurances-list', 'index')->name('insurances-list');
			Route::get('insurance-delete/{id}', 'destroy')->name('insurance-delete');
			Route::post('insurance-action', 'action')->name('insurance-action');
		});

		/*-------AdsManagement----------------------------*/
		Route::controller(AdsManagementController::class)->group(function () {
			Route::get('ads-managements-list', 'index')->name('ads-managements-list');
			Route::get('add-ads-management', 'create')->name('ads-management-create');
			Route::get('edit-ads-management/{id}', 'edit')->name('ads-management-edit');
			Route::get('view-ads-management/{id}', 'show')->name('ads-management-view');
			Route::post('save-ads-management', 'store')->name('ads-management-save');
			Route::get('delete-ads-management/{id}', 'destroy')->name('ads-management-delete');
			Route::post('ads-management-action', 'action')->name('ads-management-action');
		});

		/*-------Brands----------------------------*/
		Route::controller(BrandController::class)->group(function () {
			Route::get('brands-list', 'index')->name('brands-list');
			Route::post('savebrand', 'store')->name('brand-save');
			Route::get('delete-brand/{id}', 'destroy')->name('brand-delete');
			Route::delete('brand-image-delete', 'imageDestroy')->name('brand-image-delete');
		});

		/*-------FileUploads----------------------------*/
		Route::controller(FileUploadsController::class)->group(function () {
			Route::get('file-uploads-list', 'index')->name('file-uploads-list');
			Route::post('savefile-upload', 'store')->name('file-upload-save');
			Route::get('delete-file-upload/{id}', 'destroy')->name('file-upload-delete');
			Route::delete('file-upload-image-delete', 'imageDestroy')->name('file-upload-image-delete');
		});

		/*-------Gallery----------------------------*/
		Route::controller(GalleryController::class)->group(function () {
			Route::get('galleries-list', 'index')->name('galleries-list');
			Route::get('add-gallery', 'create')->name('gallery-create');
			Route::get('edit-gallery/{id}', 'edit')->name('gallery-edit');
			Route::get('view-gallery/{id}', 'show')->name('gallery-view');
			Route::post('savegallery', 'store')->name('gallery-save');
			Route::get('delete-gallery/{id}', 'destroy')->name('gallery-delete');
			Route::post('actionGallery', 'action')->name('gallery-action');
		});

		Route::controller(PackageTypeController::class)->group(function () {
			Route::get('package-types-list', 'index')->name('package-types-list');
			Route::get('add-package-type', 'create')->name('package-type-create');
			Route::get('edit-package-type/{id}', 'edit')->name('package-type-edit');
			Route::get('view-package-type/{id}', 'show')->name('package-type-view');
			Route::post('savepackage-type', 'store')->name('package-type-save');
			Route::get('delete-package-type/{id}', 'destroy')->name('package-type-delete');
			Route::post('action-package-type', 'action')->name('package-type-action');
		});
	});

});

Route::get('{slug}', 'App\Http\Controllers\FrontController@dynamicPage');


