<?php
###############################################################################
## OCSINVENTORY-NG
## Copyleft Léa DROGUET 2024
## Web : http://www.ocsinventory-ng.org
##
## This code is open source and may be copied and modified as long as the source
## code is always made freely available.
## Please refer to the General Public Licence http://www.gnu.org/ or Licence.txt
################################################################################

if (AJAX) {
    parse_str($protectedPost['ocs']['0'], $params);
    $protectedPost += $params;
    ob_start();
}

require "require/function_machine.php";

print_item_header($l->g(56665));
if (!isset($protectedPost['SHOW'])) {
    $protectedPost['SHOW'] = 'NOSHOW';
}
$form_name = "hyperv";
$table_name = $form_name;
$tab_options = $protectedPost;
$tab_options['form_name'] = $form_name;
$tab_options['table_name'] = $table_name;
echo open_form($form_name, '', '', 'form-horizontal');
$list_fields = array('HOST NAME' => 'h.NAME',
    'STATUS VM' => 'hv.STATE',
    'CPU VM' => 'hv.CPU_USAGE',
    'BIOS VM' => 'hv.BIOS_STARTUPORDER',
    'NETWORK' => 'hv.NETWORK_NAME',
    'VM NAME' => 'hv.VMNAME',
);
$list_col_cant_del = $list_fields;
$tab_options['LIEN_LBL']['HOST NAME'] = 'index.php?' . PAG_INDEX . '=' . $pages_refs['ms_computer'] . '&head=1&&cat=other&systemid=';
$tab_options['LIEN_CHAMP']['HOST NAME'] = 'hostID';
$tab_options['LIEN_LBL']['VM NAME'] = 'index.php?' . PAG_INDEX . '=' . $pages_refs['ms_computer'] . '&head=1&systemid=';
$tab_options['LIEN_CHAMP']['VM NAME'] = 'h.NAME';

$default_fields = $list_fields;

$sql = prepare_sql_tab($list_fields);
$sql['SQL'] .= ",h.ID, h.NAME, hv.HARDWARE_ID as hostID FROM HYPERV_VMS hv left join hardware h on h.ID=hv.HARDWARE_ID";
array_push($sql['ARG'], $systemid);
$tab_options['ARG_SQL'] = $sql['ARG'];
$tab_options['ARG_SQL_COUNT'] = $systemid;
ajaxtab_entete_fixe($list_fields, $default_fields, $tab_options, $list_col_cant_del);
echo close_form();
if (AJAX) {
    ob_end_clean();
    tab_req($list_fields, $default_fields, $list_col_cant_del, $sql['SQL'], $tab_options);
    ob_start();
}
