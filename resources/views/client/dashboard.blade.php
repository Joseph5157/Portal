<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Portal - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #08080a;
            color: #a0a0ab;
        }

        .premium-card {
            background: linear-gradient(145deg, rgba(20, 20, 25, 0.9) 0%, rgba(10, 10, 12, 0.9) 100%);
            border: 1px solid rgba(255, 255, 255, 0.03);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(12px);
        }

        .upload-area:hover {
            border-color: rgba(99, 102, 241, 0.4);
            background: rgba(99, 102, 241, 0.02);
        }

        .status-glow-pending {
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }

        .status-glow-delivered {
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.3);
        }

        .status-glow-overdue {
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);
        }

        .sidebar-link-active {
            background: rgba(99, 102, 241, 0.1);
            color: #fff;
            border-right: 2px solid #6366f1;
        }
    </style>
</head>

<body class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-white/5 flex flex-col pt-8 bg-[#0a0a0c]">
        <div class="px-8 mb-12">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <i data-lucide="sparkles" class="w-5 h-5 text-white"></i>
                </div>
                <span class="font-bold text-white text-lg tracking-tight">TurniScan</span>
            </div>
        </div>

        <nav class="flex-1 space-y-2">
            <div class="flex items-center gap-4 px-8 py-4 text-sm font-medium sidebar-link-active transition-all">
                <i data-lucide="layout-grid" class="w-5 h-5"></i> Dashboard
            </div>
            <div
                class="flex items-center justify-between px-8 py-4 text-sm font-medium text-slate-600 cursor-not-allowed select-none">
                <div class="flex items-center gap-4">
                    <i data-lucide="history" class="w-5 h-5"></i> Order History
                </div>
                <span
                    class="text-[8px] font-black uppercase tracking-widest text-indigo-500/50 bg-indigo-500/5 border border-indigo-500/10 px-1.5 py-0.5 rounded">Soon</span>
            </div>
            <div
                class="flex items-center justify-between px-8 py-4 text-sm font-medium text-slate-600 cursor-not-allowed select-none">
                <div class="flex items-center gap-4">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Subscription
                </div>
                <span
                    class="text-[8px] font-black uppercase tracking-widest text-indigo-500/50 bg-indigo-500/5 border border-indigo-500/10 px-1.5 py-0.5 rounded">Soon</span>
            </div>
            <div
                class="flex items-center justify-between px-8 py-4 text-sm font-medium text-slate-600 cursor-not-allowed select-none">
                <div class="flex items-center gap-4">
                    <i data-lucide="settings" class="w-5 h-5"></i> Settings
                </div>
                <span
                    class="text-[8px] font-black uppercase tracking-widest text-indigo-500/50 bg-indigo-500/5 border border-indigo-500/10 px-1.5 py-0.5 rounded">Soon</span>
            </div>
        </nav>

        <div class="p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3 border border-white/5 rounded-xl text-xs font-bold text-slate-400 hover:text-white hover:bg-red-500/10 hover:border-red-500/20 transition-all">
                    <i data-lucide="log-out" class="w-4 h-4"></i> SIGN OUT
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-[#08080a]">
        <!-- Top Bar -->
        <header
            class="h-20 border-b border-white/5 flex items-center justify-between px-10 bg-[#08080a]/50 backdrop-blur-md sticky top-0 z-10">
            <div>
                <h1 class="text-white font-semibold flex items-center gap-2">
                    Good Morning, {{ auth()->user()->name }}
                    <span class="text-xl">👋</span>
                </h1>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3 pr-6 border-r border-white/5">
                    <div class="text-right">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Client ID</p>
                        <p class="text-xs font-mono text-indigo-400">{{ strtoupper($client->name) }}</p>
                    </div>
                    <div
                        class="w-10 h-10 bg-indigo-500/10 rounded-full flex items-center justify-center text-indigo-500 ring-4 ring-indigo-500/5">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                </div>
                <div class="relative group cursor-pointer">
                    <i data-lucide="bell" class="w-5 h-5 hover:text-white transition-colors"></i>
                    <span
                        class="absolute -top-1 -right-1 w-2 h-2 bg-indigo-500 rounded-full ring-2 ring-[#08080a]"></span>
                </div>
            </div>
        </header>

        <div class="p-10 max-w-7xl mx-auto space-y-10">
            @if(session('success'))
                <div
                    class="flex items-center gap-3 p-4 bg-green-500/10 border border-green-500/20 rounded-2xl text-green-500 text-sm font-semibold animate-in fade-in slide-in-from-top-4">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Dashboard Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="premium-card p-6 rounded-3xl relative overflow-hidden group">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Usage Credits</p>
                        <div
                            class="w-8 h-8 bg-indigo-500/10 rounded-lg flex items-center justify-center text-indigo-500">
                            <i data-lucide="coins" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-4xl font-bold text-white mb-1">{{ $client->slots }}</h3>
                        <p class="text-xs text-slate-500">Available Slots</p>
                    </div>
                    <div class="mt-6 flex gap-2">
                        <button
                            class="px-3 py-1.5 bg-indigo-500 text-white text-[10px] font-bold rounded-lg hover:bg-indigo-400 transition-colors">TOP
                            UP</button>
                    </div>
                </div>

                <div class="premium-card p-6 rounded-3xl relative overflow-hidden group">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Active Orders</p>
                        <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="text-4xl font-bold text-white mb-1">
                        {{ $orders->where('status', '!=', 'delivered')->count() }}
                    </h3>
                    <p class="text-xs text-slate-500">In Processing Flow</p>
                </div>

                <div class="premium-card p-6 rounded-3xl relative overflow-hidden group">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Plan Status</p>
                        <div
                            class="w-8 h-8 @if($client->plan_expiry && $client->plan_expiry->isPast()) bg-red-500/10 text-red-500 @else bg-green-500/10 text-green-500 @endif rounded-lg flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">
                        @if($client->plan_expiry && $client->plan_expiry->isPast()) Expired @else Professional @endif
                    </h3>
                    <p class="text-xs text-slate-500">
                        @if($client->plan_expiry) {{ $client->plan_expiry->format('d M, Y') }} @else Perpetual @endif
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Upload Section -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="premium-card p-8 rounded-[2.5rem]">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h2 class="text-xl font-bold text-white mb-1">Secure Upload</h2>
                                <p class="text-xs text-slate-500">Submit your document for non-repository scanning</p>
                            </div>
                            <div
                                class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center border border-white/5">
                                <i data-lucide="shield" class="w-6 h-6 text-indigo-400"></i>
                            </div>
                        </div>

                        <form action="{{ route('client.dashboard.upload') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <label for="files"
                                class="upload-area group block border-2 border-dashed border-white/5 rounded-[2rem] p-12 text-center transition-all cursor-pointer">
                                <input type="file" name="files[]" id="files" multiple required class="hidden"
                                    onchange="this.form.submit()">
                                <div
                                    class="w-20 h-20 bg-indigo-500/5 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-all border border-indigo-500/10 shadow-inner">
                                    <i data-lucide="file-plus" class="w-10 h-10 text-indigo-500"></i>
                                </div>
                                <h3 class="text-white font-bold mb-2">Drop files here or click</h3>
                                <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest">PDF, DOCX up
                                    to 50MB</p>
                            </label>
                        </form>

                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5 flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </div>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">AI
                                    Detection<br>Enabled</span>
                            </div>
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5 flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </div>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">No
                                    Repo<br>Mode</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent History -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="flex items-center justify-between px-2">
                        <h2 class="text-sm font-bold text-white uppercase tracking-widest">Recent Activity</h2>
                        <span
                            class="text-[8px] font-black uppercase tracking-widest text-indigo-500/40 bg-indigo-500/5 border border-indigo-500/10 px-2 py-0.5 rounded cursor-not-allowed">Coming
                            Soon</span>
                    </div>

                    <div class="space-y-4">
                        @forelse($orders as $order)
                            <div class="premium-card p-5 rounded-3xl hover:border-white/10 transition-all group">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-indigo-500 group-hover:text-white transition-all border border-white/5">
                                            <i data-lucide="file-text" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-200 line-clamp-1">
                                                {{ $order->files->first() ? basename($order->files->first()->file_path) : 'Document' }}
                                            </h4>
                                            <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest mt-1">
                                                {{ $order->created_at->format('d M, h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-[0.15em]
                                                            @if($order->status == 'delivered') bg-green-500/10 text-green-500 border border-green-500/10 status-glow-delivered
                                                            @elseif($order->is_overdue) bg-red-500/10 text-red-500 border border-red-500/10 status-glow-overdue
                                                            @else bg-blue-500/10 text-blue-400 border border-blue-500/10 status-glow-pending @endif">
                                            @if($order->status == 'delivered')
                                                Ready
                                            @elseif($order->status == 'processing')
                                                Processing
                                            @elseif($order->is_overdue)
                                                Overdue
                                            @else
                                                Pending
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                @if($order->status == 'delivered')
                                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                        <div class="flex gap-4">
                                            @if($order->report?->ai_percentage !== null)
                                                <div class="text-center">
                                                    <p class="text-[8px] font-bold text-slate-700 uppercase">AI Score</p>
                                                    <p class="text-xs font-bold text-red-400">
                                                        {{ (int) $order->report?->ai_percentage }}%</p>
                                                </div>
                                            @endif
                                            @if($order->report?->plag_percentage !== null)
                                                <div class="text-center">
                                                    <p class="text-[8px] font-bold text-slate-700 uppercase">Plagiarism</p>
                                                    <p class="text-xs font-bold text-blue-400">
                                                        {{ (int) $order->report?->plag_percentage }}%
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        @if($order->report)
                                            <a href="{{ route('client.download', $order->token_view) }}"
                                                class="p-2.5 bg-indigo-500 text-white rounded-xl hover:bg-indigo-400 active:scale-95 transition-all shadow-lg shadow-indigo-500/20">
                                                <i data-lucide="download" class="w-4 h-4"></i>
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <div class="mt-4 flex items-center justify-between">
                                        <div
                                            class="flex items-center gap-2 text-[10px] text-slate-600 font-bold uppercase tracking-widest">
                                            @if($order->status == 'processing')
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                                                Processing...
                                            @else
                                                <span class="w-1.5 h-1.5 bg-slate-500 rounded-full animate-pulse"></span>
                                                In Queue...
                                            @endif
                                        </div>
                                        <div
                                            class="flex items-center gap-1.5 px-3 py-1 bg-white/5 rounded-lg border border-white/5">
                                            <i data-lucide="clock" class="w-3 h-3 text-indigo-400"></i>
                                            <span class="countdown-timer text-[10px] font-mono text-indigo-400"
                                                data-due="{{ $order->due_at->toIso8601String() }}">--:--</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="py-20 text-center">
                                <div
                                    class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                                    <i data-lucide="inbox" class="w-8 h-8 text-slate-700"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-600 uppercase tracking-[0.2em]">No Recent Orders</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <footer class="p-10 text-center border-t border-white/5 bg-[#0a0a0c]">
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.3em]">TurniScan • Advanced Plagiarism
                Prevention</p>
        </footer>
    </main>

    <script>
        lucide.createIcons();

        function updateTimers() {
            const timers = document.querySelectorAll('.countdown-timer');
            timers.forEach(timer => {
                const dueAt = new Date(timer.dataset.due).getTime();
                const now = new Date().getTime();
                const diff = dueAt - now;

                if (diff <= 0) {
                    timer.parentElement.innerHTML = `<i data-lucide="loader-2" class="w-3 h-3 text-amber-500 animate-spin"></i><span class="text-[10px] text-amber-500 font-bold">ETA exceeded — report is being finalized.</span>`;
                    // Update parent container classes for overdue look
                    const card = timer.closest('.premium-card');
                    if (card) {
                        const statusBadge = card.querySelector('span[class*="status-glow"]');
                        if (statusBadge && !statusBadge.classList.contains('status-glow-delivered')) {
                            statusBadge.className = 'inline-block px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-[0.15em] bg-red-500/10 text-red-500 border border-red-500/10 status-glow-overdue';
                            statusBadge.textContent = 'Overdue';
                        }
                    }
                    lucide.createIcons();
                    return;
                }

                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                timer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            });
        }

        setInterval(updateTimers, 1000);
        updateTimers();
    </script>
</body>

</html>