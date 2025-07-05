<div>
    <!-- Title -->
    <h5 class="register-login-title-form">ورود</h5>

    <!-- Form -->
    <form class="register-login-form" wire:submit.prevent="sendOtp">

        <!-- Email -->
        <div class="parent-input group">
            <div class="text-gray-400 group-focus-within:text-public parent-icon-input">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <input wire:model="email" type="email" class="input-register-login" placeholder="ایمیل" required>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="box-remember-forgotPassword">
            <div class="checkbox-container">
                <input wire:model="rememberMe" type="checkbox" id="rememberMe" class="custom-checkbox">
                <label for="rememberMe" class="checkbox-label">
                    <span class="checkmark">
                            <i class="fas fa-check"></i>
                    </span>
                    <span class="text">مرا به خاطر بسپار</span>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-register-login">ورود</button>

        <hr class="border-register-login">

        <!-- Login Link -->
        <div class="parent-link-register-login">
            <p class="question-account-register-login">حسابی ندارید؟</p>
            <a href="{{ route('auth.register') }}" class="answer-register-login">اکنون ثبت نام کنید!</a>
        </div>
    </form>
</div>
