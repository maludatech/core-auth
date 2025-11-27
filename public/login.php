<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>

<body class="h-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-4">

    <button id="themeToggle"
        class="absolute top-4 right-4 p-2 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
        <span id="themeIcon">🌙</span>
    </button>


    <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 text-center mb-6">
            Welcome Back
        </h1>

        <?php if (isset($_SESSION['login_error'])): ?>
            <p class="mb-4 text-red-500 text-sm"><?= $_SESSION['login_error'];
                                                    unset($_SESSION['login_error']) ?></p>
        <?php endif; ?>

        <form action="../handlers/login.inc.php" method="POST" class="space-y-4">

            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email"
                    class="w-full p-2 rounded-md border bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                    required>
            </div>

            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-300">Password</label>
                <input type="password" name="password"
                    class="w-full p-2 rounded-md border bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                    required>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-gray-700 dark:text-gray-300 text-sm">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>

                <a href="reset-request.php" class="text-blue-500 dark:text-blue-400 text-sm">
                    Forgot password?
                </a>
            </div>

            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition">
                Login
            </button>

            <p class="text-center text-gray-600 dark:text-gray-300 text-sm mt-3">
                Don’t have an account?
                <a href="signup.php" class="text-blue-500 dark:text-blue-400">Sign Up</a>
            </p>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const html = document.documentElement;
            const icon = document.getElementById("themeIcon");

            // load saved mode
            const saved = localStorage.getItem("theme") || "light";
            if (saved === "dark") {
                html.classList.add("dark");
                icon.textContent = "☀️"; // sun on dark mode
            }

            document.getElementById("themeToggle").addEventListener("click", () => {
                html.classList.toggle("dark");

                const isDark = html.classList.contains("dark");
                icon.textContent = isDark ? "☀️" : "🌙";

                localStorage.setItem("theme", isDark ? "dark" : "light");
            });
        });
    </script>

</body>

</html>