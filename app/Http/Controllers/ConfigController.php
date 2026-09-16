<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ConfigController extends Controller
{
    public function index()
    {
        $configs = Config::latest()->get();
        return view('admin.configs.index', compact('configs'));
    }

    public function create()
    {
        return view('admin.configs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key'        => 'required|string|unique:configs,key|max:255',
            'type'       => 'required|in:text,image',
            'value'      => 'required_if:type,text|nullable|string',
            'value_file' => 'required_if:type,image|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $value = $request->value;

        if ($request->type === 'image' && $request->hasFile('value_file')) {
            $imageName = time() . '_' . $request->file('value_file')->getClientOriginalName();
            $request->file('value_file')->move(public_path('configs'), $imageName);
            $value = 'configs/' . $imageName;
        }

        Config::create([
            'key'   => $request->key,
            'type'  => $request->type,
            'value' => $value,
        ]);

        return redirect()->route('admin.config.index')->with('success', 'Config created successfully.');
    }

    public function show(string $id)
    {
        $config = Config::findOrFail($id);
        return view('admin.configs.show', compact('config'));
    }

    public function edit(string $id)
    {
        $config = Config::findOrFail($id);
        return view('admin.configs.edit', compact('config'));
    }

    public function update(Request $request, string $id)
    {
        $config = Config::findOrFail($id);

        $request->validate([
            'key'        => 'required|string|max:255|unique:configs,key,' . $id,
            'type'       => 'required|in:text,image',
            'value'      => 'required_if:type,text|nullable|string',
            'value_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $value = $request->type === 'text' ? $request->value : $config->value;

        if ($request->type === 'image' && $request->hasFile('value_file')) {
            // Delete old image from public directory if exists
            if ($config->value && File::exists(public_path($config->value))) {
                File::delete(public_path($config->value));
            }

            $imageName = time() . '_' . $request->file('value_file')->getClientOriginalName();
            $request->file('value_file')->move(public_path('configs'), $imageName);
            $value = 'configs/' . $imageName;
        }

        $config->update([
            'key'   => $request->key,
            'type'  => $request->type,
            'value' => $value,
        ]);

        return redirect()->route('admin.config.index')->with('success', 'Config updated successfully.');
    }

    public function destroy(string $id)
    {
        $config = Config::findOrFail($id);
        $config->delete();

        return redirect()->route('admin.config.index')->with('success', 'Config deleted successfully.');
    }
}