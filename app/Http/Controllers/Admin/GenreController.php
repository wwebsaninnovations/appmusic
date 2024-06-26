<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
class GenreController extends Controller
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

         $genres = Genre::latest('id')->paginate(10);
         return view('admin.genre.index',['genres'=>$genres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name', // Ensure uniqueness among genres
        ]);

         $input = $request->all();
         $input['user_id'] = Auth::user()->id;
         Genre::create($input);
   
         return redirect()->route('genre.index')
         ->withSuccess('New Genre is added successfully.');
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
    public function edit(Genre $genre)
    {
        return view('admin.genre.edit', [
            'genre' => $genre]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name', 
           
        ]);
        // Update the book with the validated data
        $genre->update($validatedData);

        // Redirect back to the books index page
        return redirect()->route('genre.index')
            ->withSuccess('Genre updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('genre.index')
                ->withSuccess('Genre delete successfully.');
    }

  


}