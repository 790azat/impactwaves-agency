@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-4 text-sm">
        <p class="text-slate-500">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}</p>
        <div class="flex gap-2">
            @if ($paginator->onFirstPage())
                <span class="btn btn-ghost !px-4 !py-2 opacity-40">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-ghost !px-4 !py-2">Previous</a>
            @endif
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-ghost !px-4 !py-2">Next</a>
            @else
                <span class="btn btn-ghost !px-4 !py-2 opacity-40">Next</span>
            @endif
        </div>
    </nav>
@endif
