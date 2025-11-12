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

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="leadsList">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center py-2">
                <h6 class="card-title text-white mb-0">Gestión de Categorías</h6>
                <div class="hstack gap-2">
                    <button type="button" class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                        <i class="ri-add-line align-bottom me-1"></i> Nuevo
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table  class="table table-striped table-hover align-middle" id="mitabla">
                    <thead>
                        <tr>
                            <th>Negocio</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="MEditar" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="categoriaModalLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="categoria-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <label for="negocio" class="form-label">Negocio</label>
                            <select name="negocio" id="negocio_edit" class="form-select form-select-sm" required 
                                    title="Por favor, seleccione el negocio.">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $negocio1 = NegocioData::vercontenido();
                                 foreach ($negocio1 as $ng) { ?>
                                    <option value="<?= $ng->id; ?>"><?= $ng->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre_edit" name="nombre" class="form-control form-control-sm" required 
                                   title="Por favor ingrese el nombre de la categoría." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion_edit" name="descripcion" class="form-control form-control-sm" rows="3" 
                                      title="Por favor ingrese la descripción."></textarea>
                        </div>

                        <div class="col-lg-6">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="form-check form-switch form-switch-lg">
                                <input type="checkbox" name="estado" id="estado_edit">
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="26">
                        <input type="hidden" name="id" id="edit_id">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="update-categoria-btn">Actualizar Categoría</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="categoriaModalLabel">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="categoria-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <label for="negocio" class="form-label">Negocio</label>
                            <select name="negocio" id="negocio" class="form-select form-select-sm" required 
                                    title="Por favor, seleccione el negocio.">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $negocio1 = NegocioData::vercontenido();
                                 foreach ($negocio1 as $ng) { ?>
                                    <option value="<?= $ng->id; ?>"><?= $ng->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required 
                                   title="Por favor ingrese el nombre de la categoría." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control form-control-sm" rows="3" 
                                      title="Por favor ingrese la descripción."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="25">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="register-categoria-btn">Registrar Categoría</button>
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
                        <p class="text-muted fs-14 mb-4 pt-1">Dejará de existir toda la información de la base de datos</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <input type="hidden" name="actions" value="27">
                            <input type="hidden" name="id" id="id1">
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
    $(document).ready(function(){
        $('#mitabla').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=categoria&actions=1",
            "columns": [
                { "data": "negocio" },
                { "data": "nombre" },
                { "data": "descripcion" },
                { "data": "estado",
                    "render": function (data, type, row) {
                        return data === 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                    }
                 },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary edit-btn" data-id="${data.id}">Editar</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">Eliminar</button>
                        `;
                    }
                }
            ],
        });
        $('#mitabla').on('click', '.edit-btn', function(){
            var id = $(this).data('id');
            $.ajax({
                url: 'index.php?action=categoria&actions=2',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    $('#edit_id').val(response.id);
                    $('#negocio_edit').val(response.negocio);
                    $('#nombre_edit').val(response.nombre);
                    $('#descripcion_edit').val(response.descripcion);
                    $('#estado_edit').prop('checked', response.estado == 1);
                    $('#MEditar').modal('show');
                }
            });
        });
        $('#mitabla').on('click', '.delete-btn', function(){
            var id = $(this).data('id');
            $('#id1').val(id);
            $('#ModalEliminar').modal('show');
        });
    });
</script>