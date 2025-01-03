<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appsetting;
use App\Models\HomePage;
use File;

use Str;
use Intervention\Image\Laravel\Facades\Image;

class AppsettingController extends Controller
{
	public function __construct()
	{
		$this->middleware('permission:app-setting-update', ['only' => ['appSettingUpdate','appSetting','handleImageUpload']]);

	}
	public function appSetting()
	{
		$appsetting = Appsetting::first();
		return view('admin.app-setting', compact('appsetting'));
	}

	public function appSettingUpdate(Request $request)
	{
		$this->validate($request, [
			'app_name'          => ['required', 'string', 'max:191'],
			'description'       => ['nullable', 'string', 'max:1500'],
			'email'             => ['required', 'email', 'max:191'],
			'address'           => ['required', 'string', 'max:191'],
			'app_logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
		]);
		$appsetting = Appsetting::first();

		$destinationPath = 'uploads/';
		$image_name = Str::slug(substr($request->app_name, 0, 30));

        // Handle app logo upload
		$saveFile = str_replace("uploads/", "",$appsetting->app_logo);
		if($request->hasFile('app_logo')) {
			$saveFile = $this->handleImageUpload($request->file('app_logo'), $destinationPath, $image_name, $saveFile, 'logothumb');
		}

        // Handle favicon upload
		$favIconFile = str_replace("uploads/", "",$appsetting->fav_icon);
		if($request->hasFile('fav_icon')) {
			$favIconFile = $this->handleImageUpload($request->file('fav_icon'), $destinationPath, 'favicon-'.$image_name, $favIconFile, '');
		}

		// Handle Footer Logo upload
		$footerLogo = str_replace("uploads/", "",$appsetting->footer_logo);
		if($request->hasFile('footer_logo')) {
			$footerLogo = $this->handleImageUpload($request->file('footer_logo'), $destinationPath, 'footer-logo-'.$image_name, $footerLogo, '');
		}

		// Handle payment image upload
		$paymentImage = str_replace("uploads/", "",$appsetting->payment_image);
		if($request->hasFile('payment_image')) {
			$paymentImage = $this->handleImageUpload($request->file('payment_image'), $destinationPath, 'payment-image-'.$image_name, $paymentImage, '');
		}

        // Update app settings
		
		$appsetting->app_name = $request->app_name;
		$appsetting->description = $request->description;
		$appsetting->footer_description = $request->footer_description;
		$appsetting->app_logo = $destinationPath.$saveFile;
		$appsetting->logo_thumb_path = $destinationPath.'logothumb/'.$saveFile;
		$appsetting->fav_icon = $destinationPath.$favIconFile;
		$appsetting->footer_logo = $destinationPath.$footerLogo;
		$appsetting->payment_image = $destinationPath.$paymentImage;
		$appsetting->email = $request->email;
		$appsetting->mobilenum = $request->mobilenum;
		$appsetting->address = $request->address;
		$appsetting->seo_keyword = $request->seo_keyword;
		$appsetting->seo_description = $request->seo_description;
		$appsetting->google_analytics = $request->google_analytics;
		$appsetting->fb_url = $request->fb_url;
		$appsetting->twitter_url = $request->twitter_url;
		$appsetting->insta_url = $request->insta_url;
		$appsetting->linkedIn_url = $request->linkedIn_url;
		$appsetting->pinterest_url = $request->pinterest_url;
		$appsetting->copyright_text = $request->copyright_text;
		$appsetting->default_language = $request->default_language;
		$appsetting->default_currency = $request->default_currency;
		$appsetting->ads_enabled = $request->ads_enabled;
		$appsetting->contact_title = $request->contact_title;
		$appsetting->contact_description = $request->contact_description;
		$appsetting->pro_forma_invoice_remarks = $request->pro_forma_invoice_remarks;
		$appsetting->save();

		if($appsetting) {
			return \Redirect()->back()->with('Success', 'App setting successfully changed.');
		} else {
			return \Redirect()->back()->with('error', 'Something went wrong, please try again.');
		}
	}

	public function homePage()
	{
		
		$homePage = HomePage::first();
		return view('admin.home_page', compact('homePage'));
	}

	public function homePageUpdate(Request $request)
	{
		// dd($request->all());
    // Validate the request
		$request->validate([
			'title' => 'required|string|max:255',
			'sub_title' => 'required|string|max:255',
			'short_description' => 'required|string',
        // 'banner_image_path' => 'nullable|image',
        // 'image_path' => 'nullable|image',
			'video_path' => 'nullable|url',
			'duration' => 'nullable|string',
			'promo.*.icon_path' => 'nullable|image',
			'promo.*.title' => 'required|string',
			// 'promo.*.description' => 'required|string',
			'destination.*.image_path' => 'nullable|image',
			'destination.*.destination' => 'required|string',
			'destination.*.country' => 'required|string',
			'destination.*.rating' => 'nullable|numeric',
			'destination.*.bottom_title' => 'required|string',
			'newsletter_video_path' => 'nullable|url',
			'newsletter_title' => 'required|string|max:255',
			'newsletter_description' => 'required|string',
			'happy_customers_images.*' => 'nullable|image',
			'happy_customers_title' => 'required|string|max:255',
			'happy_customers_sub_title' => 'required|string|max:255',
		]);

    // Assuming only one homepage entry
		$homepage = HomePage::first();

		if (!$homepage) {
			return redirect()->back()->with('error', 'HomePage not found.');
		}

		$destinationPath = public_path('/uploads/home');

    // Update static fields
		$homepage->title = $request->input('title');
		$homepage->sub_title = $request->input('sub_title');
		$homepage->short_description = $request->input('short_description');

    // Handle banner image upload
		if ($request->hasFile('banner_image_path')) {
			$bannerImage = $request->file('banner_image_path');
			$bannerImageName = time() . '.' . $bannerImage->getClientOriginalExtension();
			$bannerImage->move($destinationPath, $bannerImageName);
			$homepage->banner_image_path = 'uploads/home/' . $bannerImageName;
		}

    // Handle main image upload

		$imagePaths = !empty($homepage->image_path) ? json_decode($homepage->image_path, true) : [];

// Check if the request contains files for 'image_path'
if ($request->hasFile('image_path')) {
    foreach ($request->file('image_path') as $key => $file) {
        // Generate a unique file name
        $name = time() . '-' . $key . '.' . $file->getClientOriginalExtension();
        
        // Define the destination path
        $destinationPath = public_path('/uploads/home');
        
        // Move the file to the destination path
        $file->move($destinationPath, $name);
        
        // Append the new image path to the $imagePaths array
        $imagePaths[] = 'uploads/home/' . $name;
    }
}

		$homepage->image_path = json_encode($imagePaths);

    // Handle video URL
		$homepage->video_path = $request->input('video_path');
		$homepage->duration = $request->input('duration');

    // Handle Promo Items
		$promoItems = $request->input('promo', []);
		$destinationPath = public_path('uploads/home');

		foreach ($promoItems as $index => $promoItem) {
			if ($request->hasFile("promo.{$index}.icon_path")) {
        // Get the uploaded file
				$promoImage = $request->file("promo.{$index}.icon_path");
				
        // Generate a unique name for the uploaded file
				$promoImageName = time() . '-' . $index . '.' . $promoImage->getClientOriginalExtension();
				
        // Move the file to the specified destination
				$promoImage->move($destinationPath, $promoImageName);
				
        // Update the icon_path with the new file path
				$promoItems[$index]['icon_path'] = 'uploads/home/' . $promoImageName;
			} else {
        // If no new file is uploaded, retain the existing icon path
				$promoItems[$index]['icon_path'] = $promoItem['existing_icon_path'] ?? null;
			}
		}

// Update the homepage promo field with the new data
		$homepage->promo = json_encode($promoItems);


    // Handle Destination Items
		$destinationItems = $request->input('destination', []);
		foreach ($destinationItems as $index => $destinationItem) {
			if ($request->hasFile("destination[{$index}][image_path]")) {
				$destinationImage = $request->file("destination[{$index}][image_path]");
				$destinationImageName = time() . '.' . $destinationImage->getClientOriginalExtension();
				$destinationImage->move($destinationPath, $destinationImageName);
				$destinationItems[$index]['image_path'] = 'uploads/home/' . $destinationImageName;
			} else {
				$destinationItems[$index]['image_path'] = $destinationItem['existing_image_path'] ?? null;
			}
		}
		$homepage->destination = json_encode($destinationItems);

    // Handle Newsletter Section
		$homepage->newsletter_video_path = $request->input('newsletter_video_path');
		$homepage->newsletter_title = $request->input('newsletter_title');
		$homepage->newsletter_description = $request->input('newsletter_description');

    // Handle Happy Customers Images
		$happyCustomerImages = [];
		if ($request->hasFile('happy_customers_images')) {
			foreach ($request->file('happy_customers_images') as $happyCustomerImage) {
				$happyCustomerImageName = time() . '.' . $happyCustomerImage->getClientOriginalExtension();
				$happyCustomerImage->move($destinationPath, $happyCustomerImageName);
				$happyCustomerImages[] = 'uploads/home/' . $happyCustomerImageName;
			}
		} 
		foreach ($request->old_happy_customers_images as $key => $value) {
			$happyCustomerImages[] = $value;
		}

		$homepage->happy_customers_images = json_encode($happyCustomerImages);

    // Handle Happy Customers Section
		$homepage->happy_customers_title = $request->input('happy_customers_title');
		$homepage->happy_customers_sub_title = $request->input('happy_customers_sub_title');

		$homepage->background_video_url = $request->input('background_video_url');
		$homepage->extra_description = $request->input('extra_description');

		$homepage->special = $request->special == 'on' ? 1 : 2;
		$homepage->featured = $request->featured == 'on' ? 1 : 2;
		$homepage->blog = $request->blog == 'on' ? 1 : 2;
		$homepage->testimonial = $request->testimonial == 'on' ? 1 : 2;
		$homepage->activity = $request->activity == 'on' ? 1 : 2;
		$homepage->newsletter = $request->newsletter == 'on' ? 1 : 2;
		$homepage->happy_customers = $request->happy_customers == 'on' ? 1 : 2;
		$homepage->background_video_on = $request->background_video_on == 'on' ? 1 : 2;

    // Save the updated homepage
		$homepage->save();

		return redirect()->back()->with('Success', 'Home Page successfully updated.');
	}

	public function removeHeroImage(Request $request)
{
    $homePage = HomePage::find($request->id);

    if (!$homePage) {
        return response()->json(['success' => false, 'message' => 'Home page not found.']);
    }

    // Remove the image from the storage
    $imagePath = $request->image_path;
    if (File::exists(public_path($imagePath))) {
        File::delete(public_path($imagePath));
    }

    // Decode the JSON image path
    $imagePaths = json_decode($homePage->image_path, true); // Use true to decode as an array
    $valueToRemove = $request->image_path;

    // Remove the specified image
    $imagePaths = array_diff($imagePaths, [$valueToRemove]);

    // Reindex the array to remove gaps in the indexes
    $imagePaths = array_values($imagePaths);

    // Save the updated paths
    $homePage->image_path = json_encode($imagePaths);
    $homePage->save();

    return response()->json(['success' => true, 'message' => 'Image removed successfully.']);
}


	public function removeBannerImage(Request $request)
	{
		$homePage = HomePage::find($request->id);
		
		if ($homePage) {
	        // Delete the image from the storage
			if (File::exists(public_path($homePage->banner_image_path))) {
				File::delete(public_path($homePage->banner_image_path));
			}

	        // Clear the image path in the database
			$homePage->banner_image_path = null;
			$homePage->save();

			return response()->json(['success' => true]);
		}

		return response()->json(['success' => false], 400);
	}




	private function handleImageUpload($file, $destinationPath, $image_name, $oldFileName, $thumbFolder)
	{
        // Delete old file if it exists
		if($oldFileName && file_exists($destinationPath.$oldFileName)) {
			unlink($destinationPath.$oldFileName);
			if($thumbFolder) {
				unlink($destinationPath.$thumbFolder.'/'.$oldFileName);
			}
		}

        // Generate new file name
		$fileName = 'header-'.$image_name.'-'.time().'.'.$file->getClientOriginalExtension();
		$file->move($destinationPath, $fileName);

        // Create thumbnail if needed
		if($thumbFolder) {
			$img = Image::read($destinationPath.$fileName);
			$img->resize(500, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$img->save($destinationPath.$thumbFolder.'/'.$fileName);
		}
		return $fileName;
	}
}
