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
                    <h5>Formulaire</h5>
                </div>

                        <?php echo validation_errors('<div class="error">', '</div>'); ?>
                        <form action="<?php echo base_url("DevisClientController/Payer") ?>" method="post">
                            <div class="card-body">
                                <input type="hidden" name="iddevis" value="<?php echo $iddevis ?>">
                                <div class="mb-3">
                                    <label for="name">Date de paiement:</label>
                                    <input type="date" class="form-control" name="date" id="date" <?php if(validation_errors()) : ?> value="<?php echo set_value('date', $this->session->userdata('current_client')); ?>" <?php endif; ?>>
                                </div>
                                <div class="mb-3">
                                    <label for="name">Montant:</label>
                                    <input type="text" class="form-control" name="montant" id="montant" <?php if(validation_errors()) : ?> value="<?php echo set_value('montant', $this->session->userdata('current_client')); ?>" <?php endif; ?>>
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

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var montantInput = document.getElementById('montant');
        montantInput.addEventListener('change', function () {
            var montant = parseFloat(this.value);
            var iddevis = document.querySelector('input[name="iddevis"]').value;
            var errorElement = document.querySelector('.error');

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo base_url("DevisClientController/VerifierMontant") ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        errorElement.textContent = response.error;
                        errorElement.style.display = 'block';
                    } else {
                        errorElement.textContent = '';
                        errorElement.style.display = 'none';
                    }
                }
            };
            xhr.send('iddevis=' + iddevis + '&montant=' + montant);
        });
    });

</script> -->