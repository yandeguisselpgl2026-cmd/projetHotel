<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function index(){
        return response()->json(
        Hotel::where('user_id', Auth::id())->get()
    );
    }

    public function store(Request $request){
$validated=$request->validate([
'nomHotel'=>'required|string',
'addresse'=>'required|string',
'numero'=>'required|string',
'email'=>'required|string',
'devise'=>'required|string',
'prixNuitee'=>'required|numeric|min:0',
"cheminImage" => "required|file|image|max:2048",



]);
 if ($request->hasFile('cheminImage')) {
        $path = $request->file('cheminImage')->store('hotels', 'public');
        $validated['cheminImage'] = $path;
    }
 $validated['user_id'] = Auth::id();
$hotel=Hotel::create($validated);
return response()->json($hotel);
    }



    public function update(Request $request, $id) {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

       $validated=$request->validate([
           'nomHotel'=>'required|string',
'addresse'=>'required|string',
'numero'=>'required|string',
'email'=>'required|string',
'devise'=>'required|string',
'prixNuitee'=>'required|numeric|min:0',
'cheminImage' => 'nullable|file|image|max:2048',
        ]);
 if ($request->hasFile('cheminImage')) {
        $path = $request->file('cheminImage')->store('hotels', 'public');
        $validated['cheminImage'] = $path;
    }
$hotel->update($validated);
        return response()->json($hotel);
    }


   
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->user_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $hotel->delete();

        return response()->json(['message' => 'Hôtel supprimé avec succès']);
    }


   public function show($id)
{
    $hotel = Hotel::find($id);

    if (!$hotel) {
        return response()->json(['message' => 'Hôtel non trouvé'], 404);
    }

    return response()->json($hotel);
}

}
