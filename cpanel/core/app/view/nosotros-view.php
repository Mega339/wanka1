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
                <h6 class="card-title text-white mb-0">Gestión de Nosotros</h6>
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

                            <th>Titulo</th>
                            <th>Descripcion</th>
                            <th>Mision</th>
                            <th>Vision</th>
                            <th>Valores</th>
                            <th>Acciones</th> 						
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
            <div class="modal-header bg-light p-25">
                <h5 class="modal-title" id="negocioModalLabel">Editar Nosotros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="negocio-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-4">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" id="titulo_edit" name="titulo" class="form-control form-control-sm" required 
                                   maxlength="20" title="Por favor ingrese el titulo." />
                        </div>
                        <div class="col-lg-8">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" id="descripcion_edit" name="descripcion" class="form-control form-control-sm" required 
                                   maxlength="150" title="Por favor ingrese la descripcion." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="mision" class="form-label">Mision</label>
                            <input type="text" id="mision_edit" name="mision" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese la direccion." />
                        </div>

                        <div class="col-lg-6">
                            <label for="vision" class="form-label">Vision</label>
                            <input type="text" id="vision" name="vision" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese el representante." />
                        </div>

                        <div class="col-lg-6">
                            <label for="valores" class="form-label">Valores</label>
                            <input type="text" id="valores" name="correo" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese el correo." />
                        </div>

                        <div class="col-lg-12">
                            <label for="Imagen_portada" class="form-label">Imagen_portada</label>
                            <input type="file" id="logo_edit" name="Imagen_portada" class="form-control form-control-sm" 
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
                        <input type="hidden" name="actions" value="38">
                        <input type="hidden" name="id" id="edit_id">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="update-negocio-btn">Actualizar Nosotros</button>
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
                <h5 class="modal-title" id="negocioModalLabel">Nuevo Nosotros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            						
            <form enctype="multipart/form-data" method="POST" class="negocio-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-8">
                            <label for="titulo" class="form-label">titulo </label>
                            <input type="text" id="titulo" name="titulo" class="form-control form-control-sm" required 
                                   maxlength="150" title="Por favor ingrese el titulo." />
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="descripcion" class="form-label">descripcion</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese la descripcion." />
                        </div>

                        <div class="col-lg-6">
                            <label for="mision" class="form-label">mision</label>
                            <input type="text" id="mision" name="mision" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese la mision." />
                        </div>

                        <div class="col-lg-6">
                            <label for="vision" class="form-label">vision</label>
                            <input type="text" id="vision_" name="vision" class="form-control form-control-sm" 
                                   maxlength="255" title="Por favor ingrese la vision ." />
                        </div>

                        <div class="col-lg-6">
                            <label for="valores" class="form-label">valores</label>
                            <input type="text" id="valores" name="valores" class="form-control form-control-sm" 
                                   maxlength="20" title="Por favor ingrese el valores." />
                        </div>

                        <div class="col-lg-12">
                            <label for="imagen" class="form-label">imagen_portada</label>
                            <input type="file" id="imagen" name="imagen" class="form-control form-control-sm" 
                                   accept="image/*" title="Seleccione una imagen para el logo." />
                        </div>

                        <div class="col-lg-12">
                            <div id="preview" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="37">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="register-negocio-btn">Registrar</button>
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
                            <input type="hidden" name="actions" value="39">
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
            "ajax": "index.php?action=nosotros&actions=1",
            "columns": [
                
                { "data": "titulo" },
                { "data": "descripcion" },
                { "data": "mision" },
                { "data": "vision" },
                { "data": "valores" },
                
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
                url: 'index.php?action=nosotros&actions=2',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    $('#edit_id').val(response.id);
                    $('#titulo_edit').val(response.titulo);
                    $('#descripcion_edit').val(response.descripcion);
                    $('#mision_edit').val(response.mision);
                    $('#vision').val(response.vision);
                    $('#valores').val(response.valores);
                    $('#imagen_portada_edit').val(response.imagen);
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