<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$sucursal->id}}">
{{Form::Open(array('action'=>array('SucursalController@destroy',$sucursal->id),'method'=>'delete'))}}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hiden="true">x</span>
        </button>
      </div>

      <div class="modal-body">
        <p style="color:#FF0000";>Confirmar si desea aplicar acción!</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">cerrar</button>
        <button type="submit" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
{{Form::Close()}}
</div>