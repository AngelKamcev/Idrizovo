<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>КПУ Идризово — Најава</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { DEFAULT: '#1B3A6B', dark: '#122a52', light: '#2a4f8f' },
                        gold: '#c8a951',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: "Segoe UI", Tahoma, Geneva, sans-serif; }

        .bg-scene {
            background: linear-gradient(160deg, #1B3A6B 0%, #2a4f8f 45%, #d6e4f7 100%);
            position: relative;
            overflow: hidden;
        }
        .bg-scene::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 50% at 70% 110%, rgba(200,169,81,0.08) 0%, transparent 70%),
                radial-gradient(ellipse 60% 40% at 20% 80%, rgba(255,255,255,0.04) 0%, transparent 60%);
        }

        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .login-card {
            animation: cardIn 0.55s cubic-bezier(0.22,1,0.36,1) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .form-input:focus {
            outline: none;
            border-color: #1B3A6B;
            box-shadow: 0 0 0 3px rgba(27,58,107,0.15);
        }

        .btn-primary {
            background: #1B3A6B;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            background: #122a52;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(27,58,107,0.35);
        }
        .btn-primary:active { transform: translateY(0); }

        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 16px;
            border: 1px solid #fcc;
        }

    </style>
</head>
<body class="min-h-screen bg-scene flex items-center justify-center px-4 py-16">

    <div class="grid-overlay"></div>

    <!-- Decorative blobs -->
    <div class="absolute top-16 left-10 w-32 h-32 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
    <div class="absolute bottom-20 right-16 w-48 h-48 rounded-full bg-yellow-400/10 blur-3xl pointer-events-none"></div>

    <div class="relative login-card w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="p-8">

                <!-- Header -->
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-[#1B3A6B]/10 mb-4">
                        <svg class="w-7 h-7 text-[#1B3A6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-[#1B3A6B] tracking-tight">Најава</h1>
                    <p class="text-sm text-gray-500 mt-1">Внесете ги вашите податоци за пристап</p>
                </div>

                <!-- Error Messages -->
                <?php if($errors->any()): ?>
                    <div class="error-message">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div><?php echo e($error); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form method="POST" action="/login" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-[#1B3A6B]/80 uppercase tracking-widest mb-1.5">
                            Е-пошта
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                required
                                autofocus
                                autocomplete="email"
                                value="<?php echo e(old('email')); ?>"
                                placeholder="вашата@е-пошта.мк"
                                class="form-input w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-300 transition-all bg-gray-50 focus:bg-white <?php echo e($errors->has('email') ? 'border-red-500' : ''); ?>"
                            >
                        </div>
                        <?php if($errors->has('email')): ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($errors->first('email')); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-[#1B3A6B]/80 uppercase tracking-widest mb-1.5">
                            Лозинка
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="form-input w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-300 transition-all bg-gray-50 focus:bg-white <?php echo e($errors->has('password') ? 'border-red-500' : ''); ?>"
                            >
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#1B3A6B] transition-colors">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <?php if($errors->has('password')): ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($errors->first('password')); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer select-none group">
                            <input type="checkbox" name="remember" id="remember_me"
                                class="w-4 h-4 rounded border-gray-300 accent-[#1B3A6B] cursor-pointer">
                            <span class="text-gray-600 group-hover:text-[#1B3A6B] transition-colors text-xs">Запомни ме</span>
                        </label>
                        <a href="/forgot-password" class="text-xs text-[#1B3A6B]/70 hover:text-[#1B3A6B] hover:underline transition-colors">
                            Заборавена лозинка?
                        </a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-primary w-full py-3 rounded-lg text-white font-semibold text-sm tracking-wide shadow-md mt-2">
                        Влез во системот
                    </button>

                </form>

                <!-- Footer note -->
                <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">
                        Пристапот е ограничен само за овластени корисници.<br>
                        За помош контактирајте го администраторот.
                    </p>
                </div>

            </div>
        </div>

        <p class="text-center text-white/40 text-xs mt-5">
            © 2026 КПУ Идризово — Сите права задржани
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Angel\Desktop\backend_modified\resources\views/auth/login.blade.php ENDPATH**/ ?>