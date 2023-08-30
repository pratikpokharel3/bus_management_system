<?php

namespace App\Http\Controllers;

use App\Models\CustomerEnquiry;
use Illuminate\Http\Request;

class CustomerEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = CustomerEnquiry::filter(request(['search']))
            ->latest()
            ->paginate(10);

        return view('enquiry.index', [
            'enquiries' => $enquiries
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|max:255',
        ]);

        CustomerEnquiry::create($attributes);

        return back()->with('success', 'Thank You! Your Feedback is Appreciated.');
    }

    public function destroy(CustomerEnquiry $enquiry)
    {
        $enquiry->delete();

        return back()->with('success', 'Customer Enquiry Deleted Successfully.');
    }
}
