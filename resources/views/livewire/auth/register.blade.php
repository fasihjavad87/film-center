<div>
    <!-- Title -->
    <h5 class="register-login-title-form">ثبت نام</h5>

    <!-- Form -->
    <form class="register-login-form" wire:submit.prevent="sendOtp">
        <!-- First Name -->
        <div class="parent-input group">
            <div class=" text-gray-400 group-focus-within:text-public parent-icon-input">
                <i class="fa-regular fa-user"></i>
            </div>
            <input wire:model="name" type="text" class="input-register-login" placeholder="نام و نام خانوادگی" required>
        </div>

        <!-- Email -->
        <div class="parent-input group">
            <div class="text-gray-400 group-focus-within:text-public parent-icon-input">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <input wire:model="email" type="email" class="input-register-login" placeholder="ایمیل" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-register-login">ثبت نام</button>

        <hr class="border-register-login">

        <!-- Login Link -->
        <div class="parent-link-register-login">
            <p class="question-account-register-login">حساب کاربری دارید؟</p>
            <a href="{{ route('login') }}" class="answer-register-login">ورود</a>
        </div>
    </form>
</div>
