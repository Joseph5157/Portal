<x-app-layout>
    <div class="min-h-screen bg-[#08080a] text-slate-300 font-['Outfit'] pb-20">
        @if(session('success'))
            <div
                class="bg-green-500/10 border border-green-500/20 text-green-500 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3 mb-8 mx-10 mt-6">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div
                class="bg-red-500/10 border border-red-500/20 text-red-500 px-6 py-4 rounded-2xl text-sm font-bold mb-8 mx-10 mt-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <nav
            class="flex justify-between items-center px-10 py-6 border-b border-white/5 bg-[#0a0a0c]/50 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}"
                    class="w-10 h-10 bg-white/5 hover:bg-white/10 rounded-xl flex items-center justify-center transition-all border border-white/5">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-slate-400"></i>
                </a>
                <div>
                    <h1 class="text-sm font-bold text-white tracking-tight uppercase">Client Matrix</h1>
                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-[0.3em]">Auditing & Credits</p>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-10 py-12">
            <div class="bg-[#0a0a0c] border border-white/5 rounded-[3rem] p-10">
                <div class="flex justify-between items-center mb-10">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 bg-purple-500/10 rounded-2xl flex items-center justify-center text-purple-500">
                            <i data-lucide="building" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Client Organizations</h2>
                            <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest mt-0.5">Manage
                                quotas</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr
                                class="text-[9px] text-slate-700 font-bold uppercase tracking-[0.25em] border-b border-white/5">
                                <th class="pb-6 px-4">Client / Org name</th>
                                <th class="pb-6 text-center">Total Slots</th>
                                <th class="pb-6 text-center">Used Slots</th>
                                <th class="pb-6 text-center">Status</th>
                                <th class="pb-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/[0.02]">
                            @foreach($clients as $client)
                                <tr class="group hover:bg-white/[0.01] transition-all">
                                    <td class="py-6 px-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-slate-500 group-hover:bg-purple-500/10 group-hover:text-purple-500 transition-all border border-white/5">
                                                <i data-lucide="building" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-slate-300">{{ $client->name }}</h4>
                                                <p class="text-[9px] text-slate-600 font-mono">ID: {{ $client->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 text-center text-sm font-bold text-slate-500">
                                        {{ $client->slots }}
                                    </td>
                                    <td class="py-6 text-center">
                                        <span
                                            class="px-3 py-1 bg-amber-500/10 text-amber-500 rounded-lg text-xs font-bold border border-amber-500/10">
                                            {{ $client->orders_count }}
                                        </span>
                                    </td>
                                    <td class="py-6 text-center">
                                        @if($client->status === 'active')
                                            <span
                                                class="px-3 py-1 bg-green-500/10 text-green-500 rounded-lg text-xs font-bold border border-green-500/10 uppercase tracking-wider">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-red-500/10 text-red-500 rounded-lg text-xs font-bold border border-red-500/10 uppercase tracking-wider">
                                                Suspended
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button
                                                onclick="openRefillModal({{ $client->id }}, '{{ addslashes($client->name) }}')"
                                                class="px-4 py-2 bg-green-500/10 hover:bg-green-500/20 text-green-500 text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all border border-green-500/20">
                                                Refill
                                            </button>
                                            <button
                                                onclick="openCreditsModal({{ $client->id }}, {{ $client->slots }}, '{{ addslashes($client->name) }}', '{{ $client->status }}')"
                                                class="px-4 py-2 bg-white/5 hover:bg-white/10 text-slate-400 text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all border border-white/5">
                                                Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    {{-- Adjust Credits Modal --}}
    <div id="credits-modal"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-[#0a0a0c] border border-white/10 rounded-[2.5rem] w-full max-w-sm p-8 shadow-2xl"
            onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-500 border border-purple-500/20">
                        <i data-lucide="sliders" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold" id="modal-client-name">Adjust Credits</h3>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest mt-0.5">Quota Management</p>
                    </div>
                </div>
                <button onclick="document.getElementById('credits-modal').classList.add('hidden')"
                    class="text-slate-500 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="credits-form" method="POST" action="" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Total
                        Slots</label>
                    <input type="number" name="slots" id="modal-client-slots" required min="0"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500/50 transition-colors">
                </div>
                <div>
                    <label
                        class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Status</label>
                    <select name="status" id="modal-client-status" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500/50 appearance-none">
                        <option value="active" class="bg-[#0a0a0c]">Active</option>
                        <option value="suspended" class="bg-[#0a0a0c]">Suspended</option>
                    </select>
                </div>
                <div class="pt-4 mt-8 border-t border-white/5">
                    <button type="submit"
                        class="w-full py-4 bg-purple-600/10 hover:bg-purple-600/20 text-purple-500 text-[10px] font-bold uppercase tracking-[0.3em] rounded-xl border border-purple-600/20 transition-all flex justify-center items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Refill Credits Modal --}}
    <div id="refill-modal"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-[#0a0a0c] border border-white/10 rounded-[2.5rem] w-full max-w-sm p-8 shadow-2xl"
            onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500 border border-green-500/20">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold" id="modal-refill-name">Refill Client</h3>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest mt-0.5">Add Slots</p>
                    </div>
                </div>
                <button onclick="document.getElementById('refill-modal').classList.add('hidden')"
                    class="text-slate-500 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="refill-form" method="POST" action="" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Number of
                        files to add</label>
                    <input type="number" name="additional_slots" required min="1"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-green-500/50 transition-colors">
                </div>
                <div class="pt-4 mt-8 border-t border-white/5">
                    <button type="submit"
                        class="w-full py-4 bg-green-600/10 hover:bg-green-600/20 text-green-500 text-[10px] font-bold uppercase tracking-[0.3em] rounded-xl border border-green-600/20 transition-all flex justify-center items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i> Confirm Top-up
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
        function openCreditsModal(id, slots, name, status) {
            document.getElementById('modal-client-name').innerText = name;
            document.getElementById('modal-client-slots').value = slots;
            document.getElementById('modal-client-status').value = status;
            document.getElementById('credits-form').action = '/admin/matrix/' + id;
            document.getElementById('credits-modal').classList.remove('hidden');
        }

        function openRefillModal(id, name) {
            document.getElementById('modal-refill-name').innerText = name;
            document.getElementById('refill-form').action = '/admin/matrix/' + id + '/refill';
            document.getElementById('refill-modal').classList.remove('hidden');
        }
    </script>
</x-app-layout>