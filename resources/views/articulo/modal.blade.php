<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$art->id}}">
{{Form::Open(array('action'=>array('ArticuloController@destroy',$art->id),'method'=>'delete'))}}
  <div class="modal-dialog">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title">Confirmar si desea aplicar acción!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hiden="true">x</span>
        </button>
      </div>

      <div class="modal-body">
          <h4 class="modal-title">Desea eliminar este artículo?</h4>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">cerrar</button>
        <button type="submit" class="btn btn-outline-light">Confirmar</button>
      </div>
    </div>
  </div>
{{Form::Close()}}
</div>