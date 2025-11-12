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
                <h6 class="card-title text-white mb-0">Gestión de Usuario</h6>
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
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Titulo</th>
                            <th>Descripcion</th>
                            <th>Imagen</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                            <th>Tipoanuncio</th>
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
                <h5 class="modal-title" id="userModalLabel">Editar anuncio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="user-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-4">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="number"  id="dni" name="dni" class="form-control form-control-sm" required />
                        </div>
                        <div class="col-lg-8">
                            <label for="nombre" class="form-label">nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required 
                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                                   title="El nombre solo debe contener letras y espacios." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="" class="form-label">titulo</label>
                            <input type="text" id="titulo" name="titulo" class="form-control form-control-sm" required 
                                   title="Por favor ponga los titulo." />
                        </div>

                        <div class="col-lg-12">
                            <label for="email" class="form-label">descripcion</label>
                            <input type="descripcion" id="descripcion" name="descripcion" class="form-control form-control-sm" requiered
                                   title="Por favor ingrese la descripcion." />
                        </div>

                        <div class="col-lg-6">
                            <label for="imagen" class="form-label">imagen</label>
                            <input type="text" id="imagen" name="imagen" class="form-control form-control-sm" requiered
                                   title="Por favor ingrese la imagen." />
                        </div>
                        <div class="col-lg-6">
                            <label for="inicio" class="form-label">inicio</label>
                            <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" requiered
                                <input type="checkbox" name="inicio" id="inicio">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label for="estado" class="form-label">fin</label>
                            <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" requiered
                                <input type="checkbox" name="estado" id="estado">
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <label for="estado" class="form-label">estado</label>
                            <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" requiered
                                <input type="checkbox" name="estado" id="estado">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label for="tipoanuncio" class="form-label">tipoanuncio</label>
                            <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" requiered
                                <input type="checkbox" name="tipoanuncio" id="tipoanuncio">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label for="cargos" class="form-label">Cargos</label>
                            <select name="cargos" id="cargos" class="form-select form-select-sm" required 
                                    title="Por favor, seleccione el cargos del usuario.">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $cargos1 = CargoData::vercontenido();
                                 foreach ($cargos1 as $cg) { ?>
                                    <option value="<?= $cg->id; ?>"><?= $cg->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <hr>
                        <div class="col-lg-6">
                            <label for="negocio" class="form-label">Usuario</label>
                            <input type="text" id="usuario" name="usuario" class="form-control form-control-sm"/>                            
                        </div>
                        <div class="col-lg-6">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="2">
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
                <h5 class="modal-title" id="userModalLabel">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="user-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-4">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="number"  id="dni" name="dni" class="form-control form-control-sm" required />
                        </div>
                        <div class="col-lg-8">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required 
                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                                   title="El nombre solo debe contener letras y espacios." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="apellido" class="form-label">Apellidos</label>
                            <input type="text" id="apellido" name="apellido" class="form-control form-control-sm" required 
                                   title="Por favor ingrese los apellidos." />
                        </div>

                        <div class="col-lg-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm" 
                                   title="Por favor ingrese el correo." />
                        </div>

                        <div class="col-lg-12">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" 
                                   title="Por favor ingrese el telefono." />
                        </div>
                        
                        <div class="col-lg-6">
                            <label for="cargos" class="form-label">Cargos</label>
                            <select name="cargos" id="cargos" class="form-select form-select-sm" required 
                                    title="Por favor, seleccione el cargos del usuario.">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $cargos1 = CargoData::vercontenido();
                                 foreach ($cargos1 as $cg) { ?>
                                    <option value="<?= $cg->id; ?>"><?= $cg->nombre; ?></option>
                                <?php } ?>
                            </select>
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
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="1">
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
                        <p class="text-muted fs-14 mb-4 pt-1">Dejará de existir la toda infomación de la base  de datos</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <input type="hidden" name="actions" value="3">
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
            "ajax": "index.php?action=anuncio&actions=1",
            "columns": [
                { "data": "dni" },
                { "data": "nombre" },
                { "data": "email" },
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
        $('#mitabla').on('click', '.edit-btn', function(){
            var id = $(this).data('id');
            $.ajax({
                url: 'index.php?action=anuncio&actions=2',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    $('#edit_id').val(response.id);
                    $('#dni').val(response.dni);
                    $('#nombre').val(response.nombre);
                    $('#apellido').val(response.apellido);
                    $('#email').val(response.email);
                    $('#cargos').val(response.cargos);
                    $('#telefono').val(response.telefono);
                    $('#negocio').val(response.negocio);
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
