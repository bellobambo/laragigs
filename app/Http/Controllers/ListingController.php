<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{

    // Show all listing
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // Show Single listing

    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // show create form

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        // dd($request->file('logo'));
        $formfields = $request->validate([
            'title' => 'required',
            'company' => ['required ', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formfields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formfields['user_id'] = auth()->id();

        Listing::create($formfields);


        return redirect('/')->with('message', 'Listing Created Successfully!');
    }

    //Show Edit Form

    public function edit(Listing $listing)
    {
        // dd($listing->title);
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing)
    {

        //make sure logged in user is owner

        if($listing->user_id != auth()->id()){
            abort(403 , 'Unauthorized Action');
        }


        // dd($request->file('logo'));
        $formfields = $request->validate([
            'title' => 'required',
            'company' => ['required '],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formfields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formfields);

        return back()->with('message', 'Listing Updated Successfully!');
    }

    // DELETE Listing

    public function destroy(Listing $listing)
    {

        if($listing->user_id != auth()->id()){
            abort(403 , 'Unauthorized Action');
        }


        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted Successfully');
    }


    //Manage Function
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
