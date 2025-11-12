<?php
function showAlert($type, $message, $library = 'swal', $title = '', $timer = 1000, $showConfirmButton = true)
{
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

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="leadsList">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center py-2">
                <h6 class="card-title text-white mb-0">Gestión de Caja</h6>
                <div class="hstack gap-2">
                    <button type="button" class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                        <i class="ri-add-line align-bottom me-1"></i> Nuevo
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover align-middle" id="mitabla">
                    <thead>
                        <tr>
                            <th>Negocio</th>
                            <th>Monto Inicial</th>
                            <th>Monto Actual</th>
                            <th>Responsable</th>
                            <th>descripcion</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="MEditar" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="userModalLabel">Editar Capital</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="user-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-6">
                            <label for="monto_inicial" class="form-label">Monto Inicial</label>
                            <input type="number" id="monto_inicial" name="monto_inicial" class="form-control form-control-sm" required
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                title="El nombre solo debe contener letras y espacios." />
                        </div>

                        <div class="col-lg-6">
                            <label for="monto_actual" class="form-label">Monto Actual</label>
                            <input type="number" id="monto_actual" name="monto_actual" class="form-control form-control-sm" required
                                title="Por favor ingrese los apellidos." />
                        </div>
                         <div class="col-lg-6">
                            <label for="responsable" class="form-label">Responsable</label>
                            <input type="text" id="responsable" name="responsable" class="form-control form-control-sm" required
                                title="Por favor ingrese los apellidos." />
                        </div>
                         <div class="col-lg-6">
                            <label for="negocio" class="form-label">Negocios</label>
                            <select name="negocio" id="negocio" class="form-select form-select-sm" required
                                title="Por favor, seleccione el negocio del usuario.">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $negocio1 = NegocioData::vercontenido();
                                foreach ($negocio1 as $ng) { ?>
                                    <option value="<?= $ng->id; ?>"><?= $ng->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control form-control-sm"
                                title="Por favor ingrese el correo." />
                        </div>

                       

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="11">
                        <input type="hidden" name="id" id="edit_id">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="register-user-btn">Actualizar Usuario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="userModalLabel">Nuevo Capital</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="user-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-6">
                            <label for="monto_inicial" class="form-label">Monto Inicial</label>
                            <input type="number" id="monto_inicial" name="monto_inicial" class="form-control form-control-sm" required
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                title="El nombre solo debe contener letras y espacios." />
                        </div>

                        <div class="col-lg-6">
                            <label for="monto_actual" class="form-label">Monto Actual</label>
                            <input type="number" id="monto_actual" name="monto_actual" class="form-control form-control-sm" required
                                title="Por favor ingrese los apellidos." />
                        </div>
                        
                         <div class="col-lg-6">
                            <label for="responsable" class="form-label">Responsable</label>
                            <input type="text" id="responsable" name="responsable" class="form-control form-control-sm" required
                                title="Por favor ingrese los apellidos." />
                        </div>
                        <div class="col-lg-6">
                            <label for="negocio" class="form-label">Negocios</label>
                            <select name="negocio" id="negocio" class="form-select form-select-sm" required
                                title="Por favor, seleccione el negocio del usuario.">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $negocio1 = NegocioData::vercontenido();
                                foreach ($negocio1 as $ng) { ?>
                                    <option value="<?= $ng->id; ?>"><?= $ng->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control form-control-sm"
                                title="Por favor ingrese el correo." />
                        </div>

                        

                        
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="10">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="register-user-btn">Registrar Usuario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade zoomIn" id="ModalEliminar" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body p-4 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                    <div class="mt-4 text-center">
                        <h4 class="fs-semibold">¿Estás seguro de eliminar este registro?</h4>
                        <p class="text-muted fs-14 mb-4 pt-1">Dejará de existir la toda infomación de la base de datos</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <input type="hidden" name="actions" value="12">
                            <input type="hidden" name="id" id="id1">
                            <input type="hidden" name="producto" id="producto_id">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button class="btn btn-danger" id="delete-record">Confirmar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#mitabla').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=capital&actions=1",
            "columns": [{
                    "data": "negocio"
                },
                {
                    "data": "monto_inicial"
                },
                {
                    "data": "monto_actual"
                },
                {
                    "data": "descripcion"
                },
                {
                    "data": "responsable"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary edit-btn" data-id="${data.id}">Editar</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">Eliminar</button>
                        `;
                    }
                }
            ],
        });
        $('#mitabla').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'index.php?action=capital&actions=2',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('#edit_id').val(response.id);
                    $('#monto_inicial').val(response.monto_inicial);
                    $('#monto_actual').val(response.monto_actual);
                    $('#descripcion').val(response.descripcion);
                    $('#responsable').val(response.responsable);
                    $('#negocio').val(response.negocio);
                    $('#MEditar').modal('show');
                }
            });
        });
        $('#mitabla').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            $('#id1').val(id);
            $('#ModalEliminar').modal('show');
        });
    });
</script>