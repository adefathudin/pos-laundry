<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6" x-data="{ showPassword: false }">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login</h2>
        <form action="/login" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 px-3 text-gray-600 focus:outline-none">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12m0 0a3 3 0 11-6 0 3 3 0 016 0zm-3 9c-4.418 0-8-4.03-8-9s3.582-9 8-9 8 4.03 8 9-3.582 9-8 9z" />
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.418 0-8-4.03-8-9s3.582-9 8-9c1.03 0 2.02.18 2.938.525M15 12m0 0a3 3 0 11-6 0 3 3 0 016 0zm6.121 6.121l-4.242-4.242m0 0l-4.242-4.242m4.242 4.242l4.242-4.242" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-blue-600">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>
            <button type="submit"
                class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Login
            </button>
        </form>
        <p class="mt-4 text-sm text-center text-gray-600">
            Don't have an account? <a href="/register" class="text-blue-600 hover:underline">Register</a>
        </p>
    </div>
</body>
</html>