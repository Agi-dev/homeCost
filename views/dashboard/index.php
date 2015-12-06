<?php
/**
 * @var array $header
 * @var array $data
 * @var array $total
 */
use yii\helpers\Url;

?>

<div class="page-header">
    <h1>Dashboard</h1>
</div>
<table class="table table-striped table-condensed table-bordered">
    <thead> <!-- En-tête du tableau -->
    <tr>
        <th>Catégorie</th>
        <th class="text-center"><a href="<?php echo Url::to(['dashboard/detail', 'year' => date('Y')]); ?>" target="_blank">Année
                en cours</a></th>
        <?php foreach ($header as $m => $row): ?>
            <th class="text-center"><a href="<?php echo Url::to(['dashboard/detail', 'month' => $m]); ?>"
                                       target="_blank"><?php echo $row; ?></a></th>
        <?php endforeach; ?>
    </tr>
    </thead>

    <tfoot> <!-- Pied de tableau -->
    <tr>
        <th class="text-right"><strong>Total</strong></th>
        <th class="text-center"><?php echo number_format($total['year'], 2); ?></th>
        <?php foreach ($total['month'] as $amount): ?>
            <th class="text-center <?php echo intval($amount) > $total['year'] ? 'success' : 'danger'; ?>">
                <strong><?php echo $amount; ?></strong></th>
        <?php endforeach; ?>
    </tr>
    </tfoot>

    <tbody> <!-- Corps du tableau -->
    <?php foreach ($data as $row): ?>
        <tr>
            <td><?php echo $row['label']; ?></td>
            <td class="text-center"><a
                    href="<?php echo Url::to(['dashboard/detail', 'year' => date('Y'), 'category' => $row['categId']]); ?>"
                    target="_blank"><?php echo $row['current']; ?></a></td>
            <?php foreach ($row['month'] as $m => $amount): ?>
                <td class="text-center <?php echo intval($amount) > $row['yearAmount'] ? 'success' : 'danger'; ?>">
                    <a
                        href="<?php echo Url::to(['dashboard/detail', 'month' => $m , 'category' => $row['categId']]); ?>"
                        target="_blank"><?php echo $amount;?></a>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>