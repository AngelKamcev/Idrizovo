

<?php $__env->startSection('title', 'Поставки'); ?>
<?php $__env->startSection('page-title', 'Поставки'); ?>
<?php $__env->startSection('page-subtitle', 'Управување со вашиот профил и кориснички пристап'); ?>

<?php $__env->startSection('content'); ?>


<?php if(session('success')): ?>
    <div class="mb-6 flex items-center p-4 mb-4 text-emerald-800 border-t-4 border-emerald-300 bg-emerald-50 rounded-lg shadow-sm animate-fade-in" role="alert">
        <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <div class="ml-3 text-sm font-medium"><?php echo e(session('success')); ?></div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
    
    
    <div class="xl:col-span-5">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Промена на лозинка</h3>
                        <p class="text-xs text-gray-500">Најавени сте како: <span class="font-semibold text-blue-600"><?php echo e($currentUser->name); ?></span></p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form method="POST" action="<?php echo e(route('admin.settings.password')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Тековна лозинка</label>
                        <input type="password" name="current_password" class="block w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" placeholder="••••••••" required>
                    </div>
                    
                    <div class="pt-2 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Нова лозинка</label>
                            <input type="password" name="password" class="block w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" placeholder="Минимум 8 карактери" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Потврди нова лозинка</label>
                            <input type="password" name="password_confirmation" class="block w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Ажурирај лозинка
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="xl:col-span-7">
        <?php if($isAdmin): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Додади нов соработник</h3>
                            <p class="text-xs text-gray-500">Креирајте нов профил за Reviewer или Vospituvac</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form method="POST" action="<?php echo e(route('admin.settings.users')); ?>" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Име</label>
                                <input type="text" name="first_name" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Презиме</label>
                                <input type="text" name="last_name" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email адреса</label>
                                <input type="email" name="email" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" placeholder="example@mail.com" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Телефон</label>
                                <input type="text" name="phone" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Улога на корисник</label>
                            <select name="role_name" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" required>
                                <option value="reviewer">Reviewer (Прегледувач)</option>
                                <option value="vospituvac">Vospituvac (Воспитувач)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Лозинка</label>
                                <input type="password" name="password" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Потврда</label>
                                <input type="password" name="password_confirmation" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-700">Активен профил</span>
                            </label>
                            
                            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all">
                                Креирај корисник
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-8 flex flex-col items-center text-center justify-center h-full">
                <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-amber-900">Ограничен пристап</h3>
                <p class="text-amber-700 mt-2 max-w-xs">Вашата корисничка улога дозволува само промена на сопствената лозинка.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


<?php if($isAdmin): ?>
    <div class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Листа на корисници</h3>
                <p class="text-sm text-gray-500">Управувајте со постоечките профили во системот</p>
            </div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" id="userSearch" class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 outline-none w-full md:w-64" placeholder="Пребарај корисник...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Корисник</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Улога</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Статус</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-gray-200 to-gray-100 flex items-center justify-center text-xs font-bold text-gray-600 border border-white shadow-sm group-hover:scale-110 transition-transform">
                                        <?php echo e(substr($user->name, 0, 1)); ?>

                                    </div>
                                    <span class="font-semibold text-gray-700"><?php echo e($user->name); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->email); ?></td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold <?php echo e($user->role?->name == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'); ?>">
                                    <?php echo e(strtoupper($user->role?->name)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if($user->is_active): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Активен
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Неактивен
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/admin/settings.blade.php ENDPATH**/ ?>