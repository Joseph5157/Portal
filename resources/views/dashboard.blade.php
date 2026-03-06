<x-vendor-layout title="Dashboard">

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Available Pool --}}
        <div
            class="group bg-[#13151c] border border-white/[0.06] rounded-2xl p-5 hover:border-indigo-500/30 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="w-9 h-9 bg-indigo-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <span
                    class="text-[9px] font-bold text-indigo-400 bg-indigo-400/5 border border-indigo-400/10 px-1.5 py-0.5 rounded-lg uppercase tracking-wider">Pool</span>
            </div>
            <p class="text-3xl font-bold text-white tabular-nums">{{ $stats['available_pool'] }}</p>
            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-semibold mt-1">Available Orders</p>
        </div>

        {{-- Active Jobs --}}
        <div
            class="group bg-[#13151c] border border-white/[0.06] rounded-2xl p-5 hover:border-blue-500/30 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="w-9 h-9 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span
                    class="text-[9px] font-bold text-blue-400 bg-blue-400/5 border border-blue-400/10 px-1.5 py-0.5 rounded-lg uppercase tracking-wider">Active</span>
            </div>
            <p class="text-3xl font-bold text-white tabular-nums">{{ $stats['active_jobs'] }}</p>
            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-semibold mt-1">In Progress</p>
        </div>

        {{-- Total Checked Today --}}
        <div
            class="group bg-[#13151c] border border-white/[0.06] rounded-2xl p-5 hover:border-emerald-500/30 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="w-9 h-9 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span
                    class="text-[9px] font-bold text-emerald-400 bg-emerald-400/5 border border-emerald-400/10 px-1.5 py-0.5 rounded-lg uppercase tracking-wider">Today</span>
            </div>
            <p class="text-3xl font-bold text-white tabular-nums">{{ $stats['total_checked_today'] }}</p>
            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-semibold mt-1">Delivered</p>
        </div>

        {{-- Overdue --}}
        <div
            class="group bg-[#13151c] border @if($stats['overdue_count'] > 0) border-red-500/20 @else border-white/[0.06] @endif rounded-2xl p-5 hover:border-red-500/30 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div
                    class="w-9 h-9 @if($stats['overdue_count'] > 0) bg-red-500/10 @else bg-white/5 @endif rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 @if($stats['overdue_count'] > 0) text-red-400 @else text-slate-600 @endif"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                @if($stats['overdue_count'] > 0)
                    <span
                        class="text-[9px] font-bold text-red-400 bg-red-400/5 border border-red-400/10 px-1.5 py-0.5 rounded-lg uppercase tracking-wider animate-pulse">Alert</span>
                @endif
            </div>
            <p
                class="text-3xl font-bold @if($stats['overdue_count'] > 0) text-red-400 @else text-white @endif tabular-nums">
                {{ $stats['overdue_count'] }}</p>
            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-semibold mt-1">Overdue Tasks</p>
        </div>
    </div>

    {{-- ===== PRIMARY CONTENT GRID ===== --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- LEFT COLUMN (2/3 width) --}}
        <div class="xl:col-span-2 space-y-5">

            {{-- ===== MY WORKSPACE ===== --}}
            <div id="workspace" class="bg-[#13151c] border border-white/[0.06] rounded-2xl overflow-hidden">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-white/[0.06]">
                    <div class="flex items-center gap-2.5">
                        <div class="w-1.5 h-4 bg-indigo-500 rounded-full"></div>
                        <h2 class="text-sm font-semibold text-white">My Workspace</h2>
                        @if($myWorkspace->count() > 0)
                            <span
                                class="bg-indigo-500/10 text-indigo-400 border border-indigo-500/15 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">{{ $myWorkspace->count() }}</span>
                        @endif
                    </div>
                    @if($myWorkspace->count() > 0)
                        @php
                            $minutes = $myWorkspace->map(function($order) {
                                return $order->due_at ? max(0, now()->diffInMinutes($order->due_at, false)) : 0;
                            })->sort()->values()->pipe(function($sorted) {
                                $count = $sorted->count();
                                if ($count === 0) return 0;
                                $middle = floor($count / 2);
                                return $count % 2 ? $sorted[$middle] : ($sorted[$middle - 1] + $sorted[$middle]) / 2;
                            });
                        @endphp
                        <div class="flex items-center gap-1.5 text-[10px] font-semibold @if($minutes < 5) text-red-400 @else text-slate-500 @endif">
                            <svg class="w-3 h-3 @if($minutes < 5) text-red-500 @else text-indigo-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            ~{{ round($minutes) }} min ETA (Median)
                        </div>
                    @endif
                </div>

                {{-- Table --}}
                <table class="w-full">
                    <thead>
                        <tr
                            class="text-[9px] text-slate-600 font-semibold uppercase tracking-widest border-b border-white/[0.04]">
                            <th class="text-left px-6 py-3 font-semibold">File</th>
                            <th class="text-center px-4 py-3 font-semibold">Timer</th>
                            <th class="text-center px-4 py-3 font-semibold">Status</th>
                            <th class="text-right px-6 py-3 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.04]">
                        @forelse($myWorkspace as $order)
                            @php $isOverdue = $order->is_overdue; @endphp
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 bg-indigo-600/10 rounded-lg flex items-center justify-center text-indigo-400 flex-shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-semibold text-slate-200 truncate max-w-[180px]">
                                                {{ $order->files->first() ? basename($order->files->first()->file_path) : 'Document' }}
                                            </p>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                @if($order->client)
                                                    <span
                                                        class="text-[9px] text-slate-500 truncate">{{ $order->client->name }}</span>
                                                @endif
                                                <span
                                                    class="text-[8px] font-bold px-1 py-0.5 rounded @if($order->source === 'account') bg-blue-500/10 text-blue-400 @else bg-purple-500/10 text-purple-400 @endif">{{ strtoupper($order->source) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($isOverdue)
                                        <span
                                            class="text-[9px] font-bold text-red-400 bg-red-500/5 border border-red-500/10 px-2 py-1 rounded-lg animate-pulse">Overdue</span>
                                    @else
                                        <span
                                            class="workspace-timer text-xs font-mono font-bold text-indigo-400 tabular-nums bg-indigo-500/5 border border-indigo-500/10 px-2 py-1 rounded-lg"
                                            data-due="{{ $order->due_at?->toIso8601String() }}">--:--</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($isOverdue)
                                        <span
                                            class="inline-flex items-center gap-1 text-[9px] font-bold text-red-400 bg-red-500/5 border border-red-500/10 px-2 py-1 rounded-full">
                                            <span class="w-1 h-1 bg-red-400 rounded-full"></span> Overdue
                                        </span>
                                    @elseif($order->status === 'processing')
                                        <span
                                            class="inline-flex items-center gap-1 text-[9px] font-bold text-blue-400 bg-blue-500/5 border border-blue-500/10 px-2 py-1 rounded-full">
                                            <span class="w-1 h-1 bg-blue-400 rounded-full animate-pulse"></span> Processing
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-[9px] font-bold text-slate-400 bg-white/5 border border-white/5 px-2 py-1 rounded-full">
                                            <span class="w-1 h-1 bg-slate-500 rounded-full"></span> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($order->files->first())
                                            <a href="{{ route('orders.files.download', [$order, $order->files->first()]) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-semibold text-slate-400 hover:text-white bg-white/5 hover:bg-white/10 border border-white/5 rounded-lg transition-all">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Download
                                            </a>
                                        @endif
                                        @if($order->status == 'pending')
                                            <form action="{{ route('orders.status', $order) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="processing">
                                                <button
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all shadow-lg shadow-emerald-600/10">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Start
                                                </button>
                                            </form>
                                        @else
                                            <button
                                                onclick="document.getElementById('upload-modal-{{ $order->id }}').classList.remove('hidden')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold text-white bg-indigo-600 hover:bg-indigo-500 rounded-lg transition-all shadow-lg shadow-indigo-600/10">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                Upload
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div
                                            class="w-12 h-12 bg-white/[0.03] border border-white/[0.06] rounded-2xl flex items-center justify-center text-slate-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-500">No active jobs</p>
                                            <p class="text-[10px] text-slate-600 mt-0.5">Claim an order from the queue below
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===== AVAILABLE FILES ===== --}}
            <div id="files" class="bg-[#13151c] border border-white/[0.06] rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-white/[0.06]">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h2 class="text-sm font-semibold text-white">Available Queue</h2>
                        @if($availableFiles->count() > 0)
                            <span
                                class="bg-amber-500/10 text-amber-400 border border-amber-500/15 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">{{ $availableFiles->count() }}
                                waiting</span>
                        @endif
                    </div>
                </div>

                <div class="divide-y divide-white/[0.04]">
                    @forelse($availableFiles as $order)
                        @php $isUrgent = $order->due_at && $order->due_at->diffInMinutes(now(), false) > -5; @endphp
                        <div
                            class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-white/[0.02] transition-colors group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="w-8 h-8 @if($isUrgent) bg-red-500/10 text-red-400 @else bg-white/5 text-slate-500 @endif rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0 space-y-0.5">
                                    <p class="text-xs font-semibold text-slate-200 truncate">
                                        {{ $order->files->first() ? basename($order->files->first()->file_path) : 'New Document' }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        @if($order->client)<span
                                            class="text-[9px] text-slate-500">{{ $order->client->name }}</span><span
                                        class="text-slate-700 text-[9px]">·</span>@endif
                                        <span
                                            class="text-[9px] text-slate-500 font-mono">{{ $order->created_at->diffForHumans() }}</span>
                                        <span
                                            class="text-[8px] font-bold px-1 rounded @if($order->source === 'account') bg-blue-500/10 text-blue-400 @else bg-purple-500/10 text-purple-400 @endif">{{ strtoupper($order->source) }}</span>
                                        <span
                                            class="text-[8px] font-bold text-slate-500 bg-white/5 px-1 rounded">{{ $order->files_count }}
                                            {{ Str::plural('file', $order->files_count) }}</span>
                                        @if($isUrgent)<span
                                        class="text-[8px] font-bold text-red-400 bg-red-500/5 border border-red-500/10 px-1.5 rounded animate-pulse">Urgent</span>@endif
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('orders.claim', $order) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <button
                                    class="inline-flex items-center gap-1.5 px-4 py-2 text-[10px] font-bold text-black bg-amber-400 hover:bg-amber-300 rounded-xl transition-all shadow-md shadow-amber-400/10 group-hover:scale-105">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Claim
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <p class="text-sm font-semibold text-slate-600">Queue is empty</p>
                            <p class="text-[10px] text-slate-700 mt-0.5">No new orders are available right now</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>{{-- end left col --}}

        {{-- RIGHT COLUMN (1/3 width) --}}
        <div class="space-y-5">

            {{-- Recent History --}}
            <div id="history" class="bg-[#13151c] border border-white/[0.06] rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-white/[0.06]">
                    <h2 class="text-sm font-semibold text-white">Recent Deliveries</h2>
                    @if($recentHistory->count() > 0)
                        <span class="text-[9px] text-slate-500 font-semibold">{{ $recentHistory->count() }}</span>
                    @endif
                </div>
                <div class="divide-y divide-white/[0.04]">
                    @forelse($recentHistory as $history)
                        <div
                            class="flex items-center justify-between gap-3 px-5 py-3 hover:bg-white/[0.02] transition-colors group">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div
                                    class="w-6 h-6 bg-emerald-500/5 rounded-lg flex items-center justify-center text-emerald-600 flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p
                                        class="text-[11px] font-semibold text-slate-300 truncate group-hover:text-white transition-colors">
                                        {{ $history->files->first() ? basename($history->files->first()->file_path) : 'Document' }}
                                    </p>
                                    <p class="text-[9px] text-slate-600 mt-0.5 font-mono">
                                        {{ $history->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span
                                class="flex-shrink-0 text-[8px] font-bold text-emerald-400 bg-emerald-400/5 border border-emerald-400/10 px-1.5 py-0.5 rounded uppercase tracking-wider">Done</span>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <p class="text-[10px] text-slate-600 font-semibold">No deliveries yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Top Agents --}}
            <div id="agents" class="bg-[#13151c] border border-white/[0.06] rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-white/[0.06]">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <h2 class="text-sm font-semibold text-white">Top Agents</h2>
                    </div>
                    <span class="text-[9px] text-slate-600 font-semibold uppercase tracking-widest">Today</span>
                </div>
                <div class="divide-y divide-white/[0.04]">
                    @forelse($topAgents as $index => $agent)
                        @php
                            $isMe = $agent->id == auth()->id();
                            $maxJobs = $topAgents->max('jobs_count') ?: 1;
                            $pct = max(8, round(($agent->jobs_count / $maxJobs) * 100));
                            $rankIcon = $index === 0 ? '🥇' : ($index === 1 ? '🥈' : ($index === 2 ? '🥉' : '#' . ($index + 1)));
                        @endphp
                        <div class="px-5 py-3 hover:bg-white/[0.02] transition-colors">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span class="text-sm leading-none flex-shrink-0">{{ $rankIcon }}</span>
                                    <p
                                        class="text-[11px] font-semibold truncate @if($isMe) text-indigo-400 @else text-slate-300 @endif">
                                        @if($isMe) {{ auth()->user()->name }} <span
                                            class="text-indigo-500 text-[9px]">(you)</span>
                                        @else {{ substr($agent->name, 0, 1) }}{{ str_repeat('·', 6) }}
                                        @endif
                                    </p>
                                </div>
                                <span
                                    class="text-xs font-bold tabular-nums @if($isMe) text-indigo-400 @else text-slate-400 @endif flex-shrink-0">{{ $agent->jobs_count }}</span>
                            </div>
                            <div class="w-full bg-white/[0.04] rounded-full h-0.5">
                                <div class="h-0.5 rounded-full @if($isMe) bg-indigo-500 @elseif($index === 0) bg-amber-400 @else bg-white/20 @endif"
                                    style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <p class="text-[10px] text-slate-600 font-semibold">No activity today</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>{{-- end right col --}}

    </div>{{-- end grid --}}

    {{-- ===== UPLOAD MODALS ===== --}}
    @foreach($myWorkspace as $order)
        @if($order->status == 'processing')
            <div id="upload-modal-{{ $order->id }}"
                class="hidden fixed inset-0 bg-black/70 backdrop-blur-md z-50 flex items-center justify-center p-4"
                onclick="if(event.target===this)this.classList.add('hidden')">
                <div class="bg-[#1a1c24] border border-white/10 rounded-3xl w-full max-w-md shadow-2xl overflow-hidden"
                    onclick="event.stopPropagation()">
                    {{-- Header --}}
                    <div class="flex items-center justify-between px-7 pt-7 pb-5 border-b border-white/[0.06]">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-indigo-600/10 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-white">Submit Results</h3>
                                <p class="text-[9px] text-slate-500 uppercase tracking-widest mt-0.5 truncate max-w-[200px]">
                                    {{ $order->files->first() ? basename($order->files->first()->file_path) : 'Order #' . $order->id }}
                                </p>
                            </div>
                        </div>
                        <button onclick="document.getElementById('upload-modal-{{ $order->id }}').classList.add('hidden')"
                            class="w-7 h-7 bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white rounded-lg flex items-center justify-center transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    {{-- Form --}}
                    <form action="{{ route('orders.report', $order) }}" method="POST" enctype="multipart/form-data"
                        class="px-7 py-6 space-y-5">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">AI Score
                                    (%)</label>
                                <input type="number" name="ai_percentage" step="0.01" min="0" max="100" placeholder="0 – 100"
                                    class="w-full bg-white/5 border border-white/[0.08] rounded-xl py-2.5 px-3 text-sm text-white placeholder-slate-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Plag Score
                                    (%)</label>
                                <input type="number" name="plag_percentage" step="0.01" min="0" max="100" placeholder="0 – 100"
                                    class="w-full bg-white/5 border border-white/[0.08] rounded-xl py-2.5 px-3 text-sm text-white placeholder-slate-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-all">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Report PDF</label>
                            <label
                                class="block w-full bg-white/[0.03] hover:bg-white/[0.05] border border-dashed border-white/10 hover:border-indigo-500/30 rounded-xl py-6 text-center cursor-pointer transition-all group">
                                <svg class="w-6 h-6 text-slate-600 group-hover:text-indigo-400 mx-auto mb-2 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p
                                    class="text-[10px] font-semibold text-slate-600 group-hover:text-slate-400 transition-colors">
                                    Click to upload PDF</p>
                                <input type="file" name="report" accept=".pdf" required class="hidden">
                            </label>
                        </div>
                        <div class="flex gap-3">
                            <button type="button"
                                onclick="document.getElementById('upload-modal-{{ $order->id }}').classList.add('hidden')"
                                class="px-5 py-2.5 text-xs font-semibold text-slate-400 hover:text-white bg-white/5 hover:bg-white/10 rounded-xl transition-all">Cancel</button>
                            <button type="submit"
                                class="flex-1 py-2.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Submit Results
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endforeach

    {{-- Workspace timers --}}
    <script>
        function updateWorkspaceTimers() {
            document.querySelectorAll('.workspace-timer').forEach(el => {
                if (!el.dataset.due) return;
                const diff = new Date(el.dataset.due).getTime() - Date.now();
                if (diff <= 0) { el.textContent = '00:00'; return; }
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);
                el.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            });
        }
        setInterval(updateWorkspaceTimers, 1000);
        updateWorkspaceTimers();
    </script>

</x-vendor-layout>