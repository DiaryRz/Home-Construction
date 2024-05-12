<div class="row">
    <div class="col-12">
        <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Nettoyage des données</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="card z-index-0">

                    <form action="<?php echo base_url("NettoyerBaseController/nettoyer") ?>" method="post">
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2" name="submit" value="Nettoyer les donnees">
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>