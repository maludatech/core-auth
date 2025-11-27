<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoreAuth — Secure PHP Authentication System</title>
    <meta name="description" content="Lightweight, secure, modern OOP authentication system for PHP 8.1+. Login, signup, email verification, password reset, roles & more." />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <!-- Google Fonts: Inter (clean & modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 flex flex-col transition-colors duration-300">

    <!-- Theme Toggle (Fixed & Animated) -->
    <button id="themeToggle" aria-label="Toggle dark mode"
        class="fixed top-6 right-6 z-50 p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-900/5 dark:ring-gray-700 hover:scale-110 transition-all duration-300">
        <i data-lucide="moon" class="w-5 h-5"></i>
    </button>

    <!-- Hero Section -->
    <main class="flex-1 flex items-center justify-center px-6 py-20">
        <div class="max-w-4xl mx-auto text-center">

            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-medium mb-8">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                </span>
                Now supporting PHP 8.3 • Actively maintained
            </div>

            <!-- Main Heading -->
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight mb-6">
                Authentication<br>
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Done Right
                </span>
            </h1>

            <!-- Subheading -->
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-12 leading-relaxed">
                A <strong>lightweight</strong>, <strong>secure</strong>, and <strong>beautifully crafted</strong> OOP authentication system for modern PHP projects.
                Zero bloat. Full control. Built for developers who care.
            </p>

            <!-- Feature Highlights -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto mb-12">
                <div class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800">
                    <i data-lucide="shield-check" class="w-10 h-10 text-green-600 dark:text-green-400 mx-auto mb-3"></i>
                    <h3 class="font-semibold text-lg mb-2">Secure by Default</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Prepared statements, password hashing, rate limiting</p>
                </div>
                <div class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800">
                    <i data-lucide="zap" class="w-10 h-10 text-yellow-600 dark:text-yellow-400 mx-auto mb-3"></i>
                    <h3 class="font-semibold text-lg mb-2">Blazing Fast</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">No framework required • < 100KB • Instant setup</p>
                </div>
                <div class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800">
                    <i data-lucide="settings" class="w-10 h-10 text-purple-600 dark:text-purple-400 mx-auto mb-3"></i>
                    <h3 class="font-semibold text-lg mb-2">Fully Customizable</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Roles, middleware, events, email templates — you own it</p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="signup.php"
                    class="group inline-flex items-center gap-3 px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    Get Started Free
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition"></i>
                </a>
                <a href="https://github.com/maludatech/core-auth" target="_blank"
                    class="inline-flex items-center gap-3 px-8 py-4 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 font-medium hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <i data-lucide="github" class="w-5 h-5"></i>
                    View on GitHub
                </a>
            </div>

            <!-- Trust line -->
            <p class="mt-12 text-sm text-gray-500 dark:text-gray-400">
                Used by <strong>200+</strong> developers • Open source • MIT License
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-gray-800 py-8 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                © <?= date('Y'); ?> <strong>CoreAuth</strong> — Crafted with ❤️ by
                <a href="https://twitter.com/maludatechdev" class="underline hover:text-blue-600 dark:hover:text-blue-400">Maluda</a>
            </p>
        </div>
    </footer>

    <!-- Working Theme Toggle + Lucide Fix -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const html = document.documentElement;
            const toggle = document.getElementById("themeToggle");
            const icon = toggle.querySelector('i');

            // Apply saved theme
            const saved = localStorage.getItem("theme");
            if (saved === "dark" || (!saved && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                html.classList.add("dark");
            }

            // Update icon correctly
            const updateIcon = () => {
                const isDark = html.classList.contains("dark");
                icon.setAttribute("data-lucide", isDark ? "sun" : "moon");
                lucide.createIcons();
            };

            updateIcon(); // Initial render

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