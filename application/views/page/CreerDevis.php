<style>
    .error {
        margin-left:2%;
        border: 2px solid darkred;
        background-color: #ffcccc; 
        color: black;
        padding: 10px; 
        border-radius: 5px;
        width: fit-content; 
    }
</style> 

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Formulaire d'insertion</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="card z-index-0">
                <div class="card-header text-center pt-4">
                    <h5>Creer devis</h5>
                </div>
                        <?php echo validation_errors('<div class="error">', '</div>'); ?>
                        <form action="<?php echo base_url("DevisClientController/Inserer") ?>" method="post">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name">Identifiant du devis:</label>
                                    <input type="text" class="form-control" name="ref_devis" id="ref_devis" <?php if(validation_errors()) : ?> value="<?php echo set_value('ref_devis', $this->session->userdata('current_client')); ?>" <?php endif; ?>>
                                </div>
                                <div class="mb-3">
                                    <label for="name">Lieu de construction:</label>
                                    <select name="lieu" id="lieu" class="form-control">
                                        <?php foreach ($listelieu as $lieu) { ?>
                                            <option value="<?php echo $lieu->idlieu ?>"><?php echo $lieu->nomlieu ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name">Date de debut de construction:</label>
                                    <input type="date" class="form-control" name="date" id="date" <?php if(validation_errors()) : ?> value="<?php echo set_value('date', $this->session->userdata('current_client')); ?>" <?php endif; ?>>
                                </div>
                                <div>
                                    <div class="row">
                                        <label for="file1">Type de maison:</label>
                                        <?php for($i = 0 ; $i < count($listetypemaison) ; $i++) { ?>
                                            <div class="col-md-5">
                                                <input type="radio" value="<?php echo $listetypemaison[$i]->idtypemaison ?>" name="typemaison" <?php if(validation_errors()) : ?> <?php echo set_checkbox('typemaison', $listetypemaison[$i]->idtypemaison ) ?> <?php endif; ?> required>
                                                <?php echo $listetypemaison[$i]->nomtypemaison ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div>
                                    <div class="row">
                                        <label for="file1">Type de finition:</label>
                                        <?php for($i = 0 ; $i < count($listetypefinition) ; $i++) { ?>
                                            <div class="col-md-5">
                                                <input type="radio" value="<?php echo $listetypefinition[$i]->idtypefinition ?>" name="typefinition" <?php if(validation_errors()) : ?> <?php echo set_checkbox('typefinition', $listetypefinition[$i]->idtypefinition ) ?> <?php endif; ?> required>
                                                <?php echo $listetypefinition[$i]->nomfinition ?>
                                            </div>
                                        <?php } ?>
                                    </div>
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