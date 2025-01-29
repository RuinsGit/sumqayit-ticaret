@if ($paginator->hasPages())
    <ul class="pagination justify-content-center" style="margin: 20px 0; padding: 10px;">
        {{-- İlk sayfa bağlantısı --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span style="padding: 10px; font-size: 16px;">&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding: 10px; font-size: 16px;">&laquo;</a></li>
        @endif

        {{-- Sayfa numaraları --}}
        @foreach ($elements as $element)
            {{-- Dizi bağlantısı --}}
            @if (is_string($element))
                <li class="disabled"><span style="padding: 10px; font-size: 16px;">{{ $element }}</span></li>
            @endif

            {{-- Sayfa numarası bağlantıları --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span style="padding: 10px; font-size: 16px; color: blue;">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}" style="padding: 10px; font-size: 16px;">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Sonraki sayfa bağlantısı --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding: 10px; font-size: 16px;">&raquo;</a></li>
        @else
            <li class="disabled"><span style="padding: 10px; font-size: 16px;">&raquo;</span></li>
        @endif
    </ul>
@endif 