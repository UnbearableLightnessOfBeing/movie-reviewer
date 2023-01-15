<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Inertia::render('Admin/Actions/Index');

        $perPage = $request->query('perPage') ?? 5;

        // return Inertia::render('Admin/Actions/Index', [
        //     'logs' => DB::table('log_message')->query()
        //                     ->when($request->input('search'), function($query, $search) {
        //                         $query->where('message', 'like', "%{$search}%");
        //                     })
        //                     ->paginate($perPage)
        //                     ->withQueryString(),
        //     'filters' => $request->only(['search', 'perPage']),
        // ]);

        $search = $request->input('search');
        return Inertia::render('Admin/Actions/Index', [
            'logs' => DB::table('log_messages')->where('message', 'like', "%{$search}%")
                            ->paginate($perPage)
                            ->withQueryString(),
            'filters' => $request->only(['search', 'perPage']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('log_messages')->where('id', $id)->delete();

        return redirect(route('admin.actions.index'));
    }
}
