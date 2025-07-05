<div>
    <!-- Title -->
    <h5 class="register-login-title-form">کد تایید</h5>

    <!-- Form -->
    <form class="register-login-form" wire:submit.prevent="verify">

        <!-- Email -->
        <div class="parent-input group">
            <div class="text-gray-400 group-focus-within:text-public parent-icon-input">
                <i class="fa-regular fa-hashtag"></i>
            </div>
            <input wire:model="code" type="text" class="input-register-login" placeholder="کد تایید" required>
            @if (session('error'))
                <div class="text-red-600 text-sm mt-2">{{ session('error') }}</div>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-register-login">بررسی</button>
    </form>
</div>
