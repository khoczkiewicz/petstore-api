<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'available');
        $pets = Pet::getByStatus($status);

        return view('pets.index', [
            'pets' => $pets,
            'error' => empty($pets) ? 'No pets found or failed to fetch pets.' : null,
        ]);
    }

    private function validatePet(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:available,pending,sold',
        ]);
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePet($request);

        $pet = Pet::create($validated);

        if ($pet && isset($pet['id'])) {
            return redirect()->route('pets.show', $pet['id'])->with('message', 'Pet created successfully.');
        }

        return back()->withErrors(['error' => 'Failed to create pet or invalid API response.']);
    }

    public function show($id)
    {
        $pet = Pet::getById($id);

        return $pet
            ? view('pets.show', ['pet' => $pet])
            : redirect()->route('pets.index')->withErrors(['error' => 'Pet not found or invalid API response.']);
    }

    public function edit($id)
    {
        $pet = Pet::getById($id);

        return $pet
            ? view('pets.edit', ['pet' => $pet])
            : redirect()->route('pets.index')->withErrors(['error' => 'Pet not found or invalid API response.']);
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validatePet($request);

        if (Pet::update($id, $validated)) {
            return redirect()->route('pets.index')->with('message', 'Pet updated successfully.');
        }

        return back()->withErrors(['error' => 'Failed to update pet or invalid API response.']);
    }

    public function destroy($id)
    {
        if (Pet::delete($id)) {
            return redirect()->route('pets.index')->with('message', 'Pet deleted successfully.');
        }

        return back()->withErrors(['error' => 'Failed to delete pet or invalid API response.']);
    }
}
