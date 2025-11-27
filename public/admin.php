<?php
session_start();

// Protect admin route
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — CoreAuth</title>

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

    <!-- Theme Toggle (same as all pages) -->
    <button id="themeToggle" aria-label="Toggle dark mode"
        class="fixed top-6 right-6 z-50 p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-900/5 dark:ring-gray-700 hover:scale-110 transition-all duration-300">
        <i data-lucide="moon" class="w-5 h-5"></i>
    </button>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-20">

        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-3">
                Admin Dashboard
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Welcome back, <span class="font-semibold text-blue-600 dark:text-blue-400"><?= htmlspecialchars($_SESSION['username']); ?></span>
            </p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Total Users</p>
                        <p class="text-3xl font-bold mt-1">1,284</p>
                    </div>
                    <i data-lucide="users" class="w-10 h-10 opacity-80"></i>
                </div>
            </div>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Active Today</p>
                        <p class="text-3xl font-bold mt-1">89</p>
                    </div>
                    <i data-lucide="activity" class="w-10 h-10 opacity-80"></i>
                </div>
            </div>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">Pending Verifs</p>
                        <p class="text-3xl font-bold mt-1">12</p>
                    </div>
                    <i data-lucide="shield-alert" class="w-10 h-10 opacity-80"></i>
                </div>
            </div>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-orange-500 to-red-600 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">Failed Logins</p>
                        <p class="text-3xl font-bold mt-1">3</p>
                    </div>
                    <i data-lucide="alert-triangle" class="w-10 h-10 opacity-80"></i>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- User Management -->
            <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-gray-900/70 backdrop-blur-xl border border-gray-200 dark:border-gray-800 p-8 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mb-5">
                        <i data-lucide="users" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">User Management</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        View, edit, delete users. Manage roles, ban accounts, and reset passwords.
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:gap-4 transition-all">
                        Manage Users
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- System Settings -->
            <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-gray-900/70 backdrop-blur-xl border border-gray-200 dark:border-gray-800 p-8 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600/10 to-pink-600/10 opacity-0 group-hover:opacity-100 transition"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center mb-5">
                        <i data-lucide="settings" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">System Settings</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Configure auth rules, email templates, rate limits, and security policies.
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 font-semibold hover:gap-4 transition-all">
                        Open Settings
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- System Logs -->
            <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-gray-900/70 backdrop-blur-xl border border-gray-200 dark:border-gray-800 p-8 shadow-lg hover:shadow-2xl transition-all duration-300 lg:col-span-1">
                <div class="absolute inset-0 bg-gradient-to-br from-red-600/10 to-orange-600/10 opacity-0 group-hover:opacity-100 transition"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-red-100 dark:bg-red-900/50 flex items-center justify-center mb-5">
                        <i data-lucide="database" class="w-8 h-8 text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">System Logs</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Monitor login attempts, admin actions, email events and security alerts.
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 text-red-600 dark:text-red-400 font-semibold hover:gap-4 transition-all">
                        View Logs
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
                Logout from Admin Panel
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

            // Apply saved or system preference
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