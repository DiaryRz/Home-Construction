<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details du devis</title>
</head>
<body>
    <table border="1px">
        <tr>
            <th>Numero</th>
            <th>Designation</th>
            <th>Unite</th>
            <th>Quantite</th>
            <th>PrixUnitaire</th>
            <th>Total</th>
        </tr>

        <tr>
            <?php foreach ($detailsdevis as $devis) { ?>
                <td><?php echo $devis->numerotravaux  ?></td>
                <td><?php echo $devis->nomtypetravaux   ?></td>
                <td><?php echo $devis->nomunite  ?></td>
                <td><?php echo $devis->quantite  ?></td>
            <?php } ?>
        </tr>
    </table>
</body>
</html>