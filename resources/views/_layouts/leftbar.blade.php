<div class="flex flex-row w-auto flex-shrink-0 pl-4 pr-2 py-4">
    <div class="flex flex-col items-center py-4 flex-shrink-0 w-20 bg-cyan-500 rounded-3xl">
        <a href="#" class="flex items-center justify-center h-12 w-12 bg-cyan-50 text-cyan-700 rounded-full">

            POS
        </a>
        <ul class="flex flex-col space-y-2 mt-12">
            @foreach ($menus['menu'] as $item)
            <li>
                <a href="{{ $item['url'] }}" class="flex items-center">
                    <span class="flex items-center justify-center h-12 w-12 rounded-2xl
                {{ $menus['activeMenu'] === $item['url'] 
                    ? 'bg-cyan-300 shadow-lg text-white' 
                    : 'hover:bg-cyan-400 text-cyan-100' }}">
                        <i class="fa {{ $item['icon'] }}"></i>
                    </span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>