<?php
require_once 'functions.php';
$reportFile = __DIR__ . '/../tests/report/coverage.xml';
if (false === file_exists($reportFile)) {
    throw new \Exception($reportFile . ' not found');
}

$report = simplexml_load_file($reportFile);

$list = array();
foreach ($report->project->package as $package) {
//    _dbg($package->file->class->attributes()->{'namespace'});
    $class = $package->file->class;
    $namespace = (string)$class->attributes()->{'namespace'};
    $coverage = ($class->metrics->attributes()->{'coveredstatements'} / $class->metrics->attributes()->{'statements'})*100;
    $coverage = round($coverage, 2);
    $list[$namespace] = $coverage;

}
asort($list);
_dbg($list);