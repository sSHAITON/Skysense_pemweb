<div class="flex min-h-full flex-col justify-center sm:px-6 lg:px-8" id="login-form" x-data="{ showModal: false, errorMessage: '' }">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="/"> <img class="mx-auto h-40 w-auto" src="{{ asset('img/logoskysense.png') }}" alt="SkySense">
        </a>
        <h2 class=" text-center text-3xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Or
            <a href="/signup" class="font-medium text-blue-600 hover:text-blue-500">Sign up here</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <!-- Add this error message display near the form -->
            <div x-show="errorMessage" class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"
                x-cloak>
                <span x-text="errorMessage"></span>
            </div>
            <form class="space-y-6" action="{{ route('signin') }}" method="POST" @submit.prevent="handleSubmit">
                @csrf
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Forgot your
                            password?</a>
                    </div>
                </div>

                <!-- Sign In Button -->
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Sign in
                    </button>
                </div>
            </form>
            {{-- <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white px-2 text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="mt-6">
                    <button onclick="signInWithGoogle()"
                        class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50">
                        <span class="sr-only">Sign in with Google</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                            <path fill="currentColor"
                                d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z" />
                        </svg>
                        <span class="ml-2">Continue with Google</span>
                    </button>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Success Modal -->
    <div x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Sign in Successful!
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Welcome back! You have been successfully signed in.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add this import at the top of the script
    const {
        GoogleAuthProvider
    } = window.firebase.auth;

    async function signIn(e) {
        e.preventDefault();
        const form = document.querySelector('form');
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                // Show success modal using Alpine.js
                Alpine.data('login-form').showModal = true;

                // Redirect after delay
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            }
        } catch (error) {
            alert(error.message);
        }
    }

    async function signInWithGoogle() {
        const provider = new GoogleAuthProvider();
        try {
            const result = await window.auth.signInWithPopup(provider);
            const token = await result.user.getIdToken();

            // Send token to your Laravel backend
            await fetch('/api/auth/verify-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    token
                })
            });

            window.location.href = '/';
        } catch (error) {
            alert(error.message);
        }
    }

    function handleSubmit(e) {
        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.errorMessage = '';
                    this.showModal = true;
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 2000);
                } else {
                    this.errorMessage = data.message || 'Invalid credentials. Please try again.';
                }
            })
            .catch(error => {
                this.errorMessage = 'An error occurred. Please try again.';
            });
    }
</script>
