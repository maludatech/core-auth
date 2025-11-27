<?php
session_start();

// Protect route
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — CoreAuth</title>

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

<body class="min-h-screen bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <!-- Theme Toggle (same across all pages) -->
    <button id="themeToggle" aria-label="Toggle dark mode"
        class="fixed top-6 right-6 z-50 p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-900/5 dark:ring-gray-700 hover:scale-110 transition-all duration-300">
        <i data-lucide="moon" class="w-5 h-5"></i>
    </button>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-6 py-20">

        <!-- Welcome Header -->
        <div class="text-center mb-16">
            <h1 class="text-5xl md:text-6xl font-bold tracking-tight mb-4">
                Welcome back,<br>
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    <?= htmlspecialchars($_SESSION['username']) ?>
                </span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                Here’s your secure space in CoreAuth
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-xl">
                <i data-lucide="shield" class="w-10 h-10 mb-3 opacity-90"></i>
                <p class="text-blue-100 text-sm">Account Status</p>
                <p class="text-2xl font-bold">Verified</p>
            </div>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-xl">
                <i data-lucide="calendar" class="w-10 h-10 mb-3 opacity-90"></i>
                <p class="text-green-100 text-sm">Member Since</p>
                <p class="text-2xl font-bold">Nov 2025</p>
            </div>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-xl">
                <i data-lucide="lock" class="w-10 h-10 mb-3 opacity-90"></i>
                <p class="text-purple-100 text-sm">Password Age</p>
                <p class="text-2xl font-bold">12 days</p>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Profile Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-gray-900/70 backdrop-blur-xl border border-gray-200 dark:border-gray-800 p-8 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-cyan-600/10 opacity-0 group-hover:opacity-100 transition"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mb-5">
                        <i data-lucide="user" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Your Profile</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Update your username, email, and add a profile picture.
                    </p>
                    <a href="profile.php" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:gap-4 transition-all">
                        Manage Profile
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- Security Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-gray-900/70 backdrop-blur-xl border border-gray-200 dark:border-gray-800 p-8 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600/10 to-pink-600/10 opacity-0 group-hover:opacity-100 transition"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center mb-5">
                        <i data-lucide="lock" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Security</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Change your password and enable two-factor authentication.
                    </p>
                    <a href="reset.php" class="inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 font-semibold hover:gap-4 transition-all">
                        Update Security
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- Activity Card (full width on mobile) -->
            <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-gray-900/70 backdrop-blur-xl border border-gray-200 dark:border-gray-800 p-8 shadow-lg hover:shadow-2xl transition-all duration-300 lg:col-span-1">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/10 to-teal-600/10 opacity-0 group-hover:opacity-100 transition"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center mb-5">
                        <i data-lucide="activity" class="w-8 h-8 text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Recent Activity</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        View your login history, password changes, and account events.
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold hover:gap-4 transition-all">
                        View History
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Logout -->
        <div class="mt-16 text-center">
            <a href="../handlers/logout.inc.php"
                class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-red-600/10 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-medium hover:bg-red-600/20 dark:hover:bg-red-900/40 transition-all">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                Logout from your account
            </a>
        </div>
    </div>

    <!-- Working Theme Toggle Script -->
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

            // Apply saved theme or system preference
            const saved = localStorage.getItem("theme");
            if (saved === "dark" || (!saved && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                html.classList.add("dark");
            }

            updateIcon();

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