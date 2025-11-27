<?php
session_start();
require_once __DIR__ . '/../Classes/Auth.php';

if (!isset($_GET['token']) || !isset($_GET['userId'])) {
    header("Location: login.php");
    exit();
}

$token   = $_GET['token'];
$userId  = (int)$_GET['userId'];

$auth     = new Auth();
$verified = $auth->verifyEmail($token, $userId);
?>
<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification — CoreAuth</title>
    <meta name="description" content="Verify your email address to activate your CoreAuth account." />

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

    <!-- Theme Toggle (100% consistent) -->
    <button id="themeToggle" aria-label="Toggle dark mode"
        class="fixed top-6 right-6 z-50 p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-900/5 dark:ring-gray-700 hover:scale-110 transition-all duration-300">
        <i data-lucide="moon" class="w-5 h-5"></i>
    </button>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-6 py-20">
        <div class="w-full max-w-md">

            <!-- Success State -->
            <?php if ($verified): ?>
                <div class="text-center">
                    <div class="mx-auto w-24 h-24 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center mb-8">
                        <i data-lucide="check-circle" class="w-16 h-16 text-green-600 dark:text-green-400"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4">
                        Email Verified!
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-10">
                        Your account is now active and ready to use.
                    </p>
                    <a href="login.php"
                        class="group inline-flex items-center gap-3 px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        Continue to Login
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition"></i>
                    </a>
                </div>
            <?php else: ?>
                <!-- Failure State -->
                <div class="text-center">
                    <div class="mx-auto w-24 h-24 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center mb-8">
                        <i data-lucide="x-circle" class="w-16 h-16 text-red-600 dark:text-red-400"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4 text-red-600 dark:text-red-400">
                        Verification Failed
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-sm mx-auto">
                        The verification link is invalid or has expired.
                    </p>
                    <div class="space-y-4">
                        <a href="login.php"
                            class="inline-block px-8 py-4 rounded-xl bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-300 dark:hover:bg-gray-700 transition">
                            Return to Login
                        </a>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Need a new link?
                            <a href="resend-verification.php" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                Resend verification email
                            </a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Back to Home (always visible) -->
            <div class="text-center mt-12">
                <a href="../index.php" class="text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center justify-center gap-1">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to home
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-gray-800 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
        © <?= date('Y'); ?> CoreAuth — Secure & beautiful authentication
    </footer>

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