<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ownershiptype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OwnershiptypeController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('permission:create-book|edit-book|delete-book|view-book', ['only' => ['index','show']]);
    //     $this->middleware('permission:create-book', ['only' => ['create','store']]);
    //     $this->middleware('permission:edit-book', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete-book', ['only' => ['destroy','trashedBooks','restoreBook','deleteBook']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

         $ownershiptypes = Ownershiptype::latest('id')->paginate(10);
         return view('admin.ownershiptypes.index',['ownershiptypes'=>$ownershiptypes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.ownershiptypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:ownershiptypes,name', // Ensure uniqueness among genres
        ]);

         $input = $request->all();
         $input['user_id'] = Auth::user()->id;
         Ownershiptype::create($input);
   
         return redirect()->route('ownershiptypes.index')
         ->withSuccess('New Ownership Type is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Genre $genre)
    // {
    //     return view('admin.genre.show', ['book'=>$genre]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ownershiptype $ownershiptype)
    {
        return view('admin.ownershiptypes.edit', [
            'ownershiptype' => $ownershiptype]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ownershiptype $ownershiptype)
    {
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:ownershiptypes,name', 
           
        ]);
        // Update the book with the validated data
        $ownershiptype->update($validatedData);

        // Redirect back to the books index page
        return redirect()->route('ownershiptypes.index')
            ->withSuccess('Ownershiptype updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ownershiptype $ownershiptype)
    {
        $ownershiptype->delete();
        return redirect()->route('ownershiptypes.index')
                ->withSuccess('Ownershiptype delete successfully.');
    }

  


}