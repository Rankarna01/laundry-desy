@props(['id', 'title'])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900 bg-opacity-50 transition-opacity backdrop-blur-sm" onclick="closeModal('{{ $id }}')"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border-t-4 border-accent">
            
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold leading-6 text-primary" id="modal-title">{{ $title }}</h3>
                    <button type="button" onclick="closeModal('{{ $id }}')" class="text-slate-400 hover:text-red-500 transition-colors">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="px-4 py-4 sm:p-6">
                {{ $slot }}
            </div>

            @if(isset($footer))
            <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>