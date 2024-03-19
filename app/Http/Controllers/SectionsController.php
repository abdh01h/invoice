<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-sections', [
            'only' => ['index', 'show']
        ]);
        $this->middleware('permission:add-sections', [
            'only' => ['create','store']
        ]);
        $this->middleware('permission:edit-sections', [
            'only' => ['edit', 'update']
        ]);
        $this->middleware('permission:delete-sections', [
            'only' => ['destroy']
        ]);
    }

    public function index()
    {
        $sections = sections::orderBy('created_at', 'desc')->get();
        return view('sections.sections', compact('sections'));
    }

    public function create()
    {
        return redirect('/sections');
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_name' => [
                'required',
                'unique:sections',
                'regex:/(^[A-Za-z0-9 ]+$)+/',
                'max:255',
            ],
        ]);

        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name),
        ]);

        session()->flash('type', __('success'));
        session()->flash('title', __('Created Successful'));
        session()->flash('message', __('The Section Has Been Successfully Created.'));

        return redirect('/sections');
    }

    public function show(sections $sections)
    {
        return redirect('/sections');
    }

    public function edit(sections $sections)
    {
        return redirect('/sections');
    }

    public function update(Request $request)
    {
        $id = $request->id;

        $section = sections::find($id, ['section_name']);

        if($request->section_name == $section->section_name) {
            $request->validate([
                'section_name' => [
                    'required',
                    'regex:/(^[A-Za-z0-9 ]+$)+/',
                    'max:255',
                ],
            ]);
            sections::find($id)->update($request->except($request->id));
        } else {
            $request->validate([
                'section_name' => [
                    'required',
                    'unique:sections',
                    'regex:/(^[A-Za-z0-9 ]+$)+/',
                    'max:255',
                ],
            ]);
            sections::find($id)->update($request->except($request->id));
        }

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Updated Successful'));
        $request->session()->flash('message', __('The Section Has Been Successfully Updated.'));

        return redirect('/sections');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Deleted Successful'));
        $request->session()->flash('message', __('The Section Has Been Successfully Deleted.'));

        return redirect('/sections');
    }

}
