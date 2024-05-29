<style>
    .pagination {
        margin: 20px 0;
        text-align: center;
    }
    .pagination a, .pagination .current , .pagination strong {
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        color: #333;
        text-decoration: none;
    }
    .pagination a:hover {
        background-color: #e5e5e5;
    }
    .pagination .current {
        background-color: #007bff;
        color: #fff;
    }
    #recherche{
        text-align:center;
    }

</style>



<link rel="stylesheet" href="<?php echo base_url("assets/csstrier/jquerytable.js") ?>">
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

<form action="<?php echo base_url("ListeController/recherche") ?>" method="get">
    <input type="text" name="textearechercher">
    <input type="submit" value="Valider">
</form>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Information</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table id="authorsTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Numero du de travaux</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Designation</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unite</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantite</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prix Unitaire</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prix totale</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0 ?>
                            <?php if($listedevis != null) { ?>
                                <?php foreach ($listedevis as $devis): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p style="text-align: right;" class="text-xs text-secondary mb-0"><?php echo number_format($devis->numerotravaux); ?></p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-secondary mb-0"><?php echo $devis->nomtypetravaux ?></p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-secondary mb-0"><?php echo $devis->nomunite ?></p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p style="text-align: right;" class="text-xs text-secondary mb-0"><?php echo number_format($devis->quantite, 2, ',', ' ' ); ?></p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p style="text-align: right;"
                                                 class="text-xs text-secondary mb-0"><?php echo number_format($devis->prixunitaire, 2, ',', ' ' ); ?></p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p style="text-align: right;" class="text-xs text-secondary mb-0"><?php echo number_format($devis->totalprixdevis, 2, ',', ' ' ); ?></p>
                                        </td>
                                    </tr>
                                    <?php $total = $devis->totalprixdevis ?>
                                <?php endforeach; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <h6 style="text-align:right;">Total prix : <?php echo $total ?></h6>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="<?php echo base_url("assets/csstrier/jquery.js") ?>"></script> 
<!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
<script src="<?php echo base_url("assets/csstrier/jquerydatatablemin.js") ?>"></script>
<script>
    $(document).ready(function() {
        $('#authorsTable').DataTable({
            "ordering": true, 
            "paging": false, 
            "info": false, 
            "searching": false
        });
    });
</script>
