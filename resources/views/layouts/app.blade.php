<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EnglishYa')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-slate-200">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <a href="{{ url('/') }}" class="text-xl font-semibold text-slate-900">EnglishYa</a>
                    <nav class="flex flex-wrap items-center gap-3 text-sm text-slate-700">
                        <a href="{{ route('transaction-headers.index') }}" class="rounded-md px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">My Transactions</a>
                        <a href="{{ route('transaction-details.index') }}" class="rounded-md px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">Transaction Details</a>
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('admin.transactions') }}" class="rounded-md px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">All Transactions</a>
                            <a href="{{ route('users.index') }}" class="rounded-md px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">User Management</a>
                        @endif
                        @if(Auth::check())
                            <a href="{{ route('users.profile.edit') }}" class="rounded-md px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">My Profile Picture</a>
                        @endif
                    </nav>
                </div>
            </div>
        </header>

        <main class="flex-1">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

        <footer class="bg-slate-100 border-t border-slate-200">
            <div class="mx-auto max-w-7xl px-4 py-6 text-center text-sm text-slate-500 sm:px-6 lg:px-8">
                &copy; 2026 EnglishYa
            </div>
        </footer>
    </div>

    <div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4">
        <div class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Confirm Delete</h2>
            </div>
            <div class="px-6 py-5 text-sm text-slate-700">
                Are you sure you want to delete <span id="deleteItemName" class="font-semibold text-slate-900"></span>?
            </div>
            <div class="flex flex-col gap-3 border-t border-slate-200 px-6 py-4 sm:flex-row sm:justify-end">
                <button id="closeDeleteModal" type="button" class="inline-flex justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
                <form id="deleteForm" method="POST" action="" class="inline-flex w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        }

        function openDeleteModal(url, name) {
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteForm').setAttribute('action', url);
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            $('select.select2').select2({ width: '100%' });
            document.getElementById('closeDeleteModal').addEventListener('click', closeDeleteModal);
            document.getElementById('deleteConfirmModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeDeleteModal();
                }
            });
            document.querySelectorAll('.open-delete-modal').forEach(function(button) {
                button.addEventListener('click', function() {
                    openDeleteModal(this.dataset.url, this.dataset.name || 'this item');
                });
            });
        });
    </script>
</body>
</html>