<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MasterTenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $tenants = Tenant::with('domains');
            return DataTables::eloquent($tenants)
                ->addIndexColumn()
                ->addColumn('domain', function ($row) {
                    $daftarDomain = [];
                    foreach ($row->domains as $domain) {
                        $daftarDomain[] = $domain->domain;
                    }

                    return implode('<br>', $daftarDomain);
                })
                ->rawColumns(['domain'])
                ->make(true);
        }

        $title = 'Daftar Tenant';
        return view('master.tenant.index')->with(compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Lokasi Tenant';
        return view('master.tenant.create')->with(compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'nama_tenant',
            'domain'
        ]);

        $request->validate([
            'nama_tenant' => 'required|unique:tenants,id',
            'domain' => 'required|unique:domains,domain'
        ]);

        $tenant = Tenant::create([
            'id' => $request->nama_tenant
        ]);

        Artisan::call('tenants:migrate-fresh', [
            '--tenants' => $request->nama_tenant,
        ]);

        Artisan::call('tenants:seed', [
            '--tenants' => $request->nama_tenant,
        ]);

        Domain::create([
            'domain' => $request->domain,
            'tenant_id' => $tenant->id
        ]);

        return redirect('/tenant')->with('success', 'Tenant berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $requestDomain = $request->domain;

        $existDomain = [];
        $deleteDomain = [];
        $domainList = $tenant->domains;
        foreach ($domainList as $domain) {
            if (!in_array($domain->domain, $requestDomain)) {
                $deleteDomain[] = $domain->id;
            } else {
                $existDomain[] = $domain->domain;
            }
        }

        $insertDomain = [];
        foreach ($requestDomain as $domain) {
            if (!in_array($domain, $existDomain)) {
                $insertDomain[] = [
                    'domain' => $domain,
                    'tenant_id' => $tenant->id
                ];
            }
        }

        if (count($insertDomain) > 0) {
            Domain::insert($insertDomain);
        }

        if (count($deleteDomain) > 0) {
            Domain::whereIn('id', $deleteDomain)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Domain tenant berhasil diupdate'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return response()->json([
            'success' => true,
            'message' => 'Tenant berhasil dihapus'
        ]);
    }
}
