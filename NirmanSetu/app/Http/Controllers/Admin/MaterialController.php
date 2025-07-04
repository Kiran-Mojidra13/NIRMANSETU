<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        return view('admin.inventory.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'quantity' => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',
        ]);

        Material::create($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Material added!');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('admin.inventory.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'quantity' => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',
        ]);

        $material = Material::findOrFail($id);
        $material->update($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Material updated!');
    }

    public function destroy($id)
    {
        Material::destroy($id);
        return redirect()->route('admin.inventory.index')->with('success', 'Material deleted!');
    }
}