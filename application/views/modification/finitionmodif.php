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
            <h6>Formulaire</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="card z-index-0">
                <div class="card-header text-center pt-4">
                    <h5>Modifier les pourcentages des fintions</h5>
                </div>
                        <?php echo validation_errors('<div class="error">', '</div>'); ?>
                        <form action="<?php echo base_url("ModificationController/ModifierFinition") ?>" method="post">
                            <div class="card-body">
                                <input type="hidden" name="idfinition" value="<?php echo $idfinition ?>">
                                <div class="mb-3">
                                    <label for="name">Pourcentage:</label>
                                    <input type="text" class="form-control" name="pourcentage" id="pourcentage" value="<?php echo $pourcentage; ?><?php if(validation_errors()) : ?><?php echo set_value('pourcentage', $this->session->userdata('current_client')); ?><?php endif; ?>">
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