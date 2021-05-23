<div class="modal fade bd-example-modal-lg" id="crear_examenModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Examen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Tipo exámen</label>
                                <select class="form-control" name="" id="examen_id">
                                    <option value="" selected disabled> Seleccionar</option>
                                    <?php
                                    foreach (ExamenControlador::getAll() as $examen){
                                        echo '<option value="'. $examen->getIdExamenes().'">'.strtoupper($examen->getNombre()).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row examenes" id="agudeza_visual" style="display: none">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">OD</label>
                                <input type="text" class="form-control" name="OD" required placeholder="Ojo derecho">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">OI</label>
                                <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="last_name">Observaciones</label>
                                <textarea class="form-control" name="observaciones" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row examenes" id="examen_externo" style="display:none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">OD</label>
                                <input type="text" class="form-control" name="OD" required placeholder="Ojo derecho">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">OI</label>
                                <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                            </div>
                        </div>
                    </div>
                    <div class="row examenes" id="fondo_de_ojo" style="display: none">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">OD</label>
                                <input type="text" class="form-control" name="OD" required placeholder="Ojo derecho">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">OI</label>
                                <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="last_name">Descripcion fondo de ojo</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">OI</label>
                                <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">OI</label>
                                <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                            </div>
                        </div>
                    </div>

                    <div class="row examenes" id="motildiad_ocular" style="display: none">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">CVT VL</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">CVT VP</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">PPC</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">PIO OD</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">PIO OI</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Tipo</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row examenes" id="queratometria" style="display: none">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="last_name">OD</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="last_name">OI</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="last_name">MIRAS</label>
                                        <input type="text" class="form-control" name="OI" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row examenes" id="refraccion" style="display: none">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">OD</label>
                                        <input type="text" class="form-control" name="OD" required placeholder="Ojo izquierdo">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">OI</label>
                                        <input type="text" class="form-control" name="OD" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">AV OD</label>
                                        <input type="text" class="form-control" name="OD" required placeholder="Ojo izquierdo">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">AV OI</label>
                                        <input type="text" class="form-control" name="OD" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row examenes" id="sujetivo" style="display: none">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">OD</label>
                                        <input type="text" class="form-control" name="OD" required placeholder="Ojo izquierdo">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">OI</label>
                                        <input type="text" class="form-control" name="OD" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">ADD OD</label>
                                        <input type="text" class="form-control" name="OD" required placeholder="Ojo izquierdo">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">ADD OI</label>
                                        <input type="text" class="form-control" name="OD" required placeholder="Ojo izquierdo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>