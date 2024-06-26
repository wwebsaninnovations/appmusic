<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use Illuminate\Support\Facades\Auth;
class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $platforms = Platform::latest('id')->paginate(7);
        return view('admin.platforms.index',['platforms'=>$platforms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:platforms,name', // Ensure uniqueness among genres
        ]);

         $input = $request->all();
         $input['user_id'] = Auth::user()->id;
         Platform::create($input);
   
         return redirect()->route('platforms.index')
         ->withSuccess('New Platforms is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform)
    {
        return view('admin.platforms.edit', [
            'platform' => $platform]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platform $platform)
    {
         // Validate the incoming request data
         $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:platforms,name', 
           
        ]);
        // Update the book with the validated data
        $platform->update($validatedData);

        // Redirect back to the books index page
        return redirect()->route('platforms.index')
            ->withSuccess('Platform updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();
        return redirect()->route('platforms.index')
                ->withSuccess('Platform deleted successfully.');
    }
}
