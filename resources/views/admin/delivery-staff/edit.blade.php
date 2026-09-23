<x-app-layout title="Edit Delivery Staff" header="Edit Delivery Staff">

    <div class="max-w-lg bg-white rounded-xl border border-gray-200 p-6 shadow-sm">

        @if($errors->any())
        <div class="mb-4 bg-status-danger-bg border border-red-200 text-status-danger text-sm px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.delivery-staff.update', $deliveryStaff) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Full name</label>
                <input type="text" name="name" value="{{ old('name', $deliveryStaff->name) }}" required autofocus
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-maroon-500 focus:ring-maroon-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $deliveryStaff->email) }}" required
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-maroon-500 focus:ring-maroon-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Phone number</label>
                <input type="text" name="phone" value="{{ old('phone', $deliveryStaff->phone) }}" required
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-maroon-500 focus:ring-maroon-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <div class="flex gap-4 mt-1">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="is_active" value="1" {{ old('is_active', $deliveryStaff->is_active) == 1 ? 'checked' : '' }} class="text-maroon-600 focus:ring-maroon-500"> Active
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="is_active" value="0" {{ old('is_active', $deliveryStaff->is_active) == 0 ? 'checked' : '' }} class="text-maroon-600 focus:ring-maroon-500"> Deactivated
                    </label>
                </div>
                <p class="text-[11px] text-gray-400 mt-1">Deactivating blocks their login without deleting the account or their delivery history.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">New password</label>
                    <input type="password" name="password"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                    <p class="text-[11px] text-gray-400 mt-1">Leave blank to keep current password.</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Confirm new password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                </div>
            </div>

            <div class="pt-2 flex gap-3">
                <button type="submit" class="bg-maroon-600 hover:bg-maroon-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow-sm">
                    Save Changes
                </button>
                <a href="{{ route('admin.delivery-staff.index') }}" class="text-sm text-gray-500 hover:text-gray-700 px-2 py-2.5">Cancel</a>
            </div>
        </form>
    </div>

</x-app-layout>