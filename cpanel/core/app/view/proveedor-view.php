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
                <h6 class="card-title text-white mb-0">Gestión de Proveedores</h6>
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
                            <th>RUC</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Categoría</th>
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
<div class="modal fade" id="MEditar" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="proveedorModalLabel">Editar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="proveedor-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-3">
                            <label for="ruc" class="form-label">RUC</label>
                            <input type="text" id="ruc" name="ruc" class="form-control form-control-sm" required 
                                   maxlength="20" title="Por favor ingrese el RUC." />
                        </div>
                        <div class="col-lg-9">
                            <label for="nombre" class="form-label">Nombre del Proveedor</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required 
                                   maxlength="150" title="Por favor ingrese el nombre." />
                        </div>
                        
                        <div class="col-lg-4">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" 
                                   maxlength="30" title="Por favor ingrese el teléfono." />
                        </div>

                        <div class="col-lg-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm" 
                                   maxlength="100" title="Por favor ingrese el email." />
                        </div>

                        <div class="col-lg-4">
                            <label for="sitio_web" class="form-label">Sitio Web</label>
                            <input type="url" id="sitio_web" name="sitio_web" class="form-control form-control-sm" 
                                   maxlength="150" title="Por favor ingrese el sitio web." />
                        </div>

                        <div class="col-lg-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" id="direccion" name="direccion" class="form-control form-control-sm" 
                                   maxlength="200" title="Por favor ingrese la dirección." />
                        </div>

                        <div class="col-lg-4">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" id="ciudad" name="ciudad" class="form-control form-control-sm" 
                                   maxlength="100" title="Por favor ingrese la ciudad." />
                        </div>

                        <div class="col-lg-4">
                            <label for="pais" class="form-label">País</label>
                            <input type="text" id="pais" name="pais" class="form-control form-control-sm" 
                                   maxlength="100" title="Por favor ingrese el país." />
                        </div>

                        <div class="col-lg-4">
                            <label for="categoria" class="form-label">Categoría</label>
                            <input type="text" id="categoria" name="categoria" class="form-control form-control-sm" 
                                   maxlength="50" title="Por favor ingrese la categoría." />
                        </div>

                        <div class="col-lg-4">
                            <label for="condiciones_pago" class="form-label">Condiciones de Pago</label>
                            <input type="text" id="condiciones_pago" name="condiciones_pago" class="form-control form-control-sm" 
                                   maxlength="100" title="Por favor ingrese las condiciones de pago." />
                        </div>

                        <div class="col-lg-4">
                            <label for="moneda_preferida" class="form-label">Moneda Preferida</label>
                            <select name="moneda_preferida" id="moneda_preferida" class="form-select form-select-sm">
                                <option value="">Seleccionar</option>
                                <option value="PEN">PEN - Soles</option>
                                <option value="USD">USD - Dólares</option>
                                <option value="EUR">EUR - Euros</option>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="calificacion" class="form-label">Calificación (1-5)</label>
                            <input type="number" id="calificacion" name="calificacion" class="form-control form-control-sm" 
                                   min="1" max="5" title="Calificación del proveedor." />
                        </div>

                        <div class="col-lg-12">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="form-check form-switch form-switch-lg">
                                <input type="checkbox" name="estado" id="estado">
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="8">
                        <input type="hidden" name="id" id="edit_id">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="update-proveedor-btn">Actualizar Proveedor</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light p-2">
                <h5 class="modal-title" id="proveedorModalLabel">Nuevo Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="proveedor-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-3">
                            <label for="ruc" class="form-label">RUC</label>
                            <input type="text" id="ruc" name="ruc" class="form-control form-control-sm" required 
                                   maxlength="20" title="Por favor ingrese el RUC." />
                        </div>
                        <div class="col-lg-9">
                            <label for="nombre" class="form-label">Nombre del Proveedor</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required 
                                   maxlength="150" title="Por favor ingrese el nombre." />
                        </div>
                        
                        <div class="col-lg-4">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" 
                                   maxlength="30" title="Por favor ingrese el teléfono." />
                        </div>

                        <div class="col-lg-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm" 
                                   maxlength="100" title="Por favor ingrese el email." />
                        </div>

                        <div class="col-lg-4">
                            <label for="sitio_web" class="form-label">Sitio Web</label>
                            <input type="url" id="sitio_web" name="sitio_web" class="form-control form-control-sm" 
                                   maxlength="150" title="Por favor ingrese el sitio web." />
                        </div>

                        <div class="col-lg-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" id="direccion" name="direccion" class="form-control form-control-sm" 
                                   maxlength="200" title="Por favor ingrese la dirección." />
                        </div>

                        <div class="col-lg-4">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" id="ciudad" name="ciudad" class="form-control form-control-sm" 
                                   maxlength="100" title="Por favor ingrese la ciudad." />
                        </div>

                        <div class="col-lg-4">
                            <label for="pais" class="form-label">País</label>
                            <input type="text" id="pais" name="pais" class="form-control form-control-sm" 
                                   maxlength="100" title="Por favor ingrese el país." />
                        </div>

                        <div class="col-lg-4">
                            <label for="categoria" class="form-label">Categoría</label>
                            <input type="text" id="categoria" name="categoria" class="form-control form-control-sm" 
                                   maxlength="50" title="Por favor ingrese la categoría." />
                        </div>

                        <div class="col-lg-4">
                            <label for="condiciones_pago" class="form-label">Condiciones de Pago</label>
                            <input type="text" id="condiciones_pago" name="condiciones_pago" class="form-control form-control-sm" 
                                   maxlength="100" title="Por favor ingrese las condiciones de pago." />
                        </div>

                        <div class="col-lg-4">
                            <label for="moneda_preferida" class="form-label">Moneda Preferida</label>
                            <select name="moneda_preferida" id="moneda_preferida" class="form-select form-select-sm">
                                <option value="">Seleccionar</option>
                                <option value="PEN">PEN - Soles</option>
                                <option value="USD">USD - Dólares</option>
                                <option value="EUR">EUR - Euros</option>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="calificacion" class="form-label">Calificación (1-5)</label>
                            <input type="number" id="calificacion" name="calificacion" class="form-control form-control-sm" 
                                   min="1" max="5" title="Calificación del proveedor." />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="7">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="register-proveedor-btn">Registrar Proveedor</button>
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
                            <input type="hidden" name="actions" value="9">
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
            "ajax": "index.php?action=proveedores&actions=1",
            "columns": [
                { "data": "ruc" },
                { "data": "nombre" },
                { "data": "telefono" },
                { "data": "email" },
                { "data": "categoria" },
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
                url: 'index.php?action=proveedores&actions=2',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    $('#edit_id').val(response.id);
                    $('#ruc').val(response.ruc);
                    $('#nombre').val(response.nombre);
                    $('#telefono').val(response.telefono);
                    $('#email').val(response.email);
                    $('#sitio_web').val(response.sitio_web);
                    $('#direccion').val(response.direccion);
                    $('#ciudad').val(response.ciudad);
                    $('#pais').val(response.pais);
                    $('#categoria').val(response.categoria);
                    $('#condiciones_pago').val(response.condiciones_pago);
                    $('#moneda_preferida').val(response.moneda_preferida);
                    $('#calificacion').val(response.calificacion);
                    $('#estado').prop('checked', response.estado == 1);
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