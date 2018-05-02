@if ($paginator->lastPage() > 1)
	<div class="pagination">
        @if($paginator->currentPage() > 3)
        <a href="{{ $paginator->url( 1 ) }}" class="last-page">1</a>
        <span>...</span>
        @endif
		@for ($i = 1; $i <= $paginator->lastPage(); $i++)
			@if( abs($paginator->currentPage() - $i) <= 2 )
				<a href="{{ $paginator->url($i) }}" class="n-page {{ ($paginator->currentPage() == $i) ? 'active' : '' }}">
					{{ $i }}
				</a>
			@endif
		@endfor
        @if(($paginator->currentPage()+2) < $paginator->lastPage())
		    <span>...</span>
	    	<a href="{{ $paginator->url($paginator->lastPage()) }}" class="last-page">{{$paginator->lastPage()}}</a>
        @endif
	</div>
@endif