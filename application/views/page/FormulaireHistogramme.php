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
                    <h5>Entrer l'année pour voir les statistiques:</h5>
                </div>
                    <?php echo validation_errors('<div class="error">', '</div>'); ?>
                    <form action="<?php echo base_url("DevisAdminController/ChartParMois") ?>" method="post">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name">Date de debut de construction:</label>
                                <input type="text" class="form-control" name="annee" id="date" <?php if(validation_errors()) : ?> value="<?php echo set_value('date', $this->session->userdata('current_client')); ?>" <?php endif; ?> required>
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