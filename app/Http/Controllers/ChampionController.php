<?php
    
namespace App\Http\Controllers;
    
use App\Models\Champion;
use Illuminate\Http\Request;
use DB;
    
class ChampionController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:iwak-list|iwak-create|iwak-edit|iwak-delete', ['only' => ['index','show']]);
         $this->middleware('permission:iwak-create', ['only' => ['create','store']]);
         $this->middleware('permission:iwak-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:iwak-delete', ['only' => ['destroy','deletelist']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $keyword = $request->keyword;
        // $champions = Champion::where('nama_champion','LIKE','%'.$keyword.'%')
        //             ->paginate(10);
        // return view('champions.index',compact('champions'))
        //     ->with('i', (request()->input('page', 1) - 1) * 10);
        $keyword = $request->keyword;
        $champions = DB::table('champions')->where('nama_champion','LIKE','%'.$keyword.'%')
                    ->whereNull('deleted_at')
                    ->paginate(10);
        return view('champions.index',compact('champions'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('champions.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // request()->validate([
        //     'supplierid' => 'required',
        //     'suppliername' => 'required',
        //     'sphone' => 'required',
        //     'slocation' => 'required',
        // ]);
    
        // Supplier::create($request->all());
    
        // return redirect()->route('champions.index')
        //                 ->with('success','Supplier created successfully.');
        $request->validate([
            'id_champion' => 'required',
            'nama_champion' => 'required',
            'desc_champion' => 'required',
            'id_position' => 'required',
            'id_job' => 'required',
        ]);
        
        DB::insert('INSERT INTO champions(id_champion, nama_champion, desc_champion, id_position, id_job) VALUES (:id_champion, :nama_champion, :desc_champion, :id_position, :id_job)',
        [
            'id_champion' => $request->id_champion,
            'nama_champion' => $request->nama_champion,
            'desc_champion' => $request->desc_champion,
            'id_position' => $request->id_position,
            'id_job' => $request->id_job,
        ]
        );

        return redirect()->route('champions.index')->with('success', 'Champion added successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Champion $champion)
    {
        return view('champions.show',compact('champion'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function edit(Supplier $supplier)
    // {
    //     return view('champions.edit',compact('supplier'));
    // }
    public function edit($id)
    {
        $champion = DB::table('champions')->where('id_champion', $id)->first();
        return view('champions.edit',compact('champion'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Supplier $supplier)
    // {
    //      request()->validate([
    //         'supplierid' => 'required',
    //         'suppliername' => 'required',
    //         'sphone' => 'required',
    //         'slocation' => 'required',
    //     ]);
    
    //     $supplier->update($request->all());
    
    //     return redirect()->route('champions.index')
    //                     ->with('success','Supplier updated successfully');
    // }
    public function update($id, Request $request) {
        $request->validate([
            'id_champion' => 'required',
            'nama_champion' => 'required',
            'desc_champion' => 'required',
            'id_position' => 'required',
            'id_job' => 'required',
        ]);

        DB::update('UPDATE champions SET id_champion = :id_champion, nama_champion = :nama_champion, desc_champion = :desc_champion, id_position = :id_position, id_job = :id_job WHERE id_champion = :id',
        [
            'id' => $id,
            'id_champion' => $request->id_champion,
            'nama_champion' => $request->nama_champion,
            'desc_champion' => $request->desc_champion,
            'id_position' => $request->id_position,
            'id_job' => $request->id_job,
        ]
        );

        return redirect()->route('champions.index')->with('success', 'Champion updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Supplier $supplier)
    // {
    //     $supplier->delete();
    //     return redirect()->route('champions.index')
    //                     ->with('success','Supplier deleted successfully');
    // }
    public function destroy($id)
    {
        DB::update('UPDATE champions SET deleted_at = NOW() WHERE id_champion = :id_champion', ['id_champion' => $id]);
    
        return redirect()->route('champions.index')
                        ->with('success','champion deleted successfully');
    }
    
    public function deletelist()
    {
        // $champions = Supplier::onlyTrashed()->paginate(10);
        $champions = DB::table('champions')
                    ->whereNotNull('deleted_at')
                    ->paginate(10);
        return view('/champions/trash',compact('champions'))
            ->with('i', (request()->input('page', 1) - 1) * 10);

    }
    public function restore($id)
    {
        // $champions = Supplier::withTrashed()->where('supplierid',$id)->restore();
        DB::update('UPDATE champions SET deleted_at = NULL WHERE id_champion = :id_champion', ['id_champion' => $id]);
        return redirect()->route('champions.index')
                        ->with('success','Champion restored successfully');
    }
    public function deleteforce($id)
    {
        // $champions = Supplier::withTrashed()->where('SupplierID',$id)->forceDelete();
        DB::delete('DELETE FROM champions WHERE id_champion = :id_champion', ['id_champion' => $id]);
        return redirect()->route('champions.index')
                        ->with('success','Champion deleted permanently');
    }
}