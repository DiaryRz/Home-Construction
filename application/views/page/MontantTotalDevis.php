<div class="row">
    <div class="col-12">
        <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Montant totale</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="card z-index-0">
                <div class="card-header text-center pt-4">
                    <?php if($montant != null) { ?>
                        <h6>Le montant total des devis est de <?php echo number_format($montant->montant, 2, ',', ' ' );  ?></h6>
                    <?php } else{?>
                        <h6>Le montant total des devis est de 0</h6>
                    <?php } ?>

                    <?php echo "----".$prixdejapayer->prixdejapayer ?>
                    <?php if($prixdejapayer->prixdejapayer) { ?>
                        <h6>Le montant total des devis deja payer est de <?php echo number_format($prixdejapayer->prixdejapayer, 2, ',', ' ' ); ?></h6>
                    <?php } else{?>
                        <h6>Le montant total des devis deja payer est de 0</h6>
                    <?php } ?>
            
                </div>
            </div>
        </div>
    </div>
</div>