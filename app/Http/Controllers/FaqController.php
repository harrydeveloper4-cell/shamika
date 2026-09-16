<?php

namespace App\Http\Controllers;

use App\Models\FAQs; // Ya App\Models\Faq
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = FAQs::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        FAQs::create($request->only(['question', 'answer']));

        return redirect()->route('admin.faq.index')->with('success', 'FAQ created successfully.');
    }

    public function show(string $id)
    {
        $faq = FAQs::findOrFail($id);
        return view('admin.faqs.show', compact('faq'));
    }

    public function edit(string $id)
    {
        $faq = FAQs::findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, string $id)
    {
        $faq = FAQs::findOrFail($id);

        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq->update($request->only(['question', 'answer']));

        return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(string $id)
    {
        $faq = FAQs::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ deleted successfully.');
    }
}