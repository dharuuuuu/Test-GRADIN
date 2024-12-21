<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courier;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $sortBy = $request->input('sort_by', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $levels = $request->input('levels', []);

        $couriers = Courier::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($levels, function ($query) use ($levels) {
                $query->whereIn('level', $levels);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->appends($request->query());


        return view('courier.index', compact('couriers', 'search', 'perPage', 'sortBy', 'sortDirection', 'levels'));
    }


    public function create()
    {
        return view('courier.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:couriers,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'level' => 'required|integer|between:1,5',
        ]);

        $courier = Courier::create($validated);

        if ($courier->exists) {
            return redirect()->route('courier.index')->with('success', 'Courier berhasil ditambahkan.');
        }

        return redirect()->route('courier.index')->with('error', 'Courier gagal ditambahkan.');
    }


    public function show($id)
    {
        $courier = Courier::findOrFail($id);

        return view('courier.show', compact('courier'));
    }


    public function edit($id)
    {
        $courier = Courier::findOrFail($id);
        return view('courier.edit', compact('courier'));
    }


    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:couriers,email,{$id}",
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'level' => 'required|integer|between:1,5',
        ]);

        $courier->update($validated);

        $updatedCourier = Courier::find($id);
        if ($updatedCourier && $updatedCourier->is($courier)) {
            return redirect()->route('courier.index')->with('success', 'Courier berhasil diperbarui.');
        }

        return redirect()->route('courier.index')->with('error', 'Courier gagal diperbarui.');
    }


    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);
        $courier->delete();

        $exists = Courier::where('id', $id)->exists();
        if ($exists) {
            return redirect()->route('courier.index')->with('error', 'Courier gagal dihapus.');
        }

        return redirect()->route('courier.index')->with('success', 'Courier berhasil dihapus.');
    }
}