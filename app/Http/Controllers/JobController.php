<?php
    
namespace App\Http\Controllers;
    
use App\Models\Job;
use Illuminate\Http\Request;
use DB;
    
class JobController extends Controller
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
        // $jobs = job::where('nama_job','LIKE','%'.$keyword.'%')
        //             ->paginate(10);
        // return view('jobs.index',compact('jobs'))
        //     ->with('i', (request()->input('page', 1) - 1) * 10);
        $keyword = $request->keyword;
        $jobs = DB::table('jobs')->where('nama_job','LIKE','%'.$keyword.'%')
                    ->whereNull('deleted_at')
                    ->paginate(10);
        return view('jobs.index',compact('jobs'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
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
    
        // return redirect()->route('jobs.index')
        //                 ->with('success','Supplier created successfully.');
        $request->validate([
            'id_job' => 'required',
            'nama_job' => 'required',
            'desc_job' => 'required',
        ]);
        
        DB::insert('INSERT INTO jobs(id_job, nama_job, desc_job) VALUES (:id_job, :nama_job, :desc_job)',
        [
            'id_job' => $request->id_job,
            'nama_job' => $request->nama_job,
            'desc_job' => $request->desc_job,
        ]
        );

        return redirect()->route('jobs.index')->with('success', 'Job added successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(job $job)
    {
        return view('jobs.show',compact('job'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function edit(Supplier $supplier)
    // {
    //     return view('jobs.edit',compact('supplier'));
    // }
    public function edit($id)
    {
        $job = DB::table('jobs')->where('id_job', $id)->first();
        return view('jobs.edit',compact('job'));
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
    
    //     return redirect()->route('jobs.index')
    //                     ->with('success','Supplier updated successfully');
    // }
    public function update($id, Request $request) {
        $request->validate([
            'id_job' => 'required',
            'nama_job' => 'required',
            'desc_job' => 'required',
        ]);

        DB::update('UPDATE jobs SET id_job = :id_job, nama_job = :nama_job, desc_job = :desc_job WHERE id_job = :id',
        [
            'id' => $id,
            'id_job' => $request->id_job,
            'nama_job' => $request->nama_job,
            'desc_job' => $request->desc_job,
        ]
        );

        return redirect()->route('jobs.index')->with('success', 'job updated successfully');
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
    //     return redirect()->route('jobs.index')
    //                     ->with('success','Supplier deleted successfully');
    // }
    public function destroy($id)
    {
        DB::update('UPDATE jobs SET deleted_at = NOW() WHERE id_job = :id_job', ['id_job' => $id]);
    
        return redirect()->route('jobs.index')
                        ->with('success','job deleted successfully');
    }
    
    public function deletelist()
    {
        // $jobs = Supplier::onlyTrashed()->paginate(10);
        $jobs = DB::table('jobs')
                    ->whereNotNull('deleted_at')
                    ->paginate(10);
        return view('/jobs/trash',compact('jobs'))
            ->with('i', (request()->input('page', 1) - 1) * 10);

    }
    public function restore($id)
    {
        // $jobs = Supplier::withTrashed()->where('supplierid',$id)->restore();
        DB::update('UPDATE jobs SET deleted_at = NULL WHERE id_job = :id_job', ['id_job' => $id]);
        return redirect()->route('jobs.index')
                        ->with('success','job restored successfully');
    }
    public function deleteforce($id)
    {
        // $jobs = Supplier::withTrashed()->where('SupplierID',$id)->forceDelete();
        DB::delete('DELETE FROM jobs WHERE id_job = :id_job', ['id_job' => $id]);
        return redirect()->route('jobs.index')
                        ->with('success','job deleted permanently');
    }
}