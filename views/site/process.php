<?php
/**
 * @var DateInterface $dateService
 * @var $this yii\web\View
 * @var array $listCateg
 */
use Serval\Technical\Date\DateInterface;
use yii\helpers\Url;

$htmlCateg = [];
$nb=1;
$listCategById = [];
foreach ($listCateg as $item) {
    $htmlCateg[] = $this->render('partials/categ_label', $item) . (($nb%5) === 0 ? '<div class="clearfix"></div>':'');
    $listCategById[$item['id']] = $item;
    $nb++;
}
$htmlCateg = implode('&nbsp;', $htmlCateg);
$nb = 0;
?>

    <div class="page-header">
        <h1>Traitements des nouvelles opérations <span class="badge"><?php echo count($data);?></span></h1>
    </div>
<?php if ($data): ?>
    <table class="table table-striped table-condensed">
        <thead> <!-- En-tête du tableau -->
        <tr>
            <th class="text-center">Date</th>
            <th class="text-center">Montant</th>
            <th>Opération</th>
            <th>Catégorie</th>
            <th class="text-center">Ignore</th>
        </tr>
        </thead>

        <tfoot> <!-- Pied de tableau -->
        </tfoot>

        <tbody> <!-- Corps du tableau -->

        <?php foreach ($data as $item): ?>
            <?php
            if (null === $item['category_id']){
                continue;
            }
            $nb++;
            ?>
            <tr data-id="<?php echo $item['id'];?>">
                <td class="text-center"><?php echo $dateService->dateMysqlToI18nString($item['date_operation']); ?></td>
                <td class="text-center <?php echo intval( $item['amount']) > 0 ? 'success':'warning';?>"><strong><?php echo $item['amount']; ?> &euro;</strong></td>
                <td><?php echo $item['label']; ?></td>
                <td><?php
                    if ( null === $item['category_id']){
                        echo str_replace('btn-id', 'btn-id-'.$item['id'],$htmlCateg);
                    } else {
                        echo $this->render('partials/categ_label', $listCategById[$item['category_id']]);
                    }
                    ?></td>
                <td class="text-center">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="ignore" class="ckb-ignore ckb-id-<?php echo $item['id'];?>"> Oui
                        </label>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h3><?php echo $nb .' opérations affectées automatiquement';?></h3>
<?php else: ?>
    <h3>Aucune nouvelle opération à traiter</h3>
<?php endif ?>