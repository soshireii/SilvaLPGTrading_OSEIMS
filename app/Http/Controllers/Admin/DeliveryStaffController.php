<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class DeliveryStaffController extends Controller
{
    /**
     * Delivery staff are NOT permanent employees (unlike the cashier account),
     * so unlike other roles they are fully manageable here: the owner can
     * create, edit, activate/deactivate, and delete them. A delivery account
     * only ever exists if the owner created it — there is no public
     * registration path for the "delivery" role.
     */
    public function index(): View
    {
        $deliveryStaff = User::where('role', 'delivery')
            ->withCount(['deliveries as active_deliveries_count' => function ($query) {
                $query->whereNotIn('status', ['completed', 'cancelled']);
            }])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.delivery-staff.index', compact('deliveryStaff'));
    }

    public function create(): View
    {
        return view('admin.delivery-staff.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'delivery',
            'is_active' => true,
            'email_verified_at' => now(), // owner-created, so no email verification step needed
        ]);

        return redirect()
            ->route('admin.delivery-staff.index')
            ->with('status', 'Delivery staff account created.');
    }

    public function edit(User $deliveryStaff): View
    {
        abort_unless($deliveryStaff->role === 'delivery', 404);

        return view('admin.delivery-staff.edit', compact('deliveryStaff'));
    }

    public function update(Request $request, User $deliveryStaff): RedirectResponse
    {
        abort_unless($deliveryStaff->role === 'delivery', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($deliveryStaff->id)],
            'phone' => ['required', 'string', 'max:20'],
            'is_active' => ['required', 'boolean'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $deliveryStaff->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'is_active' => $validated['is_active'],
        ]);

        if (!empty($validated['password'])) {
            $deliveryStaff->password = Hash::make($validated['password']);
        }

        $deliveryStaff->save();

        return redirect()
            ->route('admin.delivery-staff.index')
            ->with('status', 'Delivery staff account updated.');
    }

    public function destroy(User $deliveryStaff): RedirectResponse
    {
        abort_unless($deliveryStaff->role === 'delivery', 404);

        $activeDeliveries = $deliveryStaff->deliveries()
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        if ($activeDeliveries > 0) {
            return back()->with(
                'error',
                "Can't delete {$deliveryStaff->name} — they still have {$activeDeliveries} active order(s) assigned. Reassign or complete/cancel those first."
            );
        }

        $deliveryStaff->delete();

        return redirect()
            ->route('admin.delivery-staff.index')
            ->with('status', 'Delivery staff account deleted.');
    }
}