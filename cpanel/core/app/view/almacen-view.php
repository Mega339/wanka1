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
                <h6 class="card-title text-white mb-0">Gestión de Almacen</h6>
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
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Capacidad</th>
                            <th>Tipo Almacen</th>
                            <th>Estado</th>
                            <th>Fecha</th>
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
                <h5 class="modal-title" id="userModalLabel">Editar Almacen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="user-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required 
                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                                   title="El nombre solo debe contener letras y espacios." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" id="ubicacion" name="ubicacion" class="form-control form-control-sm" required 
                                   title="Por favor ingrese los apellidos." />
                        </div>
                        
                         <div class="col-lg-6">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="number" id="telefono" name="telefono" class="form-control form-control-sm" 
                                   title="Por favor ingrese el telefono." />
                        </div>

                        <div class="col-lg-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm" 
                                   title="Por favor ingrese el correo." />
                        </div>
                        <div class="col-lg-12">
                            <label for="tipo_almacen" class="form-label">Tipo Almacen</label>
                            <input type="text" id="tipo_almacen" name="tipo_almacen" class="form-control form-control-sm" 
                                   title="Por favor ingrese el correo." />
                        </div>

                       
                       <div class="col-lg-6">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="form-check form-switch form-switch-lg">
                                <input type="checkbox" name="estado" id="estado">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="capacidad" class="form-label">Capacidad</label>
                            <input type="number" id="capacidad" name="capacidad" class="form-control form-control-sm" required 
                                   title="Por favor ingrese los apellidos." />
                        </div>
                        <div class="col-lg-12">
                            <label for="fecha" class="form-label">Fecha y hora</label>
                            <input type="datetime-local" id="fecha" name="fecha" class="form-control form-control-sm" required
                                title="Por favor seleccione la fecha y hora." />
                        </div>


                    </div>
                </div>  
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="17">
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
                <h5 class="modal-title" id="userModalLabel">Nuevo Almacen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="user-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required 
                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                                   title="El nombre solo debe contener letras y espacios." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" id="ubicacion" name="ubicacion" class="form-control form-control-sm" required 
                                   title="Por favor ingrese los apellidos." />
                        </div>
                        
                         <div class="col-lg-6">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="number" id="telefono" name="telefono" class="form-control form-control-sm" 
                                   title="Por favor ingrese el telefono." />
                        </div>

                        <div class="col-lg-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm" 
                                   title="Por favor ingrese el correo." />
                        </div>
                        <div class="col-lg-12">
                            <label for="tipo_almacen" class="form-label">Tipo Almacen</label>
                            <input type="text" id="tipo_almacen" name="tipo_almacen" class="form-control form-control-sm" 
                                   title="Por favor ingrese el correo." />
                        </div>
                        <div class="col-lg-12">
                            <label for="capacidad" class="form-label">Capacidad</label>
                            <input type="number" id="capacidad" name="capacidad" class="form-control form-control-sm" required 
                                   title="Por favor ingrese los apellidos." />
                        </div>
                        <div class="col-lg-12">
                            <label for="fecha" class="form-label">Fecha y hora</label>
                            <input type="datetime-local" id="fecha" name="fecha" class="form-control form-control-sm" required
                            title="Por favor seleccione la fecha y hora." />
                        </div>

                        
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="16">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="register-user-btn">Registrar Almacen</button>
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
                            <input type="hidden" name="actions" value="18">
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
    $(document).ready(function(){
        $('#mitabla').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=almacen&actions=1",
            "columns": [
                { "data": "nombre" },
                { "data": "ubicacion" },
                { "data": "telefono" },
                { "data": "email" },
                { "data": "capacidad" },
                { "data": "tipo_almacen" },
                { 
                    "data": "estado",
                    "render": function (data, type, row) {
                        return data === 'ACTIVO' 
                            ? '<span class="badge bg-success">Activo</span>' 
                            : '<span class="badge bg-danger">Inactivo</span>';
                    }
                },
                { "data": "fecha" },
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
                url: 'index.php?action=almacen&actions=2',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    $('#edit_id').val(response.id);
                    $('#nombre').val(response.nombre)
                    $('#ubicacion').val(response.ubicacion);
                    $('#telefono').val(response.telefono);
                    $('#email').val(response.email);
                    $('#cargos').val(response.cargos);
                    $('#capacidad').val(response.capacidad);
                    $('#tipo_almacen').val(response.tipo_almacen);
                    $('#observaciones').val(response.observaciones);
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