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

$form_name = "HYPERV";
$table_name = $form_name;
$tab_options = $protectedPost;
$tab_options['form_name'] = $form_name;
$tab_options['table_name'] = $table_name;
echo open_form($form_name, '', '', 'form-horizontal');
$list_fields = array(
    'HOST NAME' => 'h.NAME',
    'VM NAME' => 'hv.VMNAME',
    'OCS ASSET ID' => 'n.HARDWARE_ID',
    'ID' => 'hv.VMID',
    'IP' => 'hv.IPADDRESS',
    'MACADDRESS' => 'hv.MACADDRESS',
    'STATUS' => 'hv.STATUS',
    'STATE' => 'hv.STATE',
    'VERSION' => 'hv.VERSION',
    'UPTIME' => 'hv.UPTIME',
    'MEMORY ASSIGNED' => 'hv.MEMORYASSIGNED',
    'CPU USAGE' => 'hv.CPU_USAGE',
);
$list_col_cant_del = $list_fields;
$tab_options['LIEN_LBL']['HOST NAME'] = 'index.php?' . PAG_INDEX . '=' . $pages_refs['ms_computer'] . '&head=1&cat=other&systemid=';
$tab_options['LIEN_CHAMP']['HOST NAME'] = 'hostID';
$tab_options['LIEN_LBL']['OCS ASSET ID'] = 'index.php?' . PAG_INDEX . '=' . $pages_refs['ms_computer'] . '&head=1&cat=other&systemid=';
$tab_options['LIEN_CHAMP']['OCS ASSET ID'] = 'guestID';

$default_fields = $list_fields;

$sql = prepare_sql_tab($list_fields);
# TODO : chanhge reconciliation ?
$sql['SQL'] .= ",n.HARDWARE_ID as guestID, h.NAME, hv.HARDWARE_ID as hostID FROM HYPERV hv left join hardware h on h.ID=hv.HARDWARE_ID left join networks n on (hv.MACADDRESS=n.MACADDR and hv.IPADDRESS=n.IPADDRESS)";

$tab_options['ARG_SQL'] = $sql['ARG'];
ajaxtab_entete_fixe($list_fields, $default_fields, $tab_options, $list_col_cant_del);
echo close_form();
if (AJAX) {
    ob_end_clean();
    tab_req($list_fields, $default_fields, $list_col_cant_del, $sql['SQL'], $tab_options);
    ob_start();
}
