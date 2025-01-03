<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Blog;
use App\Models\HomePage;
use App\Models\Vlog;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\TravelCourse;
use App\Models\Activity;
use App\Models\Appsetting;
use App\Models\DynamicPage;
use App\Models\Newsletter;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Visa;
use App\Models\Insurance;
use App\Models\Comment;
use App\Models\ReviewAndRating;
use App\Models\AdsManagement;
use App\Models\Package;
use App\Models\Brand;
use App\Models\Career;
use App\Models\Gallery;
use App\Models\Language;
use DB;
use Mail;
use App\Models\EmailTemplate;
use App\Mail\CommonMail;

class FrontController extends Controller
{
	protected $appSetting;

	public function __construct()
	{
		$this->appSetting = Appsetting::first();
	}

	public function home()
	{
		$ads = false;
		if($this->appSetting->ads_enabled==1)
		{
			$ads  = AdsManagement::get();
		}
		
		$language_id = session('language_id', $this->appSetting->default_language);

		$homePage  = HomePage::first();

		$domestics = 
		// Package::select('packages.*')
		// ->join('destinations', 'packages.destination_id', '=', 'destinations.id')
		// ->where('language_id',$language_id)
		// ->where('data_for','package')
		// ->where('destinations.destination_type', 1)
		// ->where('packages.view_on_home',1)
		// ->where('packages.status',1)
		// ->get();

		Package::select('packages.*')
	    ->join('services', 'packages.service_id', '=', 'services.id') // Join with services
	    ->where('services.name', 'LIKE', '%'.'domestic'.'%') // Filter by service name 'visaa'
	    ->where('packages.language_id', $language_id)
	    ->where('packages.data_for', 'package')
	    ->where('packages.view_on_home', 1)
	    ->where('packages.status', 1)
	    ->get();

		$internationals = 
		// Package::select('packages.*')
		// ->join('destinations', 'packages.destination_id', '=', 'destinations.id')
		// ->where('language_id',$language_id)
		// ->where('data_for','package')
		// ->where('destinations.destination_type', 2)
		// ->where('packages.view_on_home',1)
		// ->where('packages.status',1)
		// ->get();

		Package::select('packages.*')
	    ->join('services', 'packages.service_id', '=', 'services.id') // Join with services
	    ->where('services.name', 'LIKE', '%'.'international'.'%') // Filter by service name 'visaa'
	    ->where('packages.language_id', $language_id)
	    ->where('packages.data_for', 'package')
	    ->where('packages.view_on_home', 1)
	    ->where('packages.status', 1)
	    ->get();

		$galleries = Gallery::where('view_on_home',1)
		->where('status',1)
		->get();

		$ramtaYogis = Package::select('packages.*')
		->where('language_id',$language_id)
		->where('data_for','package')
		->where('service_id', 1)
		->where('packages.view_on_home',1)
		->where('status',1)
		->get();

		$visas = Package::select('packages.*')
	    ->join('services', 'packages.service_id', '=', 'services.id') // Join with services
	    ->where('services.name', 'VISA') // Filter by service name 'visaa'
	    ->where('packages.language_id', $language_id)
	    ->where('packages.data_for', 'package')
	    ->where('packages.view_on_home', 1)
	    ->where('packages.status', 1)
	    ->get();


	    $specials = Package::select('packages.*')
	    ->where('language_id',$language_id)
	    ->where('data_for','package')
	    ->where('special', 1)
	    ->where('packages.view_on_home',1)
	    ->where('status',1)
	    ->get();

	    $featureds = Package::select('packages.*')
	    ->where('language_id',$language_id)
	    ->where('data_for','package')
	    ->where('featured', 1)
	    ->where('packages.view_on_home',1)
	    ->where('status',1)
	    ->get();

	    $reviews = ReviewAndRating::where('status', 1)
	    ->inRandomOrder()
	    ->take(10)
	    ->get();

	    $blogs = Blog::orderBy('order_number','ASC')->where('status',1)->where('view_on_home',1)->get();
	    $vlogs = Vlog::where('status',1)->where('view_on_home',1)->get();

	    $activity_destinations_id = Package::whereNotNull('destination_id')->distinct('destination_id')->where('language_id',$language_id)->where('data_for','activity')->pluck('destination_id');
	    $activityDestinations = Destination::whereIn('id',$activity_destinations_id)->withCount('activities')->get();

	    $trendings = Package::select('packages.*')
	    ->where('language_id',$language_id)
	    ->where('data_for','package')
	    ->where('trending', 1)
	    ->where('packages.view_on_home',1)
	    ->where('status',1)
	    ->get();

	    $brands = Brand::get();
	    $travelCourses = TravelCourse::where('status', 1)->get();

	    return View('welcome',compact('domestics','internationals','ramtaYogis','travelCourses','specials','featureds','blogs','reviews','homePage', 'ads','brands','vlogs','activityDestinations','trendings','visas','galleries'));
	}

	public function dynamicPage($slug)
	{
		$dynamicPage = DynamicPage::where('slug', $slug)->first();

		if (!$dynamicPage) {
			return abort(404);
		}

		$pageinfo = [
			"seo_title" => $dynamicPage->title,
			"seo_description" => $dynamicPage->content,
			"seo_keyword" => $dynamicPage->seo_keyword,
			"seo_image" => $dynamicPage->banner_image_path,
		];
		return view('dynamic_page', compact('dynamicPage','pageinfo'));
	}


	public function aboutUs()
	{
		return View('about_us');
	}

	public function faqs()
	{
		$faqs = Faq::get();
		$pageinfo = [
			"seo_title" => 'FAQ',
			"seo_description" => 'Faq Description',
			"seo_keyword" => 'faq',
			"seo_image" => '',
		];
		return View('faqs',compact('faqs'));
	}

	public function activities(Request $request)
	{
		$language_id = session('language_id', $this->appSetting->default_language);

		$query = Package::select('packages.*')->join('destinations', 'packages.destination_id', '=', 'destinations.id')->where('language_id',$language_id)->where('data_for','activity');

		if ($request->destination) {

			$query->where('destinations.name', $request->destination);
		}
		$activities = $query->where('packages.status', 1)->get();
		return View('activity.activities',compact('activities'));
	}

	public function activityDetail($slug)
	{
		$language_id = session('language_id', $this->appSetting->default_language);
		$query = Package::query();
		$package = Package::with('activityLists','service','destination')
		->where('slug',$slug)
		->where('language_id',$language_id)
		->first();
		if (!$package) {
			return redirect()->back()->with('error','Record not found');
		}

		$similarPackages = Package::where('uuid', '!=', $package->uuid)
		->where('status', 1)
		->where('language_id', $language_id)
		->where('data_for', 'activity')
		->where('destination_id',$package->destination_id)
		->inRandomOrder()
		->limit(7)
		->get();


		if (!$package) {
			return redirect('/');
					// return redirect()->back()->with('error','Content not found in requested language');
		}
		$pageinfo = [
			"seo_title" => $package->package_name,
			"seo_description" => $package->description,
			"seo_keyword" => $package->destination->name.','.$package->service->name,
			"seo_image" => count($package->images) > 0 ? $package->images[0] : NULL,
		];
		return View('activity.activity_detail',compact('package','pageinfo','similarPackages'));
	}

	public function career(Request $request)
	{
		$detail = 0;
		$careers = Career::where('status', 1);
		if(!empty($request->slug))
		{
			$detail = 1;
			$careers->where('slug', $request->slug);
			$career = $careers->first();
			return view('career', compact('career', 'detail'));
		}
		$careers = $careers->get();
		
		return view('career', compact('careers', 'detail'));
	}

	public function destinations()
	{
		$language_id = session('language_id', $this->appSetting->default_language);
		$destinations_id = Package::whereNotNull('destination_id')->distinct('destination_id')->where('language_id',$language_id)->where('packages.status', 1)->where('data_for','activity')->pluck('destination_id');
		$destinations = Destination::whereIn('id',$destinations_id)->withCount('activities')->get();

		return View('activity.activity-destination',compact('destinations'));
	}

	public function testimonials()
	{
	    $reviews = ReviewAndRating::where('status',1)->get();
		return View('testimonials',compact('reviews'));
	}

	public function galleries(Request $request)
	{
		$galleries = Gallery::query();
		if (!empty($request->gallery)) {
			$galleries = $galleries->where('name',$request->gallery);
		}
		$galleries = $galleries->get();
		return View('galleries',compact('galleries'));
	}


	public function blogs(Request $request)
	{
		$blogs = Blog::orderBy('order_number','ASC')->where('status', 1)
		->when(session()->has('language_id'), function ($query) {
			$query->where('language_id', session('language_id'));
		});

		if(!empty($request->cat))
		{
			$blogs->whereJsonContains('categories', $request->cat);
		}

		$blogs = $blogs->get();
		
		return view('blog.blogs', compact('blogs'));
	}


	public function blogDetail($slug)
	{
		$blog = Blog::where('slug',$slug)->with('comments')->withCount('comments')->first();
		if (!$blog) {
			return redirect()->back()->with('error','Record not found');
		}
		if (auth()->check() && $blog->posted_by == auth()->id()) {
		} else {
			$views = $blog->views + 1;
			Blog::where('id', $blog->id)->update(['views' => $views]);
		}

		$pageinfo = [
			"seo_title" => $blog->title,
			"seo_description" => $blog->content,
			"seo_keyword" => $blog->seo_keyword,
			"seo_image" => $blog->image_path,
		];

		return View('blog.blog_detail',compact('blog','pageinfo'));
	}

	public function vlogs()
	{
		$vlogs = Vlog::where('status', 1)
		->when(session()->has('language_id'), function ($query) {
			$query->where('language_id', session('language_id'));
		})
		->get();
		return View('vlog.vlogs',compact('vlogs'));
	}

	public function vlogDetail($slug)
	{
		$vlog = Vlog::where('slug',$slug)->first();
		if (!$vlog) {
			return redirect()->back()->with('error','Record not found');
		}
		$pageinfo = [
			"seo_title" => $vlog->title,
			"seo_description" => $vlog->title,
			"seo_keyword" => $vlog->seo_key,
			"seo_image" => $vlog->image_path,
		];
		return View('vlog.vlog_detail',compact('vlog','pageinfo'));
	}

	public function travelCourses()
	{
		$travelCourses = TravelCourse::where('status', 1)
		->when(session()->has('language_id'), function ($query) {
			$query->where('language_id', session('language_id'));
		})
		->get();
		return View('travelCourse.travel_courses',compact('travelCourses'));
	}

	public function travelCourseDetail($slug)
	{
		$travelCourse = TravelCourse::where('slug',$slug)->first();
		if (!$travelCourse) {
			return redirect()->back()->with('error','Record not found');
		}
		$pageinfo = [
			"seo_title" => $travelCourse->title,
			"seo_description" => $travelCourse->content,
			"seo_keyword" => $travelCourse->seo_keyword,
			"seo_image" => $travelCourse->image_path,
		];
		return View('travelCourse.travel_course_detail',compact('travelCourse','pageinfo'));
	}

	public function contactUs()
	{
		return View('contact_us');
	}

	public function contactUsStore(Request $request)
	{
		// return $request->all();
	    // Validate the incoming request data
		$validatedData = $request->validate([
			'first_name' => 'required|string|max:255',
			'last_name'  => 'nullable|string|max:255',
			'email'      => 'required|email|max:255',
			'phone'      => 'required|string|max:15',
			'message'    => 'required|string|max:1000',
		]);

	    // Store the data in the ContactUs model
		$contact = ContactUs::create([
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
			'phone' => $request->country_code.' '.$request->phone,
			'message' => $request->message,
		]);

		if (env('IS_MAIL_SEND_ENABLE', false)) {
			$email_template = EmailTemplate::where('template_for', 'contact-request-sent')->first();
			if ($email_template) {
				$variable_data = ['{{name}}' => $request->first_name.' '.$request->last_name];
				$mail_body = strReplaceAssoc($variable_data, $email_template->mail_body);
				$mail_subject = $email_template->mail_subject;

				$mailObj = [
					'mail_subject' => $mail_subject,
					'mail_body'    => $mail_body,
				];

				Mail::to(strtolower($request->email))->send(new CommonMail($mailObj));
			}

			$email_template1 = EmailTemplate::where('template_for', 'contact-request-recieved')->first();
			if ($email_template1) {
				$variable_data = [
					'{{email}}' => $request->email,
					'{{name}}' => $request->first_name.' '.$request->last_name,
					'{{mobilenum}}' => $request->country_code.'  '.$request->phone,
				];
				$mail_body = strReplaceAssoc($variable_data, $email_template1->mail_body);
				$mail_subject = $email_template1->mail_subject;

				$mailObj = [
					'mail_subject' => $mail_subject,
					'mail_body'    => $mail_body,
				];

				Mail::to(strtolower(User::first()->email))->send(new CommonMail($mailObj));
			}
		}

	    // Return a response or redirect, depending on your application's needs
		return redirect()->route('thankyou')->with('success', 'Thank you for contacting us! We will reach out to you soon!');

	}

	public function thankyou(Request $request)
	{
		return view('thankyou');
	}

	public function newsletterSave(Request $request)
	{
		$validation = \Validator::make($request->all(), [
			'email' => 'required|unique:newsletters,email'
		]);

		if ($validation->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validation->errors()
			], 422);
		}
		try {
	    // Store the data in the Newsletter model
			$newsletter = new Newsletter();
			$newsletter->email = $request->email;
			$newsletter->save();

			return response()->json([
				'success' => true,
				'message' => 'Newsletter Subscribed Successfully.'
			], 200);
			


		} catch (\Exception $exception) {
			\Log::error($exception->getMessage());
			return response()->json([
				'success' => false,
				'message' => 'Oops! Something went wrong.'
			], 500);
		}
	}

	public function commentSave(Request $request)
	{
	    // Validate the incoming request data
		$validation = \Validator::make($request->all(), [
			'blog_id' => 'nullable|exists:blogs,id',
			'vlog_id' => 'nullable|exists:blogs,id',
			'comment' => 'required'
		]);

		if ($validation->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validation->errors()
			], 422);
		}

		try {

			if (auth()->user()) {
				// Store the data in the Comment model
				$comment = new Comment();
				$comment->blog_id = $request->blog_id;
				$comment->vlog_id = $request->vlog_id;
				$comment->comment = $request->comment;
				$comment->posted_by = auth()->user() ? auth()->id() : 'unknown';
				$comment->post_date = date('Y-m-d');
				$comment->status = 0;
				$comment->save();

				return response()->json([
					'success' => true,
					'message' => 'comment posted. comment will be displayed after admin approval.'
				], 200);
			}
			else
			{
				return response()->json([
					'success' => false,
					'message' => 'First Login to post a comment.'
				], 500);
			}


		} catch (\Exception $exception) {
			\Log::error($exception->getMessage());
			return response()->json([
				'success' => false,
				'message' => 'Oops! Something went wrong.'
			], 500);
		}

	}


	public function swichLanguage(Request $request)
	{
	    // Validate the incoming request data
		$validatedData = $request->validate([
			'language_id' => 'required|exists:languages,id',
		]);

		$language = Language::find($request->language_id);

	    // Store the language ID in the session
		session(['language_id' => $validatedData['language_id'],'flag' => $language->flag]);

	    // Optionally, return a response
		return redirect()->back();
	}

	public function swichCurrency(Request $request)
	{
	    // Validate the incoming request data
		$validatedData = $request->validate([
			'currency_id' => 'required|exists:currencies,id',
		]);

	    // Store the currency ID in the session
		session(['currency_id' => $validatedData['currency_id']]);

	    // Optionally, return a response
		return redirect()->back();
	}

	public function visaSave(Request $request)
	{
	    // Validate the incoming request data
		$validation = \Validator::make($request->all(), [
			'destination' => 'required',
			'start_date' => 'required',
			'adults' => 'required',
			'name' => 'required',
			'email' => 'required'
		]);

		if ($validation->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validation->errors()
			], 422);
		}

		try {

			$visa = new Visa();
			$visa->destination = $request->destination;
			$visa->travel_start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
			$visa->travel_end_date = NULL;
			$visa->number_of_adults = $request->adults;
			$visa->number_of_children = $request->children ? $request->children : 0;
			$visa->children_ages = $request->children_ages ? json_encode($request->children_ages) : NULL;
			$visa->number_of_infants = $request->infants ? $request->infants : 0;
			$visa->infants_ages = $request->infants_ages ? json_encode($request->infants_ages) : NULL;
			$visa->name = $request->name;
			$visa->email = $request->email;
			$visa->mobile = $request->country_code.' '.$request->mobile;
			$visa->status = 0;
			$visa->save();

			if (env('IS_MAIL_SEND_ENABLE', false)) {
				$email_template = EmailTemplate::where('template_for', 'visa-request-sent')->first();
				if ($email_template) {
					$variable_data = ['{{name}}' => $request->name];
					$mail_body = strReplaceAssoc($variable_data, $email_template->mail_body);
					$mail_subject = $email_template->mail_subject;

					$mailObj = [
						'mail_subject' => $mail_subject,
						'mail_body'    => $mail_body,
					];

					Mail::to(strtolower($request->email))->send(new CommonMail($mailObj));
				}

				$email_template1 = EmailTemplate::where('template_for', 'visa-request-recieved')->first();
				if ($email_template1) {
					$variable_data = [
						'{{email}}' => $request->email,
						'{{name}}' => $request->name,
						'{{mobilenum}}' => $visa->mobile,
					];
					$mail_body = strReplaceAssoc($variable_data, $email_template1->mail_body);
					$mail_subject = $email_template1->mail_subject;

					$mailObj = [
						'mail_subject' => $mail_subject,
						'mail_body'    => $mail_body,
					];

					Mail::to(strtolower(User::first()->email))->send(new CommonMail($mailObj));
				}
			}

			return response()->json([
				'success' => true,
				'message' => 'Visa inquiry sent successfully.'
			], 200);


		} catch (\Exception $exception) {
			\Log::error($exception->getMessage());
			return response()->json([
				'success' => false,
				'message' => 'Oops! Something went wrong.'
			], 500);
		}

	}

	public function insuranceSave(Request $request)
	{
	    // Validate the incoming request data
		$validation = \Validator::make($request->all(), [
			'destination' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
			'adults' => 'required',
			'name' => 'required',
			'email' => 'required'
		]);

		if ($validation->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validation->errors()
			], 422);
		}

		try {

			$insurance = new Insurance();
				$insurance->destination = $request->destination;
				$insurance->travel_start_date = $request->start_date;
				$insurance->travel_end_date = $request->end_date;
				$insurance->number_of_adults = $request->adults;
				$insurance->number_of_children = $request->children ? $request->children : 0;
				$insurance->children_ages = $request->children_ages ? json_encode($request->children_ages) : NULL;
				$insurance->number_of_infants = $request->infants ? $request->infants : 0;
				$insurance->infants_ages = $request->infants_ages ? json_encode($request->infants_ages) : NULL;
				$insurance->name = $request->name;
				$insurance->email = $request->email;
				$insurance->mobile = $request->country_code.' '.$request->mobile;
				$insurance->status = 0;
				$insurance->save();

				if (env('IS_MAIL_SEND_ENABLE', false)) {
					$email_template = EmailTemplate::where('template_for', 'insurance-request-sent')->first();
					if ($email_template) {
						$variable_data = ['{{name}}' => $request->name];
						$mail_body = strReplaceAssoc($variable_data, $email_template->mail_body);
						$mail_subject = $email_template->mail_subject;

						$mailObj = [
							'mail_subject' => $mail_subject,
							'mail_body'    => $mail_body,
						];

						Mail::to(strtolower($request->email))->send(new CommonMail($mailObj));
					}

					$email_template1 = EmailTemplate::where('template_for', 'insurance-request-recieved')->first();
					if ($email_template1) {
						$variable_data = [
							'{{email}}' => $request->email,
							'{{name}}' => $request->name,
							'{{mobilenum}}' => $insurance->mobile,
						];
						$mail_body = strReplaceAssoc($variable_data, $email_template1->mail_body);
						$mail_subject = $email_template1->mail_subject;

						$mailObj = [
							'mail_subject' => $mail_subject,
							'mail_body'    => $mail_body,
						];

						Mail::to(strtolower(User::first()->email))->send(new CommonMail($mailObj));
					}
				}

				return response()->json([
					'success' => true,
					'message' => 'Insurance inquiry sent successfully.'
				], 200);
		} catch (\Exception $exception) {
			\Log::error($exception->getMessage());
			return response()->json([
				'success' => false,
				'message' => $exception->getMessage()
			], 500);
		}
	}

	public function visaInquiry()
	{
		$language_id = session('language_id', $this->appSetting->default_language);
		$visas = Package::select('packages.*')
	    ->join('services', 'packages.service_id', '=', 'services.id') // Join with services
	    ->where('services.name', 'VISA') // Filter by service name 'visaa'
	    ->where('packages.language_id', $language_id)
	    ->where('packages.data_for', 'package')
	    ->where('packages.status', 1)
	    ->paginate(10);
	    $pageinfo = [
	    	"seo_title" => 'visa-inquiry',
	    	"seo_description" => 'visa-inquiry',
	    	"seo_keyword" => 'visa-inquiry',
	    	"seo_image" => '',
	    ];
	    return View('visa-inquiry',compact('visas'));
	}

	public function insuranceInquiry()
	{
		return View('insurance-inquiry');
	}
}

