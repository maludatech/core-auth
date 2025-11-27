<?php
session_start();

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
    <title>Profile — CoreAuth</title>

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

    <!-- Theme Toggle (same on every page) -->
    <button id="themeToggle" aria-label="Toggle dark mode"
        class="fixed top-6 right-6 z-50 p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-900/5 dark:ring-gray-700 hover:scale-110 transition-all duration-300">
        <i data-lucide="moon" class="w-5 h-5"></i>
    </button>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-6 py-20">
        <div class="w-full max-w-2xl">

            <!-- Profile Card -->
            <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-gray-900/80 backdrop-blur-xl shadow-2xl border border-gray-200 dark:border-gray-800">

                <!-- Gradient Top Accent -->
                <div class="h-32 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-t-3xl"></div>

                <div class="relative px-10 pb-10 -mt-16">

                    <!-- Avatar -->
                    <div class="flex justify-center">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 p-1 shadow-2xl">
                                <div class="w-full h-full rounded-full bg-white dark:bg-gray-900 flex items-center justify-center">
                                    <i data-lucide="user" class="w-16 h-16 text-gray-600 dark:text-gray-400"></i>
                                </div>
                            </div>
                            <!-- Online Indicator (optional) -->
                            <div class="absolute bottom-2 right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white dark:border-gray-900"></div>
                        </div>
                    </div>

                    <!-- User Name -->
                    <div class="text-center mt-6">
                        <h1 class="text-3xl md:text-4xl font-bold">
                            <?= htmlspecialchars($_SESSION['user_name'] ?? 'Guest User') ?>
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            Member since <?= htmlspecialchars($_SESSION['joined_at'] ?? 'Recently') ?>
                        </p>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">

                        <!-- Email -->
                        <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                                    <i data-lucide="mail" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Email Address</p>
                                    <p class="font-semibold text-lg">
                                        <?= htmlspecialchars($_SESSION['user_email'] ?? 'Not set') ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Role / Status -->
                        <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-400 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center">
                                    <i data-lucide="shield" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Account Role</p>
                                    <p class="font-semibold text-lg capitalize">
                                        <?= htmlspecialchars($_SESSION['role'] ?? 'user') ?>
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                            <span class="inline-flex items-center ml-2 px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300">
                                                Admin Access
                                            </span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-12">
                        <a href="dashboard.php"
                            class="group inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition"></i>
                            Back to Dashboard
                        </a>

                        <a href="../handlers/logout.inc.php"
                            class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl bg-red-600/10 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-medium border border-red-600/20 dark:border-red-900/30 hover:bg-red-600/20 dark:hover:bg-red-900/40 transition-all">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            Logout
                        </a>
                    </div>

                    <!-- Optional: Future Edit Profile Button -->
                    <!--
                    <div class="text-center mt-6">
                        <a href="edit-profile.php" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                            Edit Profile Settings
                        </a>
                    </div>
                    -->

                </div>
            </div>
        </div>
    </main>

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