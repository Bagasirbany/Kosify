<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Pengaturan Profil</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi akun dan pengaturan keamanan Anda.</p>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-xl border-l-4 border-l-red-500">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
