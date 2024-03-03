<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\UserContact;
use App\Models\Networks;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Validation\Rule;



class UserContactController extends Controller
{

    // Helper function to get operator logo based on operator name
    private function getOperatorLogo($operatorName)
    {
        $network = Networks::where('ntw_name', $operatorName)->first();
        return $network ? $network->ntw_logo : null;
    }

    // show customers user contact
    public function show_contact()
    {
        try {
            $user = auth()->user();
            $contacts = UserContact::where('user_id', $user->id)
                ->get(['name', 'phone', 'country_iso', 'country_name', 'operator_name', 'operator_logo', 'is_favorite', 'id']);

            // Cast boolean values to proper true/false representation
            $contactsArray = collect($contacts)->map(function ($contact) {
                return array_merge($contact->toArray(), [
                    'is_favorite' => (bool) $contact->is_favorite,
                ]);
            });

            return response()->json([
                'message' => 'Contacts retrieved successfully',
                'current_user_id' => $user->id,
                'data' => $contactsArray,
            ], 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            Log::error('Error retrieving contacts: ' . $e->getMessage());
            return response()->json(['message' => 'Error retrieving contacts', 'error' => $e->getMessage()], 500);
        }
    }

    // Create methode
    public function create_contacts(Request $request)
    {
        try {
            $user = auth()->user();
            $phone = $request->phone;
            $operator_name = $request->operator_name;

            $countries = new Countries();
            $countryISOs = $countries->all()->pluck('cca3')->toArray();
            $countryNames = $countries->all()->pluck('name.common')->toArray(); // Change here
            $validatedData = $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'operator_name' => 'required|uppercase',
                'country_iso' => ['required', Rule::in($countryISOs)],
                'country_name' => ['required', Rule::in($countryNames)],
            ]);

            $validatedData['country_iso'] = $request->input('country_iso');
            $validatedData['operator_name'] = $operator_name;
            $validatedData['user_id'] = $user->id; // Associate with the current user

            $phoneExists = UserContact::where('user_id', $user->id)->where('phone', $request->phone)->exists();

            if ($phoneExists) {
                return response()->json([
                    'title' => 'Phone Number Conflict',
                    'content' => 'A contact with this phone number already exists. Please review your information or edit the existing contact.'
                ], 409);
            }

            // Check if the phone number already exists for the current user
            $phoneExists = UserContact::where('user_id', $user->id)->where('phone', $phone)->exists();
            if ($phoneExists) {
                return response()->json(['message' => 'Phone number already exists'], 400);
            }

            // $get_networks = Networks::where('ntw_name', $operator_name)->get();
            $get_networks = Networks::where('ntw_name', $operator_name)->get()->isEmpty() ? $operator_name : $get_networks->first()->ntw_name;

            if (!$get_networks) {
                return response()->json(['message' => 'Network not found.'], 404);
            }
            
            $contacts = [];
            foreach ($get_networks as $network) {
                $validatedData['operator_logo'] = '/storage/uploads/' . $network->ntw_logo;
                $contact = UserContact::create($validatedData);
                $contacts[] = $contact;
            }
           

            // Cast boolean values to proper true/false representation
            $contactsArray = collect($contacts)->map(function ($contact) {
                return array_merge($contact->toArray(), [
                    'is_favorite' => (bool) $contact->is_favorite,
                ]);
            });

            return response()->json([
                'message' => 'Contacts created successfully',
                'data' => $contactsArray,
            ], 201, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            Log::error('Error creating contacts: ' . $e->getMessage());
            return response()->json(['message' => 'Error creating contacts', 'error' => $e->getMessage()], 500);
        }
    }

    // methode to use is_favorite column in user contact part
    public function mark_favorite($id, Request $request)
    {
        try {
            $contact = UserContact::findOrFail($id);
            $isFavorite = $request->input('is_favorite') === 'false' ? false : true;
            $contact->update(['is_favorite' => $isFavorite]);
            $contact->refresh();
            $contact->is_favorite = $isFavorite;

            return response()->json([
                'message' => 'Contact marked as favorite successfully',
                'data' => $contact,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error marking contact as favorite: ' . $e->getMessage());
            return response()->json(['message' => 'Error marking contact as favorite', 'error' => $e->getMessage()], 500);
        }
    }

    // update methode
    public function update_contact(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $contact = UserContact::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if ($request->has('phone') && UserContact::where('phone', $request->phone)->where('user_id', $user->id)->where('id', '!=', $contact->id)->exists()) {
                return response()->json([
                    'title' => 'Phone Number Conflict',
                    'content' => 'A contact with this phone number already exists. Please review your information or edit the existing contact.'
                ], 409);
            }

            if (!$contact) {
                return response()->json(['message' => 'Contact not found.'], 404);
            }

            $phone = $request->phone;
            $operator_name = $request->input('operator_name'); // Get operator_name from URL

            $countries = new Countries();
            $countryISOs = $countries->all()->pluck('cca3')->toArray();
            $countryNames = $countries->all()->pluck('name.common')->toArray();

            $validatedData = $request->validate([
                'name' => 'required',
                'phone' => 'nullable',
                'country_iso' => ['required', Rule::in($countryISOs)],
                'country_name' => ['required', Rule::in($countryNames)],
            ]);

            $validatedData['country_iso'] = $request->input('country_iso');
            $validatedData['country_name'] = $request->input('country_name');

            // Check if the phone number already exists
            $phoneExists = UserContact::where('phone', $phone)
                ->where('id', '!=', $id)
                ->exists();

            if ($phoneExists) {
                $validatedData['phone'] = $phone; // Update the phone number
            }

            $get_networks = Networks::where('ntw_name', $operator_name)->get();
            if ($get_networks->isEmpty()) {
                return response()->json(['message' => 'Network not found.'], 404);
            }

            foreach ($get_networks as $network) {
                $validatedData['operator_name'] = $network->ntw_name;
                $validatedData['operator_logo'] = '/storage/uploads/' . $network->ntw_logo;

                $contact->update($validatedData); // Update the contact with new data
            }

            return response()->json([
                'message' => 'Contact updated successfully',
                'data' => $contact,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating contact: ' . $e->getMessage());
            return response()->json(['message' => 'Error updating contact', 'error' => $e->getMessage()], 500);
        }
    }

    // delete methode
    public function delete_contact($id)
    {
        try {
            $user = auth()->user();
            $contact = UserContact::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$contact) {
                return response()->json(['message' => 'Contact not found.'], 404);
            }

            $contact->delete();

            return response()->json([
                'message' => 'Contact deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting contact: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting contact', 'error' => $e->getMessage()], 500);
        }
    }
}
