<div class="row">
    <div class="col-12">
        <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Formulaire de modification</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="card z-index-0">
                <div class="card-header text-center pt-4">
                    <h5>Modification des travaux</h5>
                </div>

                        <?php echo validation_errors(); ?>
                        <form action="<?php echo base_url('ModificationController/modifierLeTravaux') ?>" method="post">
                            <div class="card-body">
                                <div>
                                    <input type="hidden" name="idtravaux" value="<?php echo $default['idtravaux'] ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="name">Numero du travail:</label>
                                    <input type="number" class="form-control" name="numerotravaux" id="name" value="<?php echo $default['numerotravaux'] ?>" min="0"  required>
                                </div>

                                <div class="mb-3">
                                    <label for="name">Designation:</label>
                                    <input type="text" class="form-control" name="nomtypetravaux" id="name" value="<?php echo $default['nomtypetravaux'] ?>"  required>
                                </div>

                                <div class="mb-3">
                                    <label for="name">Prix Unitaire:</label>
                                    <input type="text" class="form-control" name="prixunitaire" id="name" value="<?php echo $default['prixunitaire'] ?>" pattern="[0-9]+" title="Le nombre doit être supérieur à zéro" required>
                                </div>

                                <div class="mb-3">
                                    <input type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2" name="submit" value="Submit">
                                </div>
                            </div>
                        </form>
                
            </div>
        </div>
    </div>
</div>