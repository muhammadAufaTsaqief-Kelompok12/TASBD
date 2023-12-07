<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use DB;

class PositionController extends Controller
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
        // $positions = position::where('nama_position','LIKE','%'.$keyword.'%')
        //             ->paginate(10);
        // return view('positions.index',compact('positions'))
        //     ->with('i', (request()->input('page', 1) - 1) * 10);
        $keyword = $request->keyword;
        $positions = DB::table('positions')->where('nama_position','LIKE','%'.$keyword.'%')
                    ->whereNull('deleted_at')
                    ->paginate(10);
        return view('positions.index',compact('positions'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //request()->validate([
        //     'supplierid' => 'required',
        //     'suppliername' => 'required',
        //     'sphone' => 'required',
        //     'slocation' => 'required',
        // ]);

        // Supplier::create($request->all());

        // return redirect()->route('positions.index')
        //                 ->with('success','Supplier created successfully.');
        $request->validate([
            'id_position' => 'required',
            'nama_position' => 'required',
            'desc_position' => 'required',
        ]);

        DB::insert('INSERT INTO positions(id_position, nama_position, desc_position) VALUES (:id_position, :nama_position, :desc_position)',
        [
            'id_position' => $request->id_position,
            'nama_position' => $request->nama_position,
            'desc_position' => $request->desc_position,
        ]
        );

        return redirect()->route('positions.index')->with('success', 'Position added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(position $position)
    {
        return view('positions.show',compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function edit(Supplier $supplier)
    // {
    //     return view('positions.edit',compact('supplier'));
    // }
    public function edit($id)
    {
        $position = DB::table('positions')->where('id_position', $id)->first();
        return view('positions.edit',compact('position'));
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

    //     return redirect()->route('positions.index')
    //                     ->with('success','Supplier updated successfully');
    // }
    public function update($id, Request $request) {
        $request->validate([
            'id_position' => 'required',
            'nama_position' => 'required',
            'desc_position' => 'required',
        ]);

        DB::update('UPDATE positions SET id_position = :id_position, nama_position = :nama_position, desc_position = :desc_position WHERE id_position = :id',
        [
            'id' => $id,
            'id_position' => $request->id_position,
            'nama_position' => $request->nama_position,
            'desc_position' => $request->desc_position,
        ]
        );

        return redirect()->route('positions.index')->with('success', 'position updated successfully');
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
    //     return redirect()->route('positions.index')
    //                     ->with('success','Supplier deleted successfully');
    // }
    public function destroy($id)
    {
        DB::update('UPDATE positions SET deleted_at = NOW() WHERE id_position = :id_position', ['id_position' => $id]);

        return redirect()->route('positions.index')
                        ->with('success','position deleted successfully');
    }

    public function deletelist()
    {
        // $positions = Supplier::onlyTrashed()->paginate(10);
        $positions = DB::table('positions')
                    ->whereNotNull('deleted_at')
                    ->paginate(10);
        return view('/positions/trash',compact('positions'))
            ->with('i', (request()->input('page', 1) - 1) * 10);

    }
    public function restore($id)
    {
        // $positions = Supplier::withTrashed()->where('supplierid',$id)->restore();
        DB::update('UPDATE positions SET deleted_at = NULL WHERE id_position = :id_position', ['id_position' => $id]);
        return redirect()->route('positions.index')
                        ->with('success','position restored successfully');
    }
    public function deleteforce($id)
    {
        // $positions = Supplier::withTrashed()->where('SupplierID',$id)->forceDelete();
        DB::delete('DELETE FROM positions WHERE id_position = :id_position', ['id_position' => $id]);
        return redirect()->route('positions.index')
                        ->with('success','position deleted permanently');
    }
}
