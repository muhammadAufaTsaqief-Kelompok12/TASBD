<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JoinController extends Controller
{
    public function index()
    {
        $joins = DB::table('champions')
            ->join('positions', 'champions.id_position', '=', 'positions.id_position')
            ->join('jobs', 'champions.id_job', '=', 'jobs.id_job')
            ->select('champions.nama_champion as nama_champion', 'champions.desc_champion as desc_champion', 'positions.nama_position as nama_position', 'jobs.nama_job as nama_job')
            ->paginate(10);
            //dd($joins)
            return view('totals.index',compact('joins'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
