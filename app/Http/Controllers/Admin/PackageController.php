<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageImage;
use App\Models\PackagePrice;
use App\Models\Destination;
use App\Models\Appsetting;
use App\Models\Language;
use App\Models\Service;
use DB;
use Illuminate\Support\Facades\Storage;
use Str;
use File;

class PackageController extends Controller
{
	protected $appSetting;

	public function __construct()
	{
		$this->appSetting = Appsetting::first();
		$this->middleware('permission:package-browse',['only' => ['index']]);
		$this->middleware('permission:package-add', ['only' => ['create','store','action']]);
		$this->middleware('permission:package-edit', ['only' => ['edit','store','action']]);
		$this->middleware('permission:package-delete', ['only' => ['destroy','action']]);
	}

	// public function index()
	// {
	// 	$packages = Package::where('language_id',$this->appSetting->default_language)
	// 	->with(['destination'])
	// 	->where('data_for','package')
	// 	->get()
	// 	->map(function($package) {
	// 		return Package::where('id', $package->id)->with('destination')->first();
	// 	});

	// 	return view('admin.packages', compact('packages'));
	// }

	public function index(Request $request)
	{
	    $fullUrl = $request->fullUrl();
	    $query = Package::where('language_id', $this->appSetting->default_language)
	                    ->where('data_for', 'package');

	    if (str_contains($fullUrl, 'domestic')) {
	        $query->whereHas('destination', function ($q) {
	            $q->where('destination_type', 1);
	        });
	    } elseif (str_contains($fullUrl, 'international')) {
	        $query->whereHas('destination', function ($q) {
	            $q->where('destination_type', 2);
	        });
	    }elseif (str_contains($fullUrl, 'ramta-yogi')) {
	        // Filter for packages where service name is 'Ramta Yogi'
	        $query->whereHas('service', function ($q) {
	            $q->where('name', 'Ramta Yogi');
	        });
	    }elseif (str_contains($fullUrl, 'visa')) {
	        // Filter for packages where service name is 'Ramta Yogi'
	        $query->whereHas('service', function ($q) {
	            $q->where('name', 'visa');
	        });
	    }

	    // Fetch the packages with the applied filters and load the destination relationship
	    $packages = $query->with('destination')->get();

	    return view('admin.packages', compact('packages'));
	}

	public function show($id)
	{
		$package = Package::find($id);
		$uuid = $package->uuid;
		$services = Service::all();
		if (!$package) {
			return redirect()->back()->with('error','Record not found');
		}

		$destinations = Destination::all();
		$price = $package->prices->pluck('price', 'currency_id')->toArray();

		return view('admin.packages', compact('package', 'destinations','price','services','uuid'));
	}

	public function action(Request $request)
	{
		$data = $request->all();
		foreach($request->input('boxchecked') as $action)
		{
			if($request->input('cmbaction') == 'Delete')
			{
				Package::where('uuid', $action)->delete();
			}
			elseif($request->input('cmbaction') == 'Active')
			{
				Package::where('uuid', $action)->update(['status' => '1']);
			}
			elseif($request->input('cmbaction') == 'Inactive')
			{
				Package::where('uuid', $action)->update(['status' => '2']);
			}
			else
			{
				return redirect()->back()->with('error', 'Action Invalid.');
			}
		}

		return redirect()->back()->with('success', 'Action successfully completed.');
	}

	public function setting(Request $request)
	{
		Package::where('uuid',$request->uuid)->update([
			'trending' => $request->trending == 'on' ? 1 : 2,
			'special' => $request->special == 'on' ? 1 : 2,
			'featured' => $request->featured == 'on' ? 1 : 2,
			'view_on_home' => $request->view_on_home == 'on' ? 1 : 2,
		]);
		return redirect()->back()->with('success', 'setting updated successfully completed.');
	}

	public function create()
	{
		$destinations = Destination::where('destination_type',1)->get();

		$services = Service::all();
		return view('admin.packages', compact('destinations','services'));
	}

	public function store(Request $request)
	{
		$fullUrl = request()->getRequestUri();
		if (str_contains($fullUrl, 'ramta-yogi')) {
		$queryParam = 'ramta-yogi';

		}elseif (str_contains($fullUrl, 'domestic')) {
		$queryParam = 'domestic';

		} elseif (str_contains($fullUrl, 'international')) {
		$queryParam = 'international';

		} elseif (str_contains($fullUrl, 'visa')) {
		$queryParam = 'visa';

		} else {
		$queryParam = '';
		}

		$uuid = $request->uuid ? $request->uuid : generateRandomNumber(); 


		foreach (Language::all() as $value) {
			if (!empty($request[$value->id]['package_name'])) {
				$checkName = Package::where('package_name',$request[$value->id]['package_name'])->where('uuid','!=',$uuid)->count();
				if ($checkName > 0) {
					return redirect()->back()->with('error', 'Package Name already taken');
				}
				$activities = [];
				if(array_key_exists('activities', $request[$this->appSetting->default_language]))
				{
					$activities = $request[$this->appSetting->default_language]['activities'];
				}
				$data = [
					'language_id'           => $value->id,
					'uuid'                  => $uuid,
					'destination_id'        => $request[$this->appSetting->default_language]['destination_id'],
					'service_id'            => $request[$this->appSetting->default_language]['service_id'],
					'package_type'            => $request[$this->appSetting->default_language]['package_type'],
					'data_for'            => $request[$this->appSetting->default_language]['data_for'],
					'activities'            => json_encode($activities),
					'package_name'          => $request[$value->id]['package_name'],
					'slug'                  => Str::slug($request[$value->id]['package_name']),
					'description'           => $request[$value->id]['description'],
					'duration'              => $request[$value->id]['duration'],
					'inclusions'      => !empty($request[$value->id]['inclusions']) && $request[$value->id]['inclusions'][0] !== null ? json_encode($request[$value->id]['inclusions']) : json_encode([]),
					'exclusions'      => !empty($request[$value->id]['exclusions']) && $request[$value->id]['exclusions'][0] !== null ? json_encode($request[$value->id]['exclusions']) : json_encode([]),
					'itinerary'       => !empty($request[$value->id]['itinerary']) && $request[$value->id]['itinerary'][0]['title'] !== null ? json_encode($request[$value->id]['itinerary']) : json_encode([]),
					'available_dates' => !empty($request[$value->id]['available_dates']) && $request[$value->id]['available_dates'][0]['start_date'] !== null ? json_encode($request[$value->id]['available_dates']) : json_encode([]),
					'terms_and_conditions'  => $request[$value->id]['terms_and_conditions'],
					'status'                => 1,
					'special'               => $request->special == 'on' ? 1 : 2,
				];

                // Add dynamic price fields to the data array
				if (isset($request[$this->appSetting->default_language]['price']) && is_array($request[$this->appSetting->default_language]['price'])) {
					foreach ($request[$this->appSetting->default_language]['price'] as $currencyId => $price) {
						$data['price_in_currency_' . $currencyId] = $price;
					}
				}

                // Create or update the package
				$package = Package::updateOrCreate(
					['uuid' => $uuid, 'language_id' => $value->id],
					$data
				);

                // Handle images upload
				if ($request->hasFile("{$value->id}.images")) {
					// if (!$package->wasRecentlyCreated) {
					// 	$package->images()->delete();
					// }
					foreach ($request->file("{$value->id}.images") as $key => $image) {
						$name = time() . '-'.$key.'-.' . $image->getClientOriginalExtension();
						$destinationPath = public_path('/uploads/packages');
						$image->move($destinationPath, $name);
						$imagePath = 'uploads/packages/' . $name;
						PackageImage::create(['package_id' => $package->id, 'image_path' => $imagePath]);
					}
				}

                // Handle pricing for the default language
				if ($value->id == $this->appSetting->default_language) {
					$package->prices()->delete();
					foreach ($request[$value->id]['price'] as $currencyId => $price) {
						PackagePrice::create([
							'package_id'   => $package->id,
							'currency_id'  => $currencyId,
							'price'        => $price,
						]);
					}
				}
			}
		}

		if ($request[$this->appSetting->default_language]['data_for'] == 'activity') {
			$message = $request->uuid ? 'Activity successfully updated.' : 'Activity successfully created.';
			return redirect()->route('activities-list')->with('success', $message);
		}
		
		$message = $request->uuid ? 'Package successfully updated.' : 'Package successfully created.';
		return redirect()->route('packages-list',$queryParam)->with('success', $message);
	}


	public function edit($id)
	{
		$package = Package::with('prices','service')->find($id);
		$uuid = $package->uuid;
		$services = Service::all();
		if (!$package) {
			return redirect()->back()->with('error','Record not found');
			return redirect()->back();
		}

		$destinations = Destination::where('destination_type',$package->destination->destination_type)->get();
		$price = $package->prices->pluck('price', 'currency_id')->toArray();

		return view('admin.packages', compact('package', 'destinations','price','services','uuid'));
	}

	public function destroy($id)
	{
		$package = Package::find($id);

		if (!$package) {
			return redirect()->back()->with('error','Record not found');
			return redirect()->back();
		}

		$package->delete();

		return redirect()->back()->with('success', 'Package successfully deleted.');
	}

	public function imageDestroy(Request $request)
	{
		$image = PackageImage::find($request->image_id);
		if ($image) {

			File::delete(public_path($image->image_path));
			$image->delete();

			return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
		}

		return response()->json(['success' => false, 'message' => 'Image not found.']);
	}

	public function getDestinations(Request $request)
	{
		$destinationType = $request->get('destination_type');
		$destinations = Destination::where('destination_type', $destinationType)->get();
		return response()->json([
			'destinations' => $destinations
		]);
	}

	public function getPackageTypes(Request $request)
	{
		$packageTypes = Package::where('package_type', 'like', '%' . $request->query('term') . '%')
		->pluck('package_type')
		->unique();
		return response()->json($packageTypes);
	}
}
