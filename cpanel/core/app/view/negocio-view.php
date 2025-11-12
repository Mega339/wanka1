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
                <h6 class="card-title text-white mb-0">Gestión de Negocios</h6>
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
                            <th>Logo</th>
                            <th>RUC</th>
                            <th>Nombre</th>
                            <th>Representante</th>
                            <th>Correo</th>
                            <th>Telefono</th>
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
<div class="modal fade" id="MEditar" tabindex="-1" aria-labelledby="negocioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="negocioModalLabel">Editar Negocio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="negocio-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-4">
                            <label for="ruc" class="form-label">RUC</label>
                            <input type="text" id="ruc_edit" name="ruc" class="form-control form-control-sm" required 
                                   maxlength="20" title="Por favor ingrese el RUC." />
                        </div>
                        <div class="col-lg-8">
                            <label for="nombre" class="form-label">Nombre del Negocio</label>
                            <input type="text" id="nombre_edit" name="nombre" class="form-control form-control-sm" required 
                                   maxlength="150" title="Por favor ingrese el nombre del negocio." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" id="direccion_edit" name="direccion" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese la direccion." />
                        </div>

                        <div class="col-lg-6">
                            <label for="representante" class="form-label">Representante</label>
                            <input type="text" id="representante_edit" name="representante" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese el representante." />
                        </div>

                        <div class="col-lg-6">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" id="correo_edit" name="correo" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese el correo." />
                        </div>

                        <div class="col-lg-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono_edit" name="telefono" class="form-control form-control-sm" 
                                   maxlength="20" title="Por favor ingrese el telefono." />
                        </div>

                        <div class="col-lg-6">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="form-check form-switch form-switch-lg">
                                <input type="checkbox" name="estado" id="estado_edit">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label for="logo" class="form-label">Logo (Imagen)</label>
                            <input type="file" id="logo_edit" name="imagen" class="form-control form-control-sm" 
                                   accept="image/*" title="Seleccione una imagen para el logo." />
                            <small class="text-muted">Deje vacío si no desea cambiar la imagen</small>
                        </div>

                        <div class="col-lg-12">
                            <div id="preview_edit" class="mt-2"></div>
                            <input type="hidden" id="logo_actual_edit" name="logo_actual">
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="23">
                        <input type="hidden" name="id" id="edit_id">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="update-negocio-btn">Actualizar Negocio</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="negocioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="negocioModalLabel">Nuevo Negocio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="negocio-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-4">
                            <label for="ruc" class="form-label">RUC</label>
                            <input type="text" id="ruc" name="ruc" class="form-control form-control-sm" required 
                                   maxlength="20" title="Por favor ingrese el RUC." />
                        </div>
                        <div class="col-lg-8">
                            <label for="nombre" class="form-label">Nombre del Negocio</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required 
                                   maxlength="150" title="Por favor ingrese el nombre del negocio." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" id="direccion" name="direccion" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese la direccion." />
                        </div>

                        <div class="col-lg-6">
                            <label for="representante" class="form-label">Representante</label>
                            <input type="text" id="representante" name="representante" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese el representante." />
                        </div>

                        <div class="col-lg-6">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" id="correo" name="correo" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese el correo." />
                        </div>

                        <div class="col-lg-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" 
                                   maxlength="20" title="Por favor ingrese el telefono." />
                        </div>

                        <div class="col-lg-12">
                            <label for="logo" class="form-label">Logo (Imagen)</label>
                            <input type="file" id="logo" name="imagen" class="form-control form-control-sm" 
                                   accept="image/*" title="Seleccione una imagen para el logo." />
                        </div>

                        <div class="col-lg-12">
                            <div id="preview" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="22">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="register-negocio-btn">Registrar Negocio</button>
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
                            <input type="hidden" name="actions" value="24">
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
            "ajax": "index.php?action=negocio&actions=1",
            "columns": [
                { "data": "logo",
                    "render": function (data, type, row) {
                        if(data && data != '') {
                            return data;
                        } else {
                            return '<span class="badge bg-secondary">Sin imagen</span>';
                        }
                    }
                },
                { "data": "ruc" },
                { "data": "nombre" },
                { "data": "representante" },
                { "data": "correo" },
                { "data": "telefono" },
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
        
        $('#logo').on('change', function(e){
            const file = e.target.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = function(e){
                    $('#preview').html('<img src="' + e.target.result + '" width="150" class="img-thumbnail">');
                }
                reader.readAsDataURL(file);
            }
        });

        $('#logo_edit').on('change', function(e){
            const file = e.target.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = function(e){
                    $('#preview_edit').html('<img src="' + e.target.result + '" width="150" class="img-thumbnail">');
                }
                reader.readAsDataURL(file);
            }
        });

        $('#mitabla').on('click', '.edit-btn', function(){
            var id = $(this).data('id');
            $.ajax({
                url: 'index.php?action=negocio&actions=2',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    $('#edit_id').val(response.id);
                    $('#ruc_edit').val(response.ruc);
                    $('#nombre_edit').val(response.nombre);
                    $('#direccion_edit').val(response.direccion);
                    $('#representante_edit').val(response.representante);
                    $('#correo_edit').val(response.correo);
                    $('#telefono_edit').val(response.telefono);
                    $('#logo_actual_edit').val(response.logo);
                    $('#estado_edit').prop('checked', response.estado == 1);
                    
                    if(response.logo && response.logo != '') {
                        $('#preview_edit').html('<img src="storage/archivo/' + response.logo + '" width="150" class="img-thumbnail"><br><small class="text-muted">Imagen actual</small>');
                    } else {
                        $('#preview_edit').html('<span class="badge bg-secondary">Sin imagen</span>');
                    }
                    
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