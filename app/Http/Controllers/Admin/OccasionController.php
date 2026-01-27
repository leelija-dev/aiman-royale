<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OccasionRequest;
use App\Models\Occasion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OccasionController extends Controller
{
    /**
     * Display a listing of the occasions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // $occasions = Occasion::latest()->paginate(15);
        //     dd($occasions);
        // // echo "hi";  die;
        try {
            $occasions = Occasion::latest()->paginate(15);
            // dd($occasions);
            return view('Admin.occasions.index', compact('occasions'));
        } catch (\Exception $e) {
            Log::error('Error in OccasionController@index', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while retrieving occasions.');
        }
    }

    /**
     * Display a listing of the trashed occasions.
     *
     * @return \Illuminate\View\View
     */
    public function trash()
    {
        try {
            $occasions = Occasion::onlyTrashed()->latest()->paginate(15);
            return view('Admin.occasions.trash', compact('occasions'));
        } catch (\Exception $e) {
            Log::error('Error in OccasionController@trash', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while retrieving trashed occasions.');
        }
    }

    /**
     * Restore the specified occasion from trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        try {
            $occasion = Occasion::withTrashed()->findOrFail($id);
            $occasion->restore();

            return redirect()->route('admin.occasions.trash')
                ->with('success', 'Occasion has been restored successfully.');
        } catch (\Exception $e) {
            Log::error('Error restoring occasion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'An error occurred while restoring the occasion.');
        }
    }

    /**
     * Show the form for creating a new occasion.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try {
            $occasions = Occasion::latest()->get();
            return view('Admin.occasions.create', compact('occasions'));
        } catch (\Exception $e) {
            Log::error('Error in OccasionController@create', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while loading the create page.');
        }
    }

    /**
     * Store a newly created occasion in storage.
     *
     * @param  \App\Http\Requests\Admin\OccasionRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OccasionRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);

            
            
            Occasion::create($data);

            return redirect()->route('admin.occasions.index')
                ->with('success', 'Occasion created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating occasion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'An error occurred while creating the occasion.');
        }
    }

    /**
     * Show the form for editing the specified occasion.
     *
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\View\View
     */
    public function edit(Occasion $occasion)
    {
        try {
            Log::info('Editing occasion', ['id' => $occasion->id, 'name' => $occasion->name]);

            if (!$occasion) {
                Log::error('Occasion not found');
                abort(404);
            }

            $occasions = Occasion::where('id', '!=', $occasion->id)->latest()->get();
            
            // Debug: Log occasions data
            Log::info('Occasions for edit dropdown', [
                'current_occasion_id' => $occasion->id,
                'occasions_count' => $occasions->count(),
                'occasions' => $occasions->toArray()
            ]);
            
            return view('Admin.occasions.edit', compact('occasion', 'occasions'));
        } catch (\Exception $e) {
            Log::error('Error in OccasionController@edit', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while loading the edit page.');
        }
    }

    /**
     * Update the specified occasion in storage.
     *
     * @param  \App\Http\Requests\Admin\OccasionRequest  $request
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OccasionRequest $request, Occasion $occasion)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);

            $occasion->update($data);

            return redirect()->route('admin.occasions.index')
                ->with('success', 'Occasion updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating occasion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'An error occurred while updating the occasion.');
        }
    }

    /**
     * Remove the specified occasion from storage (soft delete).
     *
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Occasion $occasion)
    {
        try {
            $occasion->delete();

            return redirect()->route('admin.occasions.index')
                ->with('success', 'Occasion moved to trash successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting occasion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'An error occurred while moving the occasion to trash.');
        }
    }

    /**
     * Permanently delete the specified occasion from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        try {
            $occasion = Occasion::withTrashed()->findOrFail($id);
            $occasion->forceDelete();

            return redirect()->route('admin.occasions.trash')
                ->with('success', 'Occasion has been permanently deleted.');
        } catch (\Exception $e) {
            Log::error('Error force deleting occasion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'An error occurred while permanently deleting the occasion.');
        }
    }
}
