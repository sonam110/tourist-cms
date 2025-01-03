<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response; // Correct namespace
use Str;
use DB;
use Auth;
use App\Models\Label;

class NewsletterController extends Controller
{
    protected $intime;
    
    public function __construct()
    {
        $this->intime = \Carbon\Carbon::now();
        $this->middleware('permission:newsletter-browse',['only' => ['index']]);
        $this->middleware('permission:newsletter-delete', ['only' => ['destroy','action']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = Newsletter::orderBy('id', 'DESC')->get();
            return view('admin.newsletter', compact('data'));
        } catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function destroy($id)
    {
        try 
        {
            $newsletter = Newsletter::find($id);
            if($newsletter)
            {
                $newsletter->delete();
                return redirect()->back()->with('delete', 'Newsletter Deleted Successfully');
            }
            return redirect()->back()->with('error', 'Record Not Found!');
        } catch (\Throwable $exception) {
            \Log::error($exception);
            DB::rollback();
            return $exception->getMessage();
        }
    }

    public function action(Request $request)
    {
        $data = $request->all();
        $emails = [];

        foreach ($request->input('boxchecked') as $action) {
            if ($request->input('cmbaction') == 'Delete') {
                Newsletter::where('id', $action)->delete();
            } elseif ($request->input('cmbaction') == 'Export') {
                $email = Newsletter::where('id', $action)->value('email');
                if ($email) {
                    $emails[] = $email;
                }
            } else {
                return redirect()->back()->with('error', 'Invalid Action.');
            }
        }

        if ($request->input('cmbaction') == 'Export' && count($emails) > 0) {
            $filename = "exported_emails_" . date('YmdHis') . ".csv";
            $handle = fopen($filename, 'w');
            fputcsv($handle, ['Email']); // CSV header

            foreach ($emails as $email) {
                fputcsv($handle, [$email]);
            }

            fclose($handle);

            return Response::download($filename)->deleteFileAfterSend(true);
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }



    public function export()
    {
        $emails = Newsletter::pluck('email');
        $filename = "exported_emails_" . date('YmdHis') . ".csv";
        $handle = fopen($filename, 'w');
        fputcsv($handle, ['Email']); // CSV header

        foreach ($emails as $email) {
            fputcsv($handle, [$email]);
        }

        fclose($handle);

        return Response::download($filename)->deleteFileAfterSend(true);
    }
}
