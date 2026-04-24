<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis;
        $agents = Agent::when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->latest()->paginate(10);
        return view('agent.index', compact('agents', 'jenis'));
    }

    public function create()
    {
        return view('agent.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_agent'     => 'required|string|max:255',
            'nama_pic'       => 'required|string|max:255',
            'jenis'          => 'required|in:umroh,haji,keduanya',
            'no_telepon'     => 'required|string|max:20',
            'email'          => 'nullable|email',
            'alamat'         => 'nullable|string',
            'kota'           => 'nullable|string|max:100',
            'provinsi'       => 'nullable|string|max:100',
            'komisi_persen'  => 'nullable|numeric|min:0|max:100',
            'status'         => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();
        $data['kode_agent'] = 'AGT-' . strtoupper(uniqid());

        Agent::create($data);
        return redirect()->route('agent.index')->with('success', 'Data agent berhasil ditambahkan.');
    }

    public function show(Agent $agent)
    {
        $agent->load('pendaftarans.jamaah');
        return view('agent.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        return view('agent.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'nama_agent'     => 'required|string|max:255',
            'nama_pic'       => 'required|string|max:255',
            'jenis'          => 'required|in:umroh,haji,keduanya',
            'no_telepon'     => 'required|string|max:20',
            'email'          => 'nullable|email',
            'alamat'         => 'nullable|string',
            'kota'           => 'nullable|string|max:100',
            'provinsi'       => 'nullable|string|max:100',
            'komisi_persen'  => 'nullable|numeric|min:0|max:100',
            'status'         => 'required|in:aktif,nonaktif',
        ]);

        $agent->update($request->all());
        return redirect()->route('agent.index')->with('success', 'Data agent berhasil diperbarui.');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agent.index')->with('success', 'Data agent berhasil dihapus.');
    }
}
