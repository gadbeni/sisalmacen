
<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$salcomp->id}}">
{{Form::Open(array('action'=>array('SaldocompraController@closeinventorytoyear',$salcomp->id),'method'=>'POST'))}}
  <div class="modal-dialog">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title">Confirmar si desea aplicar acción!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hiden="true">x</span>
        </button>
      </div>

      <div class="modal-body">
          <h4 class="modal-title">Esta opcion solo puede hacerce una vez y solo finalizada la gestion.</h4>
          <div class="form-group">
            <label for="observation">Observacion</label>
             <textarea name="observation" class="form-control" rows="4"></textarea>
          </div>
          <input type="hidden" value="{{$salcomp->sucursal->id}}" name="sucursal">
          <input type="hidden" value="{{$salcomp->id}}" name="saldo_compra_id">
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">cerrar</button>
        <button type="submit" class="btn btn-outline-light">Confirmar</button>
      </div>
    </div>
  </div>
{{Form::Close()}}
</div>