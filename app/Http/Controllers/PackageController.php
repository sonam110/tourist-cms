<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Package;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Currency;
use App\Models\Inquiry;
use App\Models\BookingInquiry;
use App\Models\Appsetting;
use App\Models\ReviewAndRating;
use App\Models\PromotionAndDiscount;
use App\Models\Booking;
use DB;
use Mail;
use App\Mail\CommonMail;

class PackageController extends Controller
{
	protected $appSetting;

	public function __construct()
	{
		$this->appSetting = Appsetting::first();
	}

	public function packages(Request $request)
	{
		$language_id = session('language_id', $this->appSetting->default_language);

    	// Get the search query from the request
		$search = $request->input('search');

    	// Start the query with a join to the Destination model
		$query = Package::select('packages.*')->join('destinations', 'packages.destination_id', '=', 'destinations.id')->where('language_id',$language_id)->with('service','activityLists')->where('data_for','package');

    	// Apply search filter
		if ($search) {
			$query->where('packages.package_name', 'like', '%' . $search . '%')
			->orWhere('destinations.name', 'like', '%' . $search . '%');
		}

    	// Filter by destination if present
		if ($request->destination) {
			if ($request->destination == 'domestic') {
				$query->where('destinations.destination_type', 1);
			}
			elseif($request->destination == 'international')
			{
				$query->where('destinations.destination_type', 2);
			}
			else
			{
				$query->where('destinations.name', $request->destination);
			}
		}

		if ($request->service || $request->services) {
			$query->join('services', 'packages.service_id', '=', 'services.id')
			->where(function ($query) use ($request) {
				// if ($request->service == 'visa') {
				// 	$query->orWhere('services.name', 'visa');
				// }
				// else
				if ($request->service == 'ramta-yogi') {
					$query->orWhere('service_id', 1);
				} elseif ($request->service) {
					$query->orWhere('packages.service_id', $request->service);
				}

				if ($request->services) {
					$query->orWhereIn('packages.service_id', $request->services);
				}
			});
		}


    	// Paginate the results
		$packages = $query->where('packages.status', 1)
		->when(session()->has('language_id'), function ($query) {
			$query->where('packages.language_id', session('language_id'));
		})
		->paginate(12);

    	// Get services with package count
		$services = Service::withCount('packages')->get();

		$packageTypes = Package::where('package_type', '!=', '')
    ->distinct()
    ->get(['package_type']);


		return view('package.packages', compact('packages', 'services','packageTypes'));
	}

	public function packagesFilter(Request $request)
	{
		$language_id = session('language_id', $this->appSetting->default_language);
		$query = Package::join('destinations', 'packages.destination_id', '=', 'destinations.id')->where('packages.language_id',$language_id)->where('packages.data_for','package')->where('packages.status',1);

		if ($request->destination) {
			if ($request->destination == 'domestic') {
				$query->where('destinations.destination_type', 1);
			}
			elseif($request->destination == 'international')
			{
				$query->where('destinations.destination_type', 2);
			}
			else
			{
				$query->where('destinations.name', $request->destination);
			}
		}

		if ($request->service || $request->services) {
			$query->where(function ($query) use ($request) {
				if ($request->service == 'ramta-yogi') {
					$query->orWhere('packages.service_id', 1);
				} elseif ($request->service) {
					$query->orWhere('packages.service_id', $request->service);
				}
				if ($request->services) {
					$query->orWhereIn('packages.service_id', $request->services);
				}
			});
		}

		if ($request->packageTypes) {
			$query->whereIn('packages.package_type',$request->packageTypes);
		}

		if ($request->package_type) {
			$query->where('packages.package_type',$request->package_type);
		}


	    // Filter by price
		if ($request->has('min_price') && $request->has('max_price')) {
			$query->whereBetween('price_in_currency_'.$language_id, [$request->input('min_price'), $request->input('max_price')]);
		}

	    // Filter by ratings
		if ($request->has('ratings')) {
			$query->whereIn('rating', $request->input('ratings'));
		}

	    // Get the filtered packages
		$packages = $query->where('language_id',$language_id)
		->where('data_for','package')
		->with('service','activityLists','bookings','reviews','images','destination')
		->withCount('reviews','bookings')
		->get();

	    // Return the packages as JSON
		return response()->json(['packages' => $packages]);
	}




	public function packageDetail(Request $request,$slug)
	{
		$language_id = session('language_id', $this->appSetting->default_language);
		$query = Package::query();
		$package = Package::with('activityLists','service','destination')
		->where('slug',$slug)
		->where('language_id',$language_id)
		->first();

		if (!$package) {
			$package = Package::with('activityLists','service','destination')
					->where('slug',$slug)
					// ->where('language_id',$language_id)
					->first();
		}

		if (!$package) {
			return redirect()->back()->with('error', 'Record Not found!');
		}

		$similarPackages = Package::where('uuid', '!=', $package->uuid)
		    ->where('status', 1)
		    ->where('language_id', $language_id)
		    ->when(request()->has('destination'), function ($query) use($request){
		        $query->whereHas('destination', function ($q) use ($request) {
				    if ($request->destination == 'domestic') {
				        $q->where('destination_type', 1);
				    } elseif ($request->destination == 'international') {
				        $q->where('destination_type', 2);
				    } else {
				        $q->where('name', $request->destination);
				    }
				});
		        // $query->where('destination_id', request('destination'));
		    }, function ($query) use ($package) {
		        // Otherwise, use the original logic with both destination and service
		        $query->where(function ($query) use ($package) {
		            $query->where('destination_id', $package->destination_id)
		                  ->orWhere('service_id', $package->service_id);
		        });
		    })
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
		return View('package.package_detail',compact('package','pageinfo','similarPackages'));
	}

	

	public function bookingSave(Request $request)
	{
	    // Validate the incoming request data
		$validatedData = $request->validate([
			'start_date' => 'required|date',
			// 'end_date'  => 'required|date',
			'number_of_adults'      => 'required|numeric|min:1'
		]);

		$package_uuid = $request->package_uuid;
		$package = Package::where('uuid',$package_uuid)->where('language_id',session('language_id', $this->appSetting->default_language))->first();
		if (empty($package)) {
			return redirect()->back()->with('error', 'Record Not found!');
		}
		$currency_id = session('currency_id',$this->appSetting->default_currency);
		$currency = Currency::find($currency_id);
		$price = $package->price;
		$total_price = ($request->number_of_adults * $price) + ($request->number_of_children * $price/2) + ($request->number_of_infants * $price/5);
		$discount = 0;
		if (!empty($request->coupon_code)) {
			$pad = PromotionAndDiscount::where('coupon_code', $request->coupon_code)->first();
			if ($pad) {
				if ($total_price > $pad->min_applicable_amount) {
					if ($pad->discount_type == 1) {
						$discount = $pad->discount_value;
					}
					else
					{
						$discount = $total_price * $pad->discount_value/100;
						if ($discount > $pad->max_discount) {
							$discount = $pad->max_discount;
						}
					}
				}
			}
		}
		$booking = new Booking();
		$booking->user_id = auth()->user()->id;
		$booking->name = auth()->user()->name;
		$booking->email = auth()->user()->email;
		$booking->mobile = auth()->user()->mobile;
		$booking->package_name = $package->package_name;
		$booking->destination_name = $package->destination->name;
		$booking->price = $price;
		$booking->city_of_departure = $package->icon;
		$booking->start_date = $request->start_date;
		$booking->end_date = $request->end_date;
		$booking->package_uuid = $request->package_uuid;
		$booking->number_of_adults = $request->number_of_adults;
		$booking->number_of_children = $request->number_of_children;
		$booking->number_of_infants = $request->number_of_infants;
		$booking->children_ages = $request->children_ages ? json_encode($request->children_ages) : NULL;
		$booking->infants_ages = $request->infants_ages ? json_encode($request->infants_ages) : NULL;
		$booking->coupon_code = $request->coupon_code;
		$booking->coupon_code_discount = $discount;
		$booking->payable_amount = $total_price - $discount;
		$booking->status = 0;
		$booking->save();

    	// Notify user if  mail send enabled
		if (env('IS_MAIL_SEND_ENABLE', false)) {
			$email_template = EmailTemplate::where('template_for', 'booking-request-sent')->first();
			if ($email_template) {
				$variable_data = ['{{name}}' => $booking->name];
				$mail_body = strReplaceAssoc($variable_data, $email_template->mail_body);
				$mail_subject = $email_template->mail_subject;

				$mailObj = [
					'mail_subject' => $mail_subject,
					'mail_body'    => $mail_body,
				];

				Mail::to(strtolower($booking->email))->send(new CommonMail($mailObj));
			}

			$email_template1 = EmailTemplate::where('template_for', 'booking-request-recieved')->first();
			if ($email_template1) {
				$variable_data = [
					'{{email}}' => $booking->email,
					'{{destination}}' => $booking->destination_name,
					'{{start_date}}' => $booking->start_date,
					'{{end_date}}' => $booking->end_date,
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
		// return redirect()->back()->with('success', 'Your booking has been sent successfully!');
		if($package->data_for == 'activity')
		{
			return redirect()->route('activities', ['destination' => $package->destination->name])
                 ->with('success', 'Congratulations! Your booking has been sent.<br> Thank You for Choosing Us.');
		}
		return redirect()->route('packages', ['destination' => $package->destination->name])
                 ->with('success', 'Congratulations! Your booking has been sent.<br> Thank You for Choosing Us.');


	}

	public function applyCoupon(Request $request)
	{
		$amount = $request->amount;
		$pad = PromotionAndDiscount::where('coupon_code', $request->coupon_code)->first();
		if (!$pad) {
			return response()->json(["success"=>'false','message'=>'Invalid CouponCode']);
		}
		if ($amount > $pad->min_applicable_amount) {
			if ($pad->discount_type == 1) {
				$discount = $pad->discount_value;
			}
			else
			{
				$discount = $amount * $pad->discount_value/100;
				if ($discount > $pad->max_discount) {
					$discount = $pad->max_discount;
				}
			}
			return response()->json(["success"=>'true','message'=>'Coupon Applied! You saved '.$discount,'discounted_amount'=>$discount]);
		}
		else
		{
			return response()->json(["success"=>'false','message'=>'amount is less than minimum applicable amount! Add more '.$pad->min_applicable_amount - $amount.' to get discount']);
		}
	}

	public function ratingSave(Request $request)
	{
	    // Validate the incoming request data
		$validation = \Validator::make($request->all(), [
			'package_uuid' => 'required|exists:packages,uuid',
			'review' => 'required',
			'rating' => 'required'
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
				$rating = new ReviewAndRating();
				$rating->package_uuid = $request->package_uuid;
				$rating->review = $request->review;
				$rating->rating = $request->rating;
				$rating->user_id = auth()->id();
				$rating->user_image = auth()->user()->profile_image;
				$rating->user_name = auth()->user()->name;
				$rating->status = 0;
				$rating->save();

				return response()->json([
					'success' => true,
					'message' => 'Review Sent. Review will be displayed after admin approval.'
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

	public function inquiryStore(Request $request)
	{
		$validatedData = $request->validate([
			'name' => 'required|string|max:255',
			'email'      => 'required|email|max:255',
		]);

		$inquiry = Inquiry::create([
			'name' => $request->name,
			'email' => $request->email,
			'package_id' => $request->package_id,
			'traveller_count' => $request->traveller_count,
			'travel_date' => $request->travel_date,
			'mobile' => $request->country_code.' '.$request->mobile,
			'message' => $request->message,
		]);

		if (env('IS_MAIL_SEND_ENABLE', false)) {
			$email_template = EmailTemplate::where('template_for', 'inquiry-request-sent')->first();
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

			$email_template1 = EmailTemplate::where('template_for', 'inquiry-request-recieved')->first();
			if ($email_template1) {
				$variable_data = [
					'{{travel_date}}' => $request->travel_date,
					'{{traveller_count}}' => $request->traveller_count,
					'{{email}}' => $request->email,
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
		return redirect()->route('thankyou')->with('success', 'Thank you for inquiring us! We will reach out to you soon!');

	}
}
