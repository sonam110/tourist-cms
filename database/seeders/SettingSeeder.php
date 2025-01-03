<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomePage;

use App\Models\User;
use App\Models\Currency;
use App\Models\DynamicPage;
use App\Models\Language;
use App\Models\AppSetting;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Service;
use App\Models\Activity;
use App\Models\Address;
use App\Models\BankDetail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use Str;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$languages = ["en" => 'English', 'hi' => 'Hindi', 'fr' => 'French', 'sp' => 'Spanish', 'khr' => 'KHR'];

    	foreach ($languages as $key => $language) {
    		Language::create([
    			'name' => $language,
    			'value' => $key,
    			'status' => '1'
    		]);
    	}

    	$currencies = ["₹" => 'INR', '$' => 'USD', '.إ' => 'AED', '€' => 'EURO', '£' => 'POUND'];

    	foreach ($currencies as $key => $currency) {
    		Currency::create([
    			'name' => $currency,
    			'icon' => $key,
    			'status' => '1'
    		]);
    	}

    	$categories = ["Education","Tourism","Activities","Knowledge","Spiritual",];

    	foreach ($categories as $key => $category) {
    		Category::create([
    			'name' => $category,
    			'parent_id' => NULL,
    			'status' => '1'
    		]);
    	}

    	$services = ["Ramta Yogi","Adventure","sightseeing","Historical","Incidental",];

    	foreach ($services as $key => $service) {
    		Service::create([
    			'name' => $service,
    			'parent_id' => NULL,
    			'status' => '1'
    		]);
    	}

    	$destinations = ["Andaman","Goa","Kerala","Laddakh","Delhi","Masoorie"];

    	foreach ($destinations as $key => $destination) {
    		Destination::create([
    			'name' => $destination,
    			'destination_type' => 1,
    			'image_path' => 'assets/img/noimage.jpg',
    			'status' => '1'
    		]);
    	}

    	DynamicPage::create([
    		"language_id"=>1,
    		'title'=>'About Us',
    		'slug' => 'about-us',
    		'sub_title'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel vulputate sem, eget porta massa. Sed mattis ac magna sit amet bibendum. Pellentesque tempus lorem ex, eget rhoncus erat molestie eu. Praesent porta purus eros, in rhoncus lacus condimentum imperdiet. Vivamus tristique venenatis tellus. Morbi finibus sed nibh in gravida. Nam ',
    		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel vulputate sem, eget porta massa. Sed mattis ac magna sit amet bibendum. Pellentesque tempus lorem ex, eget rhoncus erat molestie eu. Praesent porta purus eros, in rhoncus lacus condimentum imperdiet. Vivamus tristique venenatis tellus. Morbi finibus sed nibh in gravida. Nam quis malesuada nunc, eu congue quam. Donec tincidunt purus ut orci fermentum hendrerit. Integer ultrices iaculis aliquet.

    		Nam facilisis tellus eu leo aliquet commodo. Quisque egestas pharetra quam ut suscipit. Donec tincidunt lectus augue, vel sollicitudin ex dignissim vel. Nullam at pretium est, sit amet volutpat velit. Suspendisse quis pulvinar nunc. Etiam faucibus mauris non tincidunt eleifend. In iaculis arcu ac tellus aliquet, ut hendrerit mi tristique. Mauris tincidunt rhoncus vehicula. Duis est leo, hendrerit sed posuere quis, elementum vel purus. Vestibulum erat sem, tincidunt eget quam non, vehicula sodales nibh. Sed malesuada hendrerit hendrerit. Nulla facilisi. Vivamus lacinia libero a nibh condimentum, ac dapibus est maximus. Proin vulputate ",
    		'status'=>1
    	]);

    	$activities = [
    		[
    			"title" => "Zip Line",
    			"content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sed ligula nunc. Suspendisse orci elit, luctus sit amet sem a, vehicula sodales ex. Morbi eu accumsan nisi. In id vulputate sem. Nullam non massa sit amet mauris condimentum vulputate ut at ex. Nam non ligula ac mi rhoncus gravida. Aliquam nec gravida eros. Proin non tellus id erat iaculis tristique quis a sapien. Ut sodales mauris sed dictum dictum",
    			"image_path" => "img/images/travel-1.jpg"
    		],
    		[
    			"title" => "Kayaking",
    			"content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sed ligula nunc. Suspendisse orci elit, luctus sit amet sem a, vehicula sodales ex. Morbi eu accumsan nisi. In id vulputate sem. Nullam non massa sit amet mauris condimentum vulputate ut at ex. Nam non ligula ac mi rhoncus gravida. Aliquam nec gravida eros. Proin non tellus id erat iaculis tristique quis a sapien. Ut sodales mauris sed dictum dictum",
    			"image_path" => "img/images/travel-2.jpg"
    		],
    		[
    			"title" => "Bungee Jump",
    			"content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sed ligula nunc. Suspendisse orci elit, luctus sit amet sem a, vehicula sodales ex. Morbi eu accumsan nisi. In id vulputate sem. Nullam non massa sit amet mauris condimentum vulputate ut at ex. Nam non ligula ac mi rhoncus gravida. Aliquam nec gravida eros. Proin non tellus id erat iaculis tristique quis a sapien. Ut sodales mauris sed dictum dictum",
    			"image_path" => "img/images/travel-3.jpg"
    		],
    		[
    			"title" => "Canoeing",
    			"content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sed ligula nunc. Suspendisse orci elit, luctus sit amet sem a, vehicula sodales ex. Morbi eu accumsan nisi. In id vulputate sem. Nullam non massa sit amet mauris condimentum vulputate ut at ex. Nam non ligula ac mi rhoncus gravida. Aliquam nec gravida eros. Proin non tellus id erat iaculis tristique quis a sapien. Ut sodales mauris sed dictum dictum",
    			"image_path" => "img/images/travel-4.jpg"
    		],
    	];

    	foreach ($activities as $key => $activity) {
    		Activity::create([
    			'title' => $activity['title'],
    			'slug' => \Str::slug($activity['title']),
    			'content' => $activity['content'],
    			'image_path' => $activity['image_path'],
    			'status' => '1',
    			'seo_keyword' => $activity['title']
    		]);
    	}


    	DB::table('appsettings')->delete();
    	$appSetting = new Appsetting();
    	$appSetting->app_name    = 'Tourist Cms';
    	$appSetting->app_logo    = 'assets/images/logo.png';
    	$appSetting->footer_logo    = 'assets/images/logo.png';
    	$appSetting->fav_icon    = 'favicon.ico';
    	$appSetting->logo_thumb_path    = 'assets/images/logo.png';
    	$appSetting->email       = 'info@gmail.com';
    	$appSetting->address     = 'bhopal,India';
    	$appSetting->mobilenum   = '1234567898';
    	$appSetting->app_key       = Str::random(35);
    	$appSetting->default_language   = '1';
    	$appSetting->default_currency   = '1';
    	$appSetting->description = 'Turn your dream vacation into a reality with TuristicoMundo, where personalized itineraries, exclusive deals, and unforgettable experiences come together to create the perfect journey tailored just for you.';
    	$appSetting->footer_description = 'Turn your dream vacation into a reality with TuristicoMundo, where personalized itineraries, exclusive deals, and unforgettable experiences come together to create the perfect journey tailored just for you.';
    	$appSetting->save();

    	$address = new Address();
    	$address->title    = 'Default Address';
    	$address->email       = 'info@gmail.com';
    	$address->address     = 'bhopal,India';
    	$address->mobilenum   = '1234567898';
    	$address->website   = 'https://tourism.gofactz.com/';
    	$address->gst   = 'dsfw45t346';
    	$address->save();

    	$address = new BankDetail();
    	$address->account_name    = 'Default BankDetail';
    	$address->bank_name       = 'Bank Name';
    	$address->ifsc_code       = 'ICIC000045';
    	$address->branch_address     = 'bhopal,India';
    	$address->account_number   = '1234567898987065';
    	$address->upi_number   = '9876543212';
    	$address->save();

    	/*------------Default Role-----------------------------------*/
    	$role = Role::create([
    		'name' => 'Admin',
    		'guard_name' => 'web'
    	]);

    	$permissions = Permission::pluck('name');
    	$role->syncPermissions($permissions);

    	$user_permissions = ['package-browse','package-read','blog-browse','blog-read','blog-add','blog-edit','vlog-browse','vlog-read','vlog-add','vlog-edit','travel-course-browse','travel-course-read','travel-course-add','travel-course-edit','destination-browse','destination-read','destination-add','destination-edit','service-browse','service-read','service-add','service-edit','category-browse','category-read','category-add','category-edit','faq-browse','faq-read','faq-add','faq-edit','address-browse','address-read','address-add','address-edit','dashboard-browse','promotion-and-discount-browse','promotion-and-discount-read','promotion-and-discount-add','promotion-and-discount-edit','contact-us-browse','review-and-rating-browse','review-and-rating-read','review-and-rating-add','review-and-rating-edit','newsletter-browse','pro-forma-invoice-browse','pro-forma-invoice-read','pro-forma-invoice-add','pro-forma-invoice-edit','email-template-browse','email-template-read','email-template-add','email-template-edit','dynamic-page-browse','dynamic-page-read','dynamic-page-add','dynamic-page-edit','booking-inquiry-browse','booking-inquiry-read','booking-inquiry-add','booking-inquiry-edit'];

    	$role_employee = Role::create([
    		'name' => 'Employee',
    		'guard_name' => 'web'
    	]);
    	$role_employee->syncPermissions($user_permissions);

    	$homepage = new HomePage(); 
    	$homepage->title = 'Home Page Title';
    	$homepage->sub_title = 'Sub Title';
    	$homepage->short_description = 'short_description short_description short_description short_description short_description';
    	$homepage->banner_image_path = 'img/images/hero-img-2.jpg';
    	$homepage->image_path = json_encode(['img/images/hero-img-1.jpg']);
    	$homepage->video_path = 'https://youtu.be/iyd7qUH3oH0';
    	$homepage->duration = '12';
    	$homepage->promo = json_encode([
    		[
    			"icon_path" => "img/icon/promo-icon-1.png",
    			"title" => "prom content 1",
    			"description" => "scas eje jekv ejnve vjkvr vjrv jkv jkv ewgyjfgu fbjf jfbw"
    		],
    		[
    			"icon_path" => "img/icon/promo-icon-2.png",
    			"title" => "prom content 2",
    			"description" => "scas eje jekv ejnve vjkvr vjrv jkv jkv ewgyjfgu fbjf jfbw"
    		],
    		[
    			"icon_path" => "img/icon/promo-icon-3.png",
    			"title" => "prom content 3",
    			"description" => "scas eje jekv ejnve vjkvr vjrv jkv jkv ewgyjfgu fbjf jfbw"
    		]
    	]);
    	$homepage->destination = json_encode([
    		[
    			"image_path" => "img/project/project-1.jpg",
    			"destination" => "Goa",
    			"country" => "India",
    			"rating" => "2.5",
    			"bottom_title" => "bottom title 1"
    		],
    		[
    			"image_path" => "img/project/project-2.jpg",
    			"destination" => "Andaman",
    			"country" => "India",
    			"rating" => "3.5",
    			"bottom_title" => "bottom title 2"
    		],
    		[
    			"image_path" => "img/project/project-3.jpg",
    			"destination" => "Kerala",
    			"country" => "India",
    			"rating" => "4.5",
    			"bottom_title" => "bottom title 3"
    		],
    		[
    			"image_path" => "img/project/project-4.jpg",
    			"destination" => "Delhi",
    			"country" => "India",
    			"rating" => "1.5",
    			"bottom_title" => "bottom title 4"
    		],
    		[
    			"image_path" => "img/project/project-5.jpg",
    			"destination" => "Laddakh",
    			"country" => "India",
    			"rating" => "3.5",
    			"bottom_title" => "bottom title 5"
    		],
    		[
    			"image_path" => "img/project/project-6.jpg",
    			"destination" => "Masoorie",
    			"country" => "India",
    			"rating" => "4.5",
    			"bottom_title" => "bottom title 6"
    		]
    	]);
    	$homepage->newsletter_video_path = 'https://youtu.be/iyd7qUH3oH0';
    	$homepage->newsletter_title = 'newsletter title';
    	$homepage->newsletter_description = 'newsletter description newsletter description newsletter description newsletter description newsletter description newsletter description';
    	$homepage->happy_customers_images = json_encode([
    		"img/images/hero-author-1.png",
    		"img/images/hero-author-2.png",
    		"img/images/hero-author-3.png",
    		"img/images/hero-author-4.png"
    	]);
    	$homepage->happy_customers_title = 'happy customers title';
    	$homepage->happy_customers_sub_title = 'happy customers sub title';
    	$homepage->background_video_url = '
    	https://youtu.be/BWqB7KGHTq4';
    	$homepage->extra_description = 'wqhjvhsw dbewhjde whjbew cehjbjhb3e ';
    	$homepage->special =  1;
    	$homepage->featured =  1;
    	$homepage->blog = 1;
    	$homepage->testimonial = 1;
    	$homepage->activity = 1;
    	$homepage->newsletter = 1;
    	$homepage->happy_customers = 1;
    	$homepage->background_video_on = 1;
    	$homepage->save();

    }
}
