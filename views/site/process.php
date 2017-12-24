<?php
/**
 * @var DateInterface $dateService
 * @var $this yii\web\View
 * @var array $listCateg
 */
use Serval\Technical\Date\DateInterface;
use yii\helpers\Url;

$nb = 0;
?>

    <div class="page-header">
        <h1>
            Traitements des nouvelles opérations
            <span class="badge"><?php echo count($data);?></span>
        </h1>
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
            $htmlCateg =[];
            $nbb = 1;
            foreach ($listCateg as $categ) {
                $categ['btnClass'] = 'btn-id-' . $item['id'];
                if ($categ['code'] === $item['categ']) {
                    $categ['btnClass'] .= ' btn-success';
                    $nb++;
                } else {
                    $categ['btnClass'] .= ' btn-default';
                }
                $htmlCateg[] = $this->render('partials/categ_label', $categ) . (($nbb%5) === 0 ? '<div class="clearfix"></div>':'');
                $nbb++;
            }
            switch ($listCateg[$item['categ'] ]['mainCateg']) {
                case 'CHARGE' :
                    $labelClass = 'label-danger';
                    break;
                case 'APPORT' :
                    $labelClass = 'label-success';
                    break;
                default:
                    $labelClass = ($item['categ'] === 'AUTRE'? 'label-warning':'label-default');
            }
            ?>
            <tr data-id="<?php echo $item['id'];?>">
                <td class="text-center"><?php echo $dateService->dateMysqlToI18nString($item['date_operation']); ?></td>
                <td class="text-center <?php echo intval( $item['amount']) > 0 ? 'success':'warning';?>"><strong><?php echo $item['amount']; ?> &euro;</strong></td>
                <td><?php echo $item['label']; ?>&nbsp;<span class="label <?php echo $labelClass;?>"><?php echo $item['categ'];?></span></td>
                <td><?php echo implode('&nbsp;', $htmlCateg);?></td>
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
<p>    <a href="/site/guess" class="btn-lg btn-primary inline">Valider</a>
</p>
<div class="clearfix"></div>
<?php else: ?>
    <h3>Aucune nouvelle opération à traiter</h3>
<?php endif ?>