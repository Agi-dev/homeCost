<?php
/**
 * @var array $listCosts
 * @var array $params
 * @var array $categ
 * @var DateInterface $dateService
 */
use Serval\Technical\Date\DateInterface;

$listM = ['F', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
if (true === isset($params['month'])) {
    $title = $listM[$params['month']];
}

if (true === isset($params['year'])) {
    $title .= ' ' . $params['year'];
}

if (true === isset($params['category'])) {
    $title .= ' "' . $categ['label'] .'"';
}
$total = 0;
?>
<div class="page-header">
    <h1><?php echo $title;?></h1>
</div>

<?php if ($listCosts): ?>
    <table class="table table-striped table-condensed">
        <thead> <!-- En-tête du tableau -->
        <tr>
            <th class="text-center" width="10%">Date</th>
            <th class="text-center" width="10%">Montant</th>
            <th width="10%">Catégorie</th>
            <th>Opération</th>
        </tr>
        </thead>

        <tbody> <!-- Corps du tableau -->
        <?php foreach ($listCosts as $item): ?>
            <tr data-id="<?php echo $item['id'];?>">
                <td class="text-center"><?php echo $dateService->dateMysqlToI18nString($item['date']); ?></td>
                <td class="text-center <?php echo intval( $item['amount']) > 0 ? 'success':'danger';?>"><strong><?php echo $item['amount']; ?> &euro;</strong></td>
                <td><?php echo $item['category']; ?></td>
                <td><?php echo $item['operation']; ?></td>
            </tr>
            <?php $total += $item['amount'];?>
        <?php endforeach; ?>
        </tbody>

        <tfoot> <!-- Pied de tableau -->
        <tr>
            <th class="text-right">Total</th>
            <th class="text-center"><?php echo number_format($total, 2);?>&euro;</th>
            <th></th>
            <th></th>
        </tr>
        </tfoot>
    </table>
<?php else: ?>
    <h3>Aucune opération</h3>
<?php endif ?>
