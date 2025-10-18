<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;

class SellerAuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        try {
            // If already logged in as seller, send to dashboard
            if (Auth::guard('seller')->check()) {
                return redirect()->route('dashboard');
            }

            return view('sellers.login');
        } catch (Exception $e) {
            Log::error('Error showing login form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load login page. Please try again.');
        }
    }

    /**
     * Handle login submission.
     */
    public function login(Request $request)
    {
        try {
            // Validate input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $remember = $request->filled('remember_me');

            // Log login attempt
            Log::info('Login attempt for email: ' . $credentials['email']);

            // Attempt authentication
            if (Auth::guard('seller')->attempt($credentials, $remember)) {
                $request->session()->regenerate();

                $seller = Auth::guard('seller')->user();
                Log::info('Successful login for seller: ' . $seller->business_name . ' (ID: ' . $seller->id . ')');

                // Check seller status before allowing access
                if ($seller->status !== \App\Models\Seller::STATUS_APPROVED) {
                    // Store email for status checking before logout
                    $sellerEmail = $seller->email;

                    Auth::guard('seller')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    // Redirect to appropriate inactive page based on status
                    switch ($seller->status) {
                        case \App\Models\Seller::STATUS_PENDING:
                            return redirect()->route('sellers.pending')->with('seller_email', $sellerEmail);
                        case \App\Models\Seller::STATUS_SUSPENDED:
                            return redirect()->route('sellers.suspended')->with('seller_email', $sellerEmail);
                        case \App\Models\Seller::STATUS_REJECTED:
                            return redirect()->route('sellers.rejected')->with('seller_email', $sellerEmail);
                        default:
                            return redirect()->route('login')
                                ->with('error', 'Account status unknown. Please contact support.');
                    }
                }

                return redirect()
                    ->intended(route('dashboard'))
                    ->with('success', 'Welcome back, ' . $seller->business_name . '!');
            }

            // Authentication failed
            Log::warning('Failed login attempt for email: ' . $credentials['email']);
            
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->onlyInput('email');

        } catch (ValidationException $e) {
            Log::error('Login validation error: ' . $e->getMessage());
            return back()
                ->withErrors($e->errors())
                ->onlyInput('email');
        } catch (QueryException $e) {
            Log::error('Database error during login: ' . $e->getMessage());
            return back()
                ->with('error', 'Database connection issue. Please try again later.')
                ->onlyInput('email');
        } catch (Exception $e) {
            Log::error('Unexpected error during login: ' . $e->getMessage());
            return back()
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->onlyInput('email');
        }
    }

    /**
     * Log the seller out.
     */
    public function logout(Request $request)
    {
        try {
            $seller = Auth::guard('seller')->user();
            $sellerName = $seller ? $seller->business_name : 'Unknown';
            
            Auth::guard('seller')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info('Seller logged out: ' . $sellerName);

            return redirect()
                ->route('login')
                ->with('success', 'You have been logged out successfully.');

        } catch (Exception $e) {
            Log::error('Error during logout: ' . $e->getMessage());
            
            // Force logout even if there's an error
            try {
                Auth::guard('seller')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            } catch (Exception $logoutError) {
                Log::error('Critical logout error: ' . $logoutError->getMessage());
            }

            return redirect()
                ->route('login')
                ->with('error', 'Logout completed, but there was an issue. Please try logging in again if needed.');
        }
    }

    /**
     * Show the registration form.
     */
    public function create()
    {
        try {
            return view('sellers.create');
        } catch (Exception $e) {
            Log::error('Error showing registration form: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to load registration page. Please try again.');
        }
    }

    /**
     * Handle the form submission and persist a new seller.
     */
    public function store(Request $request)
    {
        try {
            // Validate input with detailed rules
            $data = $request->validate([
                'business_name' => 'required|string|max:255|min:2',
                'email'         => 'required|email|unique:sellers,email|max:255',
                'description'   => 'nullable|string|max:1000',
                'working_hours' => 'nullable|string|max:500',
                'phone'         => 'nullable|string|max:20|min:10',
                'address'       => 'required|string|max:500|min:10',
                'latitude'      => 'required|numeric|between:-90,90',
                'longitude'     => 'required|numeric|between:-180,180',
                'password'      => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ], [
                // Custom error messages
                'business_name.required' => 'Business name is required.',
                'business_name.min' => 'Business name must be at least 2 characters.',
                'business_name.max' => 'Business name cannot exceed 255 characters.',
                'email.required' => 'Business email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered. Please use a different email or try logging in.',
                'email.max' => 'Email address is too long.',
                'description.max' => 'Business description cannot exceed 1000 characters.',
                'working_hours.max' => 'Working hours description cannot exceed 500 characters.',
                'phone.min' => 'Phone number must be at least 10 characters.',
                'phone.max' => 'Phone number cannot exceed 20 characters.',
                'address.required' => 'Business address is required.',
                'address.min' => 'Please provide a complete address (at least 10 characters).',
                'address.max' => 'Address cannot exceed 500 characters.',
                'latitude.required' => 'Latitude is required.',
                'latitude.numeric' => 'Latitude must be a valid number.',
                'latitude.between' => 'Latitude must be between -90 and 90.',
                'longitude.required' => 'Longitude is required.',
                'longitude.numeric' => 'Longitude must be a valid number.',
                'longitude.between' => 'Longitude must be between -180 and 180.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
            ]);

            // Sanitize working hours if provided
            if (!empty($data['working_hours'])) {
                $data['working_hours'] = trim($data['working_hours']);
                Log::info('Working hours selected: ' . $data['working_hours']);
            }

            // Use database transaction for data integrity
            DB::beginTransaction();

            try {
                // Set default status to pending for new sellers
                $data['status'] = Seller::STATUS_PENDING;
                $data['is_active'] = false; // Keep for backward compatibility

                // Create seller
                $seller = Seller::create($data);
                
                if (!$seller) {
                    throw new Exception('Failed to create seller account');
                }

                Log::info('New seller registered: ' . $seller->business_name . ' (' . $seller->email . ')');
                
                // Log working hours for verification
                if ($seller->working_hours) {
                    Log::info('Seller working hours saved: ' . $seller->working_hours);
                }

                DB::commit();

                // Redirect to login page with success message
                return redirect()
                    ->route('login')
                    ->with([
                        'registration_success' => 'Welcome to GreenCup! Your business account has been created successfully. Please sign in.',
                        'registration_email' => $seller->email
                    ]);

            } catch (Exception $e) {
                DB::rollBack();
                throw $e; // Re-throw to be caught by outer catch
            }

        } catch (ValidationException $e) {
            Log::error('Registration validation error: ' . json_encode($e->errors()));
            return back()
                ->withErrors($e->errors())
                ->withInput($request->except('password', 'password_confirmation'));

        } catch (QueryException $e) {
            Log::error('Database error during registration: ' . $e->getMessage());
            
            // Check for specific database errors
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return back()
                    ->withErrors(['email' => 'This email is already registered. Please use a different email.'])
                    ->withInput($request->except('password', 'password_confirmation'));
            }

            if (str_contains($e->getMessage(), 'Data too long')) {
                return back()
                    ->withErrors(['general' => 'One of the fields contains too much data. Please check your inputs.'])
                    ->withInput($request->except('password', 'password_confirmation'));
            }

            return back()
                ->with('error', 'Database error occurred. Please try again later.')
                ->withInput($request->except('password', 'password_confirmation'));

        } catch (Exception $e) {
            Log::error('Unexpected error during registration: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()
                ->with('error', 'An unexpected error occurred during registration. Please try again.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Check seller status (for AJAX polling from status pages)
     */
    public function checkStatus(Request $request)
    {
        try {
            $email = $request->input('email');

            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email is required'
                ], 400);
            }

            $seller = Seller::where('email', $email)->first();

            if (!$seller) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seller not found'
                ], 404);
            }

            // Return seller status
            return response()->json([
                'success' => true,
                'status' => $seller->status,
                'is_approved' => $seller->status === Seller::STATUS_APPROVED,
                'business_name' => $seller->business_name
            ]);

        } catch (Exception $e) {
            Log::error('Error checking seller status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error checking status'
            ], 500);
        }
    }

    /**
     * Get available working hours options for dropdowns
     */
    public static function getWorkingHoursOptions()
    {
        return [
            // Standard Business Hours
            'Mon-Fri 9AM-5PM',
            'Mon-Fri 8AM-5PM',
            'Mon-Fri 9AM-6PM',
            'Mon-Fri 8AM-6PM',

            // Including Saturday
            'Mon-Sat 9AM-5PM',
            'Mon-Sat 8AM-6PM',
            'Mon-Sat 10AM-6PM',
            'Tue-Sat 9AM-5PM',

            // 7 Days a Week
            'Mon-Sun 9AM-5PM',
            'Mon-Sun 8AM-8PM',
            '24/7',

            // Retail & Restaurant
            'Mon-Thu 10AM-9PM, Fri-Sat 10AM-10PM, Sun 12PM-8PM',
            'Mon-Sun 10AM-10PM',
            'Mon-Sun 11AM-11PM',
            'Mon-Thu 5PM-11PM, Fri-Sat 5PM-12AM, Sun 5PM-10PM',

            // Flexible & Part-time
            'Mon-Wed-Fri 9AM-3PM',
            'Tue-Thu 2PM-8PM',
            'Weekends Only (Sat-Sun 9AM-6PM)',
            'By Appointment Only',
            'Seasonal Hours (Call for Schedule)',

            // Professional Services
            'Mon-Fri 8AM-4PM',
            'Mon-Fri 10AM-7PM',
            'Mon-Fri 9AM-5PM, Sat 9AM-2PM',
            'Emergency Service Available 24/7',
        ];
    }
}