<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pelanggan;



class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Daftar kolom yang bisa difilter sesuai name pada form
        $filterableColumns = ['gender'];

        $searchableColumns = ['first_name','last_name','email']; //Tambahkan ini

        // Gunakan scope filter untuk memproses query
        $pageData['dataPelanggan'] = Pelanggan::filter($request, $filterableColumns)
        ->search($request, $searchableColumns) // dan ini
        ->paginate(10)
        ->withQueryString();

        $data['dataPelanggan'] = Pelanggan::paginate(10);
        return view('admin.pelanggan.index', $pageData);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validasi input data
    $validated = $request->validate([
        'first_name' => 'required',
        'last_name'  => 'required',
        'birthday'   => 'required|date',
        'gender'     => 'required|in:Male,Female',
        'email'      => 'required|email',
        'phone'      => 'required|numeric',
    ]);

    // Simpan data jika validasi lolos
    Pelanggan::create($validated);

    return redirect()->route('pelanggan.index')->with('success', 'Penambahan Data Berhasil!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Melengkapi fungsi edit yang sebelumnya kosong
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    // Validasi input data
    $validated = $request->validate([
        'first_name' => 'required',
        'last_name'  => 'required',
        'birthday'   => 'required|date',
        'gender'     => 'required|in:Male,Female',
        'email'      => 'required|email',
        'phone'      => 'required|numeric',
    ]);

    // Cari data dan perbarui
    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->update($validated);

    return redirect()->route('pelanggan.index')->with('success', 'Perubahan Data Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::where('pelanggan_id', $id)->firstOrFail();
        $pelanggan->delete();


        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan Berhasil Dihapus!');
    }
}
