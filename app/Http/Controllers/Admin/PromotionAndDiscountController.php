<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromotionAndDiscount;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class PromotionAndDiscountController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:promotion-and-discount-browse',['only' => ['index']]);
        $this->middleware('permission:promotion-and-discount-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:promotion-and-discount-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:promotion-and-discount-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        try 
        {
            $data = PromotionAndDiscount::get();
            return view('admin.promotion_and_discounts')->with('data', $data);
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function show($id)
    {
        try 
        {
            $promotionAndDiscount = PromotionAndDiscount::find($id);
            if(!$promotionAndDiscount)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.promotion_and_discounts', compact('promotionAndDiscount'));
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function create()
    {
        try{
            return view('admin.promotion_and_discounts');
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
        // Validate the request inputs
            $this->validate($request, [
                'title' => 'required',
                'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'discount_type' => 'required|in:1,2',
                'discount_value' => 'required|numeric|min:0',
                'min_applicable_amount' => 'nullable|numeric|min:0',
                'expiry_date' => 'nullable|date',
                'usage_limit' => 'nullable|integer|min:0',
                'usage_limit_per_user' => 'nullable|integer|min:0',
            ]);

        // Generate coupon code if not provided
            $coupon_code = $request->coupon_code ?? substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 8);

        // Prepare the data for insertion/updation
            $data = [
                'language_id' => $request->language_id ?? $this->appSetting->default_language,
                'title' => $request->title,
                'coupon_code' => $coupon_code,
                'description' => $request->description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'min_applicable_amount' => $request->min_applicable_amount,
                'expiry_date' => $request->expiry_date,
                'usage_limit' => $request->usage_limit,
                'usage_limit_per_user' => $request->usage_limit_per_user,
                'status' => $request->status ?? 1,
            ];

        // Handle image upload
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/PromotionAndDiscounts');
                $image->move($destinationPath, $name);
                $data['image_path'] = 'uploads/PromotionAndDiscounts/' . $name;
            }

        // Check if the request is for updating an existing record
            if (!empty($request->id)) {
                $promotionAndDiscount = PromotionAndDiscount::find($request->id);
                $promotionAndDiscount->update($data);
                return redirect()->route('promotion-and-discounts-list')->with('success', 'Promotion and Discount successfully updated.');
            } else {
            // Create a new record
                PromotionAndDiscount::create($data);
                return redirect()->route('promotion-and-discounts-list')->with('success', 'Promotion and Discount successfully created.');
            }
        } catch (Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }


    public function edit($id)
    {
        try 
        {
            $promotionAndDiscount = PromotionAndDiscount::find($id);
            if(!$promotionAndDiscount)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.promotion_and_discounts', compact('promotionAndDiscount'));
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function destroy($id)
    {
        try 
        {
            $promotionAndDiscount = PromotionAndDiscount::find($id);
            if(!$promotionAndDiscount)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            $promotionAndDiscount->delete();
            return redirect()->back()->with('delete', 'PromotionAndDiscount successfully deleted.');
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    

    public function action(Request $request)
    {
        $data = $request->all();
        foreach($request->input('boxchecked') as $action)
        {
            if($request->input('cmbaction') == 'Delete')
            {
                PromotionAndDiscount::where('id', $action)->delete();
            }
            elseif($request->input('cmbaction') == 'Active')
            {
                PromotionAndDiscount::where('id', $action)->update(['status' => '1']);
            }
            else
            {
                PromotionAndDiscount::where('id', $action)->update(['status' => '2']);
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }
}
