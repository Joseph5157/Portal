<x-app-layout>
    <div class="min-h-screen bg-[#08080a] text-slate-300 font-['Outfit'] pb-20">
        <!-- Admin Header -->
        <nav class="flex justify-between items-center px-10 py-6 border-b border-white/5 bg-[#0a0a0c]/50 backdrop-blur-xl sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/20">
                    <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-white tracking-tight uppercase">Control Center</h1>
                    <p class="text-[9px] text-red-500 font-black uppercase tracking-[0.3em]">Administrator Access</p>
                </div>
            </div>
            
            <div class="flex items-center gap-8">
                <div class="flex gap-4">
                    <a href="#" class="text-[10px] font-bold text-slate-500 hover:text-white transition-colors uppercase tracking-widest">Users</a>
                    <a href="#" class="text-[10px] font-bold text-slate-500 hover:text-white transition-colors uppercase tracking-widest">Clients</a>
                    <a href="#" class="text-[10px] font-bold text-slate-500 hover:text-white transition-colors uppercase tracking-widest">System</a>
                </div>
                <div class="h-8 w-px bg-white/5"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Terminal</p>
                        <p class="text-xs font-mono text-red-400">ACTIVE_NODE_01</p>
                    </div>
                    <div class="w-10 h-10 bg-red-500/10 rounded-full flex items-center justify-center text-red-500 border border-red-500/20">
                        <i data-lucide="command" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-10 py-12 space-y-12">
            <!-- Pulsing Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-b from-white/[0.03] to-transparent border border-white/5 p-8 rounded-[2.5rem] relative overflow-hidden group">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Pulse • Files Today</p>
                    <div class="flex items-end justify-between">
                        <h2 class="text-5xl font-bold text-white tracking-tighter">{{ $stats['total_processed_today'] }}</h2>
                        <div class="w-10 h-10 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500">
                            <i data-lucide="trending-up" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-b from-white/[0.03] to-transparent border border-white/5 p-8 rounded-[2.5rem] relative overflow-hidden group">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Pending • Pool Size</p>
                    <div class="flex items-end justify-between">
                        <h2 class="text-5xl font-bold text-white tracking-tighter">{{ $stats['pending_pool'] }}</h2>
                        <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-500">
                            <i data-lucide="database" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-b from-white/[0.03] to-transparent border border-white/5 p-8 rounded-[2.5rem] relative overflow-hidden group">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Active • Workforce</p>
                    <div class="flex items-end justify-between">
                        <h2 class="text-5xl font-bold text-white tracking-tighter">{{ $stats['active_vendors'] }}</h2>
                        <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-500">
                            <i data-lucide="users-2" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-b from-white/[0.03] to-transparent border border-white/5 p-8 rounded-[2.5rem] relative overflow-hidden group">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Growth • New Clients</p>
                    <div class="flex items-end justify-between">
                        <h2 class="text-5xl font-bold text-white tracking-tighter">{{ $stats['new_clients_today'] }}</h2>
                        <div class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-500">
                            <i data-lucide="sparkles" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Vendor Performance Table -->
                <div class="lg:col-span-8 space-y-8">
                    <div class="bg-[#0a0a0c] border border-white/5 rounded-[3rem] p-10">
                        <div class="flex justify-between items-center mb-10">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-red-500/10 rounded-2xl flex items-center justify-center text-red-500">
                                    <i data-lucide="zap" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white">Vendor Performance</h2>
                                    <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest mt-0.5">Top contributors today</p>
                                </div>
                            </div>
                            <button class="px-5 py-2 bg-white/5 hover:bg-white/10 text-slate-400 text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all border border-white/5">Export All</button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-[9px] text-slate-700 font-bold uppercase tracking-[0.25em] border-b border-white/5">
                                        <th class="pb-6 px-4">Vendor Identity</th>
                                        <th class="pb-6 text-center">Files Today</th>
                                        <th class="pb-6 text-center">Lifetime Jobs</th>
                                        <th class="pb-6 text-right">Effiency</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/[0.02]">
                                    @foreach($vendorPerformance as $vendor)
                                        <tr class="group hover:bg-white/[0.01] transition-all">
                                            <td class="py-6 px-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-slate-500 group-hover:bg-red-500/10 group-hover:text-red-500 transition-all border border-white/5">
                                                        <i data-lucide="user" class="w-5 h-5"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-sm font-bold text-slate-300">{{ $vendor->name }}</h4>
                                                        <p class="text-[9px] text-slate-600 font-mono">{{ $vendor->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-6 text-center">
                                                <span class="px-3 py-1 bg-green-500/10 text-green-500 rounded-lg text-xs font-bold border border-green-500/10">
                                                    {{ $vendor->today_jobs }}
                                                </span>
                                            </td>
                                            <td class="py-6 text-center text-sm font-bold text-slate-500">
                                                {{ $vendor->total_jobs }}
                                            </td>
                                            <td class="py-6 text-right">
                                                <div class="flex justify-end items-center gap-2">
                                                    <div class="w-24 h-1.5 bg-white/5 rounded-full overflow-hidden">
                                                        <div class="bg-red-500 h-full rounded-full" style="width: {{ min(100, $vendor->today_jobs * 10) }}%"></div>
                                                    </div>
                                                    <span class="text-[10px] font-bold text-slate-600 tracking-tighter">PHASE_01</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- System Logs Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="bg-[#0a0a0c] border border-white/5 rounded-[3rem] p-10 h-full">
                        <div class="flex items-center justify-between mb-10">
                            <h2 class="text-xs font-bold text-white uppercase tracking-[0.2em]">System Pulse</h2>
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-ping"></span>
                        </div>

                        <div class="space-y-8">
                            @foreach($recentOrders as $order)
                                <div class="relative pl-8 group">
                                    <div class="absolute left-0 top-1 w-1.5 h-1.5 bg-red-500 rounded-full z-10 
                                                @if($order->status == 'delivered') bg-green-500 @elseif($order->status == 'pending') bg-amber-500 @endif"></div>
                                    <div class="absolute left-[2px] top-4 w-px h-full bg-white/5 group-last:hidden"></div>
                                    
                                    <div class="space-y-1">
                                        <div class="flex justify-between items-start">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                                                @if($order->status == 'delivered') Result Uploaded @else Processing Stream @endif
                                            </p>
                                            <span class="text-[8px] font-mono text-slate-700 uppercase tracking-tighter">{{ $order->created_at->diffForHumans() }}</span>
                                        </div>
                                        <h4 class="text-xs font-bold text-slate-600 line-clamp-1">
                                            {{ $order->client->name }} • {{ $order->files_count }} Files
                                        </h4>
                                        @if($order->vendor)
                                            <p class="text-[9px] text-red-500/50 font-bold uppercase tracking-widest">Signed: {{ $order->vendor->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-12 pt-8 border-t border-white/5">
                            <button class="w-full py-4 bg-red-600/10 hover:bg-red-600/20 text-red-500 text-[10px] font-bold uppercase tracking-[0.3em] rounded-2xl border border-red-600/20 transition-all">
                                View Security Logs
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Search & Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-[#121212] border border-white/5 p-10 rounded-[2.5rem] space-y-4 hover:border-red-500/20 transition-all cursor-pointer group">
                    <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 group-hover:text-red-500 transition-colors">
                        <i data-lucide="user-plus" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-white font-bold">Manage Vendors</h3>
                    <p class="text-xs text-slate-600 font-medium">Add, remove or update permissions for your processing workforce.</p>
                </div>

                <div class="bg-[#121212] border border-white/5 p-10 rounded-[2.5rem] space-y-4 hover:border-red-500/20 transition-all cursor-pointer group">
                    <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 group-hover:text-red-500 transition-colors">
                        <i data-lucide="building" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-white font-bold">Client Matrix</h3>
                    <p class="text-xs text-slate-600 font-medium">Audit client usage, adjust credit limits and manage subscriptions.</p>
                </div>

                <div class="bg-[#121212] border border-white/5 p-10 rounded-[2.5rem] space-y-4 hover:border-red-500/20 transition-all cursor-pointer group">
                    <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 group-hover:text-red-500 transition-colors">
                        <i data-lucide="settings-2" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-white font-bold">System Overlays</h3>
                    <p class="text-xs text-slate-600 font-medium">Configure global upload limits, maintenance modes and API keys.</p>
                </div>
            </div>
        </main>

        <footer class="p-12 text-center border-t border-white/5 bg-[#0a0a0c]">
            <p class="text-[9px] font-black text-slate-700 uppercase tracking-[0.6em]">System Architecture • Core Node • Active</p>
        </footer>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
