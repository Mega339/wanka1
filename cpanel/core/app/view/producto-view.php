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
                <h6 class="card-title text-white mb-0">Gestión de Productos</h6>
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
                            <th>nombre</th>
                            <th>stock</th>
                            <th>precio_base</th>
                            <th>precio_oferta</th>
                            <th>codigo</th>
                            <th>descripcion</th>
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
                <h5 class="modal-title" id="negocioModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="negocio-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-4">
                            <label for="negocio" class="form-label">Negocio</label>
                            <select name="negocio" id="negocio" class="form-select form-select-sm" required>
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $negocios = NegocioData::vercontenido();
                                foreach ($negocios as $n) { ?>
                                    <option value="<?= $n->id; ?>"><?= $n->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="tipomaterial" class="form-label">Tipo de Material</label>
                            <select name="tipomaterial" id="tipomaterial" class="form-select form-select-sm" required>
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $tipos = TipomaterialData::vercontenido();
                                foreach ($tipos as $t) { ?>
                                    <option value="<?= $t->id; ?>"><?= $t->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="form-check form-switch form-switch-lg">
                                <input type="checkbox" name="estado" id="estado" class="form-check-input">
                            </div>
                        </div>

                        <!-- 🔹 Grupo 2: Datos generales -->
                        <div class="col-lg-6">
                            <label for="nombre" class="form-label">Nombre del producto</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-lg-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control form-control-sm">
                        </div>

                        <!-- 🔹 Grupo 3: Información técnica -->
                        <div class="col-lg-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" id="modelo" name="modelo" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" id="color" name="color" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="dimensiones" class="form-label">Dimensiones</label>
                            <input type="text" id="dimensiones" name="dimensiones" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" id="codigo" name="codigo" class="form-control form-control-sm">
                        </div>

                        <!-- 🔹 Grupo 4: Atributos adicionales -->
                        <div class="col-lg-3">
                            <label for="garantia" class="form-label">Garantía (meses)</label>
                            <input type="number" id="garantia" name="garantia" class="form-control form-control-sm" min="0">
                        </div>

                        <div class="col-lg-3">
                            <label for="serie" class="form-label">Serie</label>
                            <input type="text" id="serie" name="serie" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="talla" class="form-label">Talla</label>
                            <input type="text" id="talla" name="talla" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="par" class="form-label">Par</label>
                            <input type="text" id="par" name="par" class="form-control form-control-sm">
                        </div>

                        <!-- 🔹 Grupo 5: Precios y stock -->
                        <div class="col-lg-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" id="stock" name="stock" class="form-control form-control-sm" min="0">
                        </div>

                        <div class="col-lg-3">
                            <label for="precio_base" class="form-label">Precio Base (S/)</label>
                            <input type="number" id="precio_base" name="precio_base" class="form-control form-control-sm" step="0.01" min="0">
                        </div>

                        <div class="col-lg-3">
                            <label for="precio_oferta" class="form-label">Precio Oferta (S/)</label>
                            <input type="number" id="precio_oferta" name="precio_oferta" class="form-control form-control-sm" step="0.01" min="0">
                        </div>

                        <div class="col-lg-3">
                            <label for="peso" class="form-label">Peso (kg)</label>
                            <input type="number" id="peso" name="peso" class="form-control form-control-sm" step="0.01" min="0">
                        </div>

                        <!-- 🔹 Grupo 6: Materiales y fecha -->
                        <div class="col-lg-6">
                            <label for="materiales" class="form-label">Materiales</label>
                            <input type="text" id="materiales" name="materiales" class="form-control form-control-sm">
                        </div>

                        <!-- 🔹 Grupo 7: Imagen -->
                        <div class="col-lg-12">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" id="imagen" name="imagen" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted">Deje vacío si no desea cambiar la imagen</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="32">
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
                <h5 class="modal-title" id="negocioModalLabel">Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="negocio-form" autocomplete="off" action="index.php?action=registro">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-lg-4">
                            <label for="negocio" class="form-label">Negocio</label>
                            <select name="negocio" id="negocio" class="form-select form-select-sm" required>
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $negocios = NegocioData::vercontenido();
                                foreach ($negocios as $n) { ?>
                                    <option value="<?= $n->id; ?>"><?= $n->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="tipomaterial" class="form-label">Tipo de Material</label>
                            <select name="tipomaterial" id="tipomaterial" class="form-select form-select-sm" required>
                                <option value="" selected>Seleccionar</option>
                                <?php
                                $tipos = TipomaterialData::vercontenido();
                                foreach ($tipos as $t) { ?>
                                    <option value="<?= $t->id; ?>"><?= $t->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="form-check form-switch form-switch-lg">
                                <input type="checkbox" name="estado" id="estado" class="form-check-input">
                            </div>
                        </div>

                        <!-- 🔹 Grupo 2: Datos generales -->
                        <div class="col-lg-6">
                            <label for="nombre" class="form-label">Nombre del producto</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-lg-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control form-control-sm">
                        </div>

                        <!-- 🔹 Grupo 3: Información técnica -->
                        <div class="col-lg-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" id="modelo" name="modelo" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" id="color" name="color" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="dimensiones" class="form-label">Dimensiones</label>
                            <input type="text" id="dimensiones" name="dimensiones" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" id="codigo" name="codigo" class="form-control form-control-sm">
                        </div>

                        <!-- 🔹 Grupo 4: Atributos adicionales -->
                        <div class="col-lg-3">
                            <label for="garantia" class="form-label">Garantía (meses)</label>
                            <input type="number" id="garantia" name="garantia" class="form-control form-control-sm" min="0">
                        </div>

                        <div class="col-lg-3">
                            <label for="serie" class="form-label">Serie</label>
                            <input type="text" id="serie" name="serie" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="talla" class="form-label">Talla</label>
                            <input type="text" id="talla" name="talla" class="form-control form-control-sm">
                        </div>

                        <div class="col-lg-3">
                            <label for="par" class="form-label">Par</label>
                            <input type="text" id="par" name="par" class="form-control form-control-sm">
                        </div>

                        <!-- 🔹 Grupo 5: Precios y stock -->
                        <div class="col-lg-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" id="stock" name="stock" class="form-control form-control-sm" min="0">
                        </div>

                        <div class="col-lg-3">
                            <label for="precio_base" class="form-label">Precio Base (S/)</label>
                            <input type="number" id="precio_base" name="precio_base" class="form-control form-control-sm" step="0.01" min="0">
                        </div>

                        <div class="col-lg-3">
                            <label for="precio_oferta" class="form-label">Precio Oferta (S/)</label>
                            <input type="number" id="precio_oferta" name="precio_oferta" class="form-control form-control-sm" step="0.01" min="0">
                        </div>

                        <div class="col-lg-3">
                            <label for="peso" class="form-label">Peso (kg)</label>
                            <input type="number" id="peso" name="peso" class="form-control form-control-sm" step="0.01" min="0">
                        </div>

                        <!-- 🔹 Grupo 6: Materiales y fecha -->
                        <div class="col-lg-6">
                            <label for="materiales" class="form-label">Materiales</label>
                            <input type="text" id="materiales" name="materiales" class="form-control form-control-sm">
                        </div>

                        <!-- 🔹 Grupo 7: Imagen -->
                        <div class="col-lg-12">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" id="imagen" name="imagen" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted">Deje vacío si no desea cambiar la imagen</small>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <input type="hidden" name="actions" value="31">
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
                            <input type="hidden" name="actions" value="33">
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
    $(document).ready(function() {
        $('#mitabla').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "index.php?action=producto&actions=1",
            "columns": [{
                    "data": "nombre",
                },
                {
                    "data": "stock"
                },
                {
                    "data": "precio_base"
                },
                {
                    "data": "precio_oferta"
                },
                {
                    "data": "codigo"
                },
                {
                    "data": "descripcion"
                },
                {
                    "data": "estado",
                    "render": function(data, type, row) {
                        return data === 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                    }
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
                url: 'index.php?action=producto&actions=2',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {

                    $('#edit_id').val(response.id);
                    $('#negocio').val(response.negocio);
                    $('#tipomaterial').val(response.tipomaterial);
                    $('#modelo').val(response.modelo);
                    $('#color').val(response.color);
                    $('#dimensiones').val(response.dimensiones);
                    $('#nombre').val(response.nombre);
                    $('#codigo').val(response.codigo);
                    $('#serie').val(response.serie);
                    $('#talla').val(response.talla);
                    $('#par').val(response.par);
                    $('#peso').val(response.peso);
                    $('#materiales').val(response.materiales);
                    $('#descripcion').val(response.descripcion);
                    $('#precio_base').val(response.precio_base);
                    $('#precio_oferta').val(response.precio_oferta);
                    $('#stock').val(response.stock);
                    $('#garantia').val(response.garantia);
                    $('#estado').prop('checked', response.estado == 1);
                    if (response.imagen && response.imagen !== '') {
                        $('#imagen').html(`
                    <img src="storage/archivo/${response.imagen}" width="150" class="img-thumbnail">
                    <br><small class="text-muted">Imagen actual</small>`);
                    } else {
                        $('#imagen').html('<span class="badge bg-secondary">Sin imagen</span>');
                    }
                    $('#MEditar').modal('show');
                },
                error: function() {
                    alert('Error al obtener los datos del producto.');
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