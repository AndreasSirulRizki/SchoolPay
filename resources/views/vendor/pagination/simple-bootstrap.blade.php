@if ($paginator->hasPages())
<div style="display:flex;gap:4px">
    @if ($paginator->onFirstPage())
        <span style="width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:#f8fafc;display:grid;place-items:center;font-size:12px;color:var(--text-3)">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:#fff;display:grid;place-items:center;font-size:12px;color:var(--text-2);text-decoration:none">‹</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding:0 4px;color:var(--text-3);font-size:12px;display:grid;place-items:center">…</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="width:30px;height:30px;border-radius:7px;background:var(--navy);color:#fff;display:grid;place-items:center;font-size:12px;font-weight:600">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:#fff;display:grid;place-items:center;font-size:12px;font-weight:600;color:var(--text-2);text-decoration:none">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:#fff;display:grid;place-items:center;font-size:12px;color:var(--text-2);text-decoration:none">›</a>
    @else
        <span style="width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:#f8fafc;display:grid;place-items:center;font-size:12px;color:var(--text-3)">›</span>
    @endif
</div>
@endif
