<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
 
    public function index()
    {
        $configurations = Configuration::latest()->paginate(10);
        return view('configurations.index', compact('configurations'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        Post::create($request->all());

        return redirect()->route('configurations.index')->with('success', 'Configuration created successfully.');
    }
 
    public function edit(Configuration $configuration)
    {
        return view('configurations.edit', compact('configuration'));
    }
 
    public function update(Request $request, Configuration $configuration)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        $configuration->update($request->all());

        return redirect()->route('configurations.index')->with('success', 'Configuration updated successfully');
    }
 
}
