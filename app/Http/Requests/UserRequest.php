<?php
// app/Http/Requests/UserRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Checks if the {id} in the URL matches the authenticated user's ID.
     */
    public function authorize(): bool
    {
        // Get the 'id' parameter from the route
        $requestedUserId = $this->route('id');
        
        // Get the authenticated user's ID
        $authUserId = $this->user()->id;
        
        // Compare them (cast to int for strict comparison)
        return (int) $requestedUserId === $authUserId;
    }

    /**
     * Handle a failed authorization attempt.
     * Returns a proper JSON error response instead of a 500.
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Forbidden: You can only view your own profile.',
                'errors' => [
                    'authorization' => ['Access denied']
                ]
            ], 403) // HTTP Status Code 403 Forbidden
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // No rules needed for GET requests
        ];
    }
}