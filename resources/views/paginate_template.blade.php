@if($items->hasPages())
  @php
     $total=$items->total();
     $perPage = $items->perPage();
     $lastPage = ceil($total/$perPage);
     $curPage = $items->currentPage();
  @endphp
  @php $url = $items->url(1) @endphp
   <a class="pagination__page @if($curPage ==1 ) disabled @endif" href="{{ $url }}" >
       <span aria-hidden="true">«</span>
   </a>
   @php $p=1 @endphp
   @while($p<=$lastPage)
       @php $url = $items->url($p) @endphp
           <a class="pagination__page @if($curPage == $p) is-current @endif" href="{{ $url }}" >
               {{ $p }}
               @if($curPage == $p)
                   <span class="sr-only">(current)</span>
               @endif
           </a>
       @php $p=$p+1; @endphp
   @endwhile
   @php $url = $items->url($lastPage) @endphp
   <a class="pagination__page @if($curPage == $lastPage ) disabled @endif"  href="{{ $url }}" >
       <span aria-hidden="true">»</span>
   </a>
@endif
