<?php
/**
 * @var array $header
 * @var array $data
 */
?>

<div class="page-header">
    <h1>Dashboard</h1>
</div>
<div class="row">

</div>
<table class="table table-striped table-condensed">
    <thead> <!-- En-tête du tableau -->
    <tr>
        <th>Catégorie</th>
        <th>Année en cours</th>
        <?php foreach($header as $row):?>
        <th class="text-center"><?php echo $row;?></th>
        <?php endforeach;?>
    </tr>
    </thead>

    <tfoot> <!-- Pied de tableau -->
    <tr>
        <th><strong>Total</strong></th>
        <th class="text-center"><?php echo number_format($total['year'], 2);?></th>
        <?php foreach($total['month'] as $amount):?>
            <th class="text-center <?php echo intval( $amount) > $total['year'] ? 'success':'danger';?>" ><strong><?php echo $amount;?></strong></th>
        <?php endforeach;?>
    </tr>
    </tfoot>

    <tbody> <!-- Corps du tableau -->
    <?php foreach ( $data as $row): ?>
    <tr>
        <td><?php echo $row['label'];?></td>
        <td class="text-center"><?php echo $row['current'];?></td>
        <?php foreach($row['month'] as $amount):?>
        <td class="text-center <?php echo intval( $amount) > $row['yearAmount'] ? 'success':'danger';?>" ><?php echo $amount;?></td>
        <?php endforeach;?>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>