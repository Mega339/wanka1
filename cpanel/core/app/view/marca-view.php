<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function showAlert($type, $message, $library = 'swal', $title = '', $timer = 1500, $showConfirmButton = true) {
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
if (isset($_SESSION['eliminado'])) {
    showAlert('error', $_SESSION['eliminado'], 'swal', 'Eliminado');
    unset($_SESSION['eliminado']);
}
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="leadsList">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center py-2">
                <h6 class="card-title text-white mb-0">Gestión de Marca</h6>
                <div class="hstack gap-2">
                    <button type="button" class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                        <i class="ri-add-line align-bottom me-1"></i> Nuevo
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover align-middle" id="mitabla">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Negocio</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $marcas = MarcaData::getAll();
                        foreach ($marcas as $m): ?>
                            <tr>
                                <td><?php echo $m->id; ?></td>
                                <td><?php echo htmlspecialchars($m->negocio); ?></td>
                                <td><?php echo htmlspecialchars($m->nombre); ?></td>
                                <td><?php echo htmlspecialchars($m->descripcion); ?></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary edit-btn" 
                                            data-id="<?php echo $m->id; ?>" 
                                            data-negocio="<?php echo htmlspecialchars($m->negocio); ?>" 
                                            data-nombre="<?php echo htmlspecialchars($m->nombre); ?>" 
                                            data-descripcion="<?php echo htmlspecialchars($m->descripcion); ?>">
                                        Editar
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" 
                                            data-id="<?php echo $m->id; ?>">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVO -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="nuevoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="nuevoLabel">Nueva Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="index.php?action=registro" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" name="actions" value="40">
                    <div class="mb-2">
                        <label for="negocio" class="form-label">Negocio</label>
                        <input type="text" id="negocio" name="negocio" class="form-control form-control-sm" required />
                    </div>
                    <div class="mb-2">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required />
                    </div>
                    <div class="mb-2">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control form-control-sm" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="MEditar" tabindex="-1" aria-labelledby="editarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="editarLabel">Editar Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="index.php?action=marca-registro" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" name="actions" value="13">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-2">
                        <label class="form-label">Negocio</label>
                        <input type="text" id="edit_negocio" name="negocio" class="form-control form-control-sm" required />
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Nombre</label>
                        <input type="text" id="edit_nombre" name="nombre" class="form-control form-control-sm" required />
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Descripción</label>
                        <input type="text" id="edit_descripcion" name="descripcion" class="form-control form-control-sm" />
                    </div>
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="ModalEliminar" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="index.php?action=marca-registro" autocomplete="off">
                <div class="modal-body">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                    <h4 class="mt-3">¿Estás seguro de eliminar este registro?</h4>
                    
                   
                    <input type="hidden" name="actions" value="14">
                    <input type="hidden" name="id" id="delete_id">
                    
                    <div class="mt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function(){
 
    $('.edit-btn').click(function(){
        $('#edit_id').val($(this).data('id'));
        $('#edit_negocio').val($(this).data('negocio'));
        $('#edit_nombre').val($(this).data('nombre'));
        $('#edit_descripcion').val($(this).data('descripcion'));
        $('#MEditar').modal('show');
    });

  
    $('.delete-btn').click(function(){
        $('#delete_id').val($(this).data('id'));
        $('#ModalEliminar').modal('show');
    });
});
</script>
