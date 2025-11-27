<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up — CoreAuth</title>
    <meta name="description" content="Create your CoreAuth account — secure, fast, and developer-friendly." />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 flex flex-col transition-colors duration-300">

    <!-- Theme Toggle (same as landing page) -->
    <button id="themeToggle" aria-label="Toggle dark mode"
        class="fixed top-6 right-6 z-50 p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-900/5 dark:ring-gray-700 hover:scale-110 transition-all duration-300">
        <i data-lucide="moon" class="w-5 h-5"></i>
    </button>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-6 py-20">
        <div class="w-full max-w-md">

            <!-- Logo + Title -->
            <div class="text-center mb-10">
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-3">
                    Create Account
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Join the modern way to handle authentication
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white dark:bg-gray-900/70 backdrop-blur-xl rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 p-8">

                <!-- Error Message -->
                <?php if (isset($_SESSION['signup_error'])): ?>
                    <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 text-sm">
                        <?= htmlspecialchars($_SESSION['signup_error']);
                        unset($_SESSION['signup_error']); ?>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="../handlers/signup.inc.php" method="POST" class="space-y-6">

                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                            Username
                        </label>
                        <input type="text" name="username" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="johndoe">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                            Email Address
                        </label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="you@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                            Password
                        </label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="••••••••••••">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold text-lg hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                        Create Account
                    </button>
                </form>

                <!-- Login Link -->
                <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <a href="login.php" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Log in here
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-8">
                <a href="../index.php" class="text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center justify-center gap-1">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to home
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-gray-800 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
        © <?= date('Y'); ?> CoreAuth — Built with ❤️ by Maluda
    </footer>

    <!-- Theme Toggle Script (100% working) -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const html = document.documentElement;
            const toggle = document.getElementById("themeToggle");
            const icon = toggle.querySelector('i');

            const updateIcon = () => {
                const isDark = html.classList.contains("dark");
                icon.setAttribute("data-lucide", isDark ? "sun" : "moon");
                lucide.createIcons();
            };

            // Apply saved or system preference
            const saved = localStorage.getItem("theme");
            if (saved === "dark" || (!saved && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                html.classList.add("dark");
            }

            updateIcon(); // Initial

            toggle.addEventListener("click", () => {
                html.classList.toggle("dark");
                const isDark = html.classList.contains("dark");
                localStorage.setItem("theme", isDark ? "dark" : "light");
                updateIcon();
            });
        });
    </script>
</body>

</html>