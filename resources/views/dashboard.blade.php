<x-app-layout>
    <div class="min-h-screen bg-[#0d0d0d] text-slate-300 font-['Plus_Jakarta_Sans'] pb-20">
        <!-- Header -->
        <nav class="flex justify-between items-center px-8 py-4 border-b border-white/5">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center font-bold text-white">R
                </div>
                <div>
                    <h1 class="text-sm font-bold text-white leading-tight">Agent Portal</h1>
                    <p class="text-[10px] text-slate-500 uppercase tracking-tighter">ID: PLAG EXPERT</p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <button class="relative p-2 text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span
                        class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full border border-[#0d0d0d]"></span>
                </button>
                <div class="bg-[#1a2e24] border border-[#00c853]/10 px-4 py-1.5 rounded-full flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#00c853] rounded-full animate-pulse shadow-[0_0_10px_#00c853]"></span>
                    <span class="text-[10px] text-[#00c853] font-bold uppercase tracking-widest">Live Sync</span>
                </div>
                <button
                    class="text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-white transition-colors">Feedback</button>
                <div
                    class="w-8 h-8 bg-indigo-600/20 rounded-full flex items-center justify-center text-indigo-400 text-xs font-bold border border-indigo-600/10">
                    P</div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-8 py-10 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Available Pool -->
                <div
                    class="bg-[#121212] border border-white/5 p-8 rounded-[2rem] flex justify-between items-center group hover:border-white/10 transition-all">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Available Pool</p>
                        <h2 class="text-5xl font-bold text-white tracking-tighter">{{ $stats['available_pool'] }}</h2>
                    </div>
                    <div
                        class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 group-hover:text-white transition-colors">
                        <i data-lucide="hash" class="w-6 h-6"></i>
                    </div>
                </div>

                <!-- Active Jobs -->
                <div
                    class="bg-[#121212] border border-white/5 p-8 rounded-[2rem] flex justify-between items-center group hover:border-white/10 transition-all">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Active Jobs</p>
                        <h2 class="text-5xl font-bold text-white tracking-tighter">{{ $stats['active_jobs'] }}</h2>
                    </div>
                    <div
                        class="w-12 h-12 bg-indigo-600/10 rounded-2xl flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-all">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                </div>

                <!-- Total Checked -->
                <div
                    class="bg-[#121212] border border-white/5 p-8 rounded-[2rem] flex justify-between items-center group hover:border-white/10 transition-all relative overflow-hidden">
                    <div class="space-y-1">
                        <div class="flex items-center gap-3">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Total Checked</p>
                            <select
                                class="bg-indigo-600/10 text-indigo-400 text-[8px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-lg border border-indigo-600/20 focus:outline-none">
                                <option>Today</option>
                            </select>
                        </div>
                        <h2 class="text-5xl font-bold text-white tracking-tighter">{{ $stats['total_checked_today'] }}
                        </h2>
                    </div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-green-500/10 rounded-full flex items-center justify-center">
                            <i data-lucide="check" class="w-8 h-8 text-green-500"></i>
                        </div>
                        <i data-lucide="check" class="w-20 h-20 text-white/[0.02] absolute -right-6 -bottom-6"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <div class="md:col-span-8 space-y-8">
                    <!-- My Workspace -->
                    <div class="bg-[#121212] border border-white/5 rounded-[2.5rem] p-10 space-y-8">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span
                                    class="w-2 h-2 bg-indigo-500 rounded-full shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                                <h2 class="text-sm font-bold text-white uppercase tracking-widest">My Workspace</h2>
                            </div>
                            <div
                                class="flex items-center gap-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-indigo-500"></i>
                                20 Mins Limit
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="text-[8px] text-slate-600 font-bold uppercase tracking-[0.2em] border-b border-white/5">
                                        <th class="pb-6">File Info</th>
                                        <th class="pb-6 text-center">Actions</th>
                                        <th class="pb-6 text-right">Process</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/[0.02]">
                                    @forelse($workspaceOrders as $order)
                                        <tr class="group">
                                            <td class="py-10">
                                                <div class="flex items-center gap-4">
                                                    <div
                                                        class="w-10 h-10 bg-indigo-600/5 rounded-xl flex items-center justify-center text-indigo-400 group-hover:bg-indigo-600/10 transition-colors">
                                                        <i data-lucide="file-text" class="w-5 h-5"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-sm font-bold text-slate-300">
                                                            {{ $order->files->first() ? basename($order->files->first()->file_path) : 'Document' }}
                                                        </h4>
                                                        <p class="text-[9px] text-slate-500 mt-1 font-mono uppercase">
                                                            {{ $order->client->name }}
                                                            <span
                                                                class="ml-2 px-2 py-0.5 rounded @if($order->source === 'account') bg-blue-500/10 text-blue-400 @else bg-purple-500/10 text-purple-400 @endif border border-white/5">
                                                                {{ strtoupper($order->source) }}
                                                            </span>
                                                            @if($order->creator)
                                                                <span class="ml-1 text-[8px] text-slate-600">by
                                                                    {{ $order->creator->name }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-10 text-center">
                                                <div class="flex items-center justify-center gap-3">
                                                    <a href="{{ route('orders.files.download', [$order, $order->files->first()]) }}"
                                                        class="px-6 py-2 bg-indigo-600/10 hover:bg-indigo-600/20 text-indigo-400 text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all flex items-center gap-2 border border-indigo-600/10">
                                                        <i data-lucide="download" class="w-3.5 h-3.5"></i> DOWNLOAD
                                                    </a>
                                                    <span
                                                        class="w-6 h-6 bg-red-600/20 text-red-500 rounded-full flex items-center justify-center text-[10px] font-bold border border-red-600/10">{{ $order->files_count }}</span>
                                                </div>
                                            </td>
                                            <td class="py-10 text-right">
                                                <div class="flex justify-end gap-2">
                                                    @if($order->status == 'pending')
                                                        <form action="{{ route('orders.status', $order) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="processing">
                                                            <button
                                                                class="px-8 py-2 bg-[#00c853] hover:bg-[#00e676] text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-[#00c853]/10">Start</button>
                                                        </form>
                                                    @else
                                                        <button
                                                            onclick="document.getElementById('upload-modal-{{ $order->id }}').classList.remove('hidden')"
                                                            class="px-8 py-2 bg-[#00c853] hover:bg-[#00e676] text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-[#00c853]/10">Process</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-20 text-center">
                                                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">No
                                                    active jobs. Claim from pool!</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Available Files -->
                    <div class="bg-[#121212] border border-white/5 rounded-[2.5rem] p-10 space-y-8">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i data-lucide="zap" class="w-4 h-4 text-slate-400"></i>
                                <h2 class="text-sm font-bold text-white uppercase tracking-widest">Available Files</h2>
                            </div>
                            <button
                                class="text-[8px] font-bold text-slate-500 uppercase tracking-widest hover:text-white">Grab
                                First</button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="text-[8px] text-slate-600 font-bold uppercase tracking-[0.2em] border-b border-white/5">
                                        <th class="pb-6">File Info</th>
                                        <th class="pb-6 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/[0.02]">
                                    @forelse($poolOrders as $order)
                                        <tr class="group">
                                            <td class="py-8">
                                                <h4 class="text-xs font-bold text-slate-400">
                                                    {{ $order->files->first() ? basename($order->files->first()->file_path) : 'New Document' }}
                                                </h4>
                                                <p class="text-[8px] text-slate-600 mt-1 uppercase font-mono">
                                                    {{ $order->created_at->diffForHumans() }} • {{ $order->client->name }}
                                                    <span
                                                        class="ml-2 px-1.5 py-0.5 rounded @if($order->source === 'account') bg-blue-500/10 text-blue-400 @else bg-purple-500/10 text-purple-400 @endif">
                                                        {{ strtoupper($order->source) }}
                                                    </span>
                                                </p>
                                            </td>
                                            <td class="py-8 text-right">
                                                <form action="{{ route('orders.claim', $order) }}" method="POST">
                                                    @csrf
                                                    <button
                                                        class="bg-indigo-600/10 hover:bg-indigo-600/20 text-indigo-400 px-6 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-indigo-600/10 transition-all flex items-center gap-2">
                                                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> CLAIM
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="py-20 text-center">
                                                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">No
                                                    new orders available.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent History -->
                    <div class="space-y-6">
                        <h2
                            class="text-xs font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-white/5 pb-4">
                            Recent History</h2>
                        <div class="space-y-4">
                            @foreach($recentHistory as $history)
                                <div class="flex justify-between items-center group py-2">
                                    <div class="space-y-1">
                                        <h4
                                            class="text-xs font-bold text-slate-400 group-hover:text-slate-200 transition-colors uppercase tracking-tight">
                                            {{ $history->files->first() ? basename($history->files->first()->file_path) : 'Document' }}
                                        </h4>
                                        <div
                                            class="flex gap-4 text-[9px] font-bold text-slate-600 uppercase tracking-widest">
                                            <span>P: View</span>
                                            <span class="text-slate-700">|</span>
                                            <span>A: View</span>
                                        </div>
                                    </div>
                                    <span
                                        class="text-[8px] font-bold text-red-500 bg-red-500/5 px-2 py-0.5 rounded border border-red-500/10 uppercase tracking-widest">Deleted</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Leaderboard Sidebar -->
                <div class="md:col-span-4 space-y-6">
                    <div class="bg-[#121212] border border-white/5 rounded-[2.5rem] p-10">
                        <div class="flex items-center justify-between mb-10">
                            <h2 class="text-xs font-bold text-white uppercase tracking-widest">Top Agents</h2>
                            <i data-lucide="shield-check" class="w-4 h-4 text-[#ffd700]"></i>
                        </div>

                        <div class="space-y-6">
                            @foreach($topAgents as $index => $agent)
                                <div class="flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl flex items-center justify-center relative
                                                    @if($index == 0) bg-[#ffd70033] @elseif($index == 1) bg-blue-500/10 @else bg-white/5 @endif">
                                            <span
                                                class="text-[10px] font-bold
                                                        @if($index == 0) text-[#ffd700] @elseif($index == 1) text-blue-400 @else text-slate-500 @endif">
                                                @if($index == 0) <i data-lucide="medal" class="w-5 h-5"></i>
                                                @elseif($index == 1) <i data-lucide="award" class="w-5 h-5"></i> @else <i
                                                data-lucide="user" class="w-5 h-5"></i> @endif
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-slate-300">
                                                {{ $agent->id == auth()->id() ? 'Plag Expert (You)' : substr($agent->name, 0, 1) . str_repeat('*', 8) }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div
                                        class="w-10 h-10 bg-white/[0.02] border border-white/5 rounded-xl flex items-center justify-center text-[10px] font-bold text-slate-400 group-hover:text-white transition-colors">
                                        {{ $agent->jobs_count }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Tooltips/Modals Container -->
        @foreach($workspaceOrders as $order)
            @if($order->status == 'processing')
                <div id="upload-modal-{{ $order->id }}"
                    class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                    <div class="bg-[#121212] border border-white/10 rounded-[2.5rem] p-10 max-w-lg w-full shadow-2xl space-y-8">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-white">Upload Result</h3>
                            <button onclick="document.getElementById('upload-modal-{{ $order->id }}').classList.add('hidden')"
                                class="text-slate-500 hover:text-white transition-colors">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <form action="{{ route('orders.report', $order) }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">AI Percentage
                                        (%)</label>
                                    <input type="number" name="ai_percentage" step="0.01" min="0" max="100"
                                        class="w-full bg-white/5 border border-white/5 rounded-xl py-3 px-4 text-white focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Plag
                                        Percentage (%)</label>
                                    <input type="number" name="plag_percentage" step="0.01" min="0" max="100"
                                        class="w-full bg-white/5 border border-white/5 rounded-xl py-3 px-4 text-white focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Report File
                                    (PDF)</label>
                                <input type="file" name="report" accept=".pdf" required
                                    class="w-full bg-white/5 border border-white/5 rounded-xl py-3 px-4 text-xs text-slate-400 file:hidden">
                            </div>

                            <div class="flex gap-4 pt-4">
                                <button type="submit"
                                    class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-600/20">Submit
                                    Results</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>