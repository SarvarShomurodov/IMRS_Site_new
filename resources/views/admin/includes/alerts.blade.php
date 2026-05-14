<div class="col-lg-12">
  <div class="mb-10" style="margin-bottom: 10px">

    @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $error }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endforeach
    @endif


    @if(session()->has('success'))
      <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
      </div>
    @endif


  </div>
</div>

<!-- DELETE item -->
<div id="myModal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true" style="padding-right: 17px; display: none;">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 0">
            <div class="col-lg-12" style="margin: 0; padding: 0">
                <div class="alert alert-danger mb-0" role="alert">
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="mdi mdi-block-helper display-4"></i>
                        </div>
                        <h4 class="alert-heading font-18">Вы точно хотите удалить?</h4>
                        <p>без восстановления</p>
                        <div class="py-2">
                            <a id="deleteItem" href="" class="btn btn-danger btn-rounded w-lg">Удалить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  function deleteArchive(rel){
    $('a#deleteItem').attr('href', $(rel).attr('rel'));
  }
</script>
