@props(['title', 'value', 'icon', 'color' => 'blue', 'subtext' => ''])

<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex flex-col justify-between h-32 hover:shadow-md transition-shadow group">
    <div class="flex justify-between items-start">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $title }}</p>
            <h4 class="text-3xl font-bold text-primary mt-1">{{ $value }}</h4>
        </div>
        <div class="p-3 rounded-lg bg-{{ $color }}-50 text-{{ $color }}-500 group-hover:bg-{{ $color }}-100 transition-colors">
            <i class="{{ $icon }} text-xl"></i>
        </div>
    </div>
    @if($subtext)
        <p class="text-xs text-slate-400 mt-auto">{{ $subtext }}</p>
    @endif
</div>