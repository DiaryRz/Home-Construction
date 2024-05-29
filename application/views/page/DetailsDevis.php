<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details du devis</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Détails de devis:</h1>
    <?php $total = 0; ?>
    <table>
        <tr>
            <th>Numero</th>
            <th>Designation</th>
            <th>Unite</th>
            <th>Quantite</th>
            <th>PrixUnitaire</th>
        </tr>

        <?php foreach ($detailsdevis as $devis) { ?>
            <tr>
                <td><?php echo $devis->numerotravaux  ?></td>
                <td><?php echo $devis->nomtypetravaux   ?></td>
                <td><?php echo $devis->nomunite  ?></td>
                <td><?php echo $devis->quantite  ?></td>
                <td><?php echo $devis->prixunitaire  ?></td>
                <?php $total = $total+($devis->prixunitaire*$devis->quantite) ?>
            </tr>
        <?php } ?>
    </table>
    <div><h5 style="text-align:right;">Montant total du devis:<?php echo $total ?></h5></div>
</body>
</html>
