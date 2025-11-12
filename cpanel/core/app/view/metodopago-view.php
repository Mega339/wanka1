<?php 
function showAlert($type, $message, $library = 'swal', $title = '', $timer = 1000, $showConfirmButton = true) {
        if ($library === 'swal') {
            echo "<script>
                Swal.fire({
                    icon: '$type',
                    title: '$title',
                    text: '$message',
                    timer: $timer,
                    showConfirmButton: " . ($showConfirmButton ? 'true' : 'false') . "
                });
            </script>";
        } elseif ($library === 'toastr') {
            echo "<script>toastr.$type('$message');</script>";
        } elseif ($library === 'noty') {
            echo "<script>
                new Noty({
                    type: '$type',
                    text: '$message',
                    timeout: $timer
                }).show();
            </script>";
        }
    }
    if (isset($_SESSION['success_message'])) {
        showAlert('success', $_SESSION['success_message'], 'swal', 'Éxito');
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        showAlert('error', $_SESSION['error_message'], 'toastr');
        unset($_SESSION['error_message']);
    }
    if (isset($_SESSION['success_messagea'])) {
        showAlert('success', $_SESSION['success_messagea'], 'noty');
        unset($_SESSION['success_messagea']);
    }
    if (isset($_SESSION['success_messagea1'])) {
        showAlert('error', $_SESSION['success_messagea1'], 'noty');
        unset($_SESSION['success_messagea1']);
    }
    if (isset($_SESSION['eliminado'])) {
        showAlert('error', $_SESSION['eliminado'], 'swal', 'Eliminado');
        unset($_SESSION['eliminado']);
    }
    ?>
<!-- tabla -->
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="metodoPagoList">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center py-2">
                <h6 class="card-title text-white mb-0">Gestión de Métodos de Pago</h6>
                <div class="hstack gap-2">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                        <i class="ri-add-line align-bottom me-1"></i> Nuevo
                    </button>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped table-hover align-middle" id="tablaMetodoPago">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- modal editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light p-2">
        <h5 class="modal-title" id="modalEditarLabel">Editar Método de Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="index.php?action=registro">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <label for="edit_nombre" class="form-label">Nombre</label>
          <input type="text" id="edit_nombre" name="nombre" class="form-control form-control-sm" required>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="actions" value="14">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- modal agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light p-2">
        <h5 class="modal-title" id="modalAgregarLabel">Nuevo Método de Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="index.php?action=registro">
        <div class="modal-body">
          <label for="nombre" class="form-label">Nombre del Método</label>
          <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="actions" value="13">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <h5 class="mb-3">¿Eliminar método de pago?</h5>
        <p>Este registro será eliminado permanentemente.</p>
        <form method="POST" action="index.php?action=registro">
          <input type="hidden" name="id" id="delete_id">
          <input type="hidden" name="actions" value="15">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    var tabla = $('#tablaMetodoPago').DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "index.php?action=metodopago&actions=1",
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary edit-btn" data-id="${data.id}">Editar</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">Eliminar</button>
                    `;
                }
            }
        ]
    });

    $('#tablaMetodoPago').on('click', '.edit-btn', function(){
        var id = $(this).data('id');
        $.ajax({
            url: 'index.php?action=metodopago&actions=2',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res){
                $('#edit_id').val(res.id);
                $('#edit_nombre').val(res.nombre);
                $('#modalEditar').modal('show');
            }
        });
    });

    $('#tablaMetodoPago').on('click', '.delete-btn', function(){
        $('#delete_id').val($(this).data('id'));
        $('#modalEliminar').modal('show');
    });
});
</script>