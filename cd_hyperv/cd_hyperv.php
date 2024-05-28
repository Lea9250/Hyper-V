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


 /**
  * This file is used to build a table refering to the plugin and define its 
  * default columns as well as SQL request.
  */

if (AJAX) {
    parse_str($protectedPost['ocs']['0'], $params);
    $protectedPost += $params;
    ob_start();
    $ajax = true;
} else {
    $ajax = false;
}

// print a title for the table
print_item_header($l->g(56665));

if (!isset($protectedPost['SHOW'])) {
    $protectedPost['SHOW'] = 'NOSHOW';
}

// form details and tab options
$form_name = "hyperv";
$table_name = $form_name;
$tab_options = $protectedPost;
$tab_options['form_name'] = $form_name;
$tab_options['table_name'] = $table_name;
echo open_form($form_name);

$systemid = $_GET['systemid'];
$sql = "SELECT * FROM HYPERV WHERE HARDWARE_ID=$systemid";
$result = mysql2_query_secure($sql, $_SESSION['OCS']["readServer"], array($systemid));
if (mysqli_num_rows($result) == 0) {
    // if VM, display host only
    $list_fields = array(
        'Host name' => 'h.NAME'
    );
    $tab_options['LIEN_LBL']['Host name'] = 'index.php?' . PAG_INDEX . '=' . $pages_refs['ms_computer'] . '&head=1&systemid=';
    $tab_options['LIEN_CHAMP']['Host name'] = 'hostID';
    $sql = prepare_sql_tab($list_fields);
    $sql['SQL']  .= ",n.HARDWARE_ID as guestID, h.NAME, hv.HARDWARE_ID as hostID FROM HYPERV hv left join hardware h on h.ID=hv.HARDWARE_ID left join networks n on (hv.MACADDRESS=n.MACADDR and hv.IPADDRESS=n.IPADDRESS) WHERE n.HARDWARE_ID=$systemid";
} else {
    // if host, display VMs
    $list_fields = array(
        'VM Name' => 'hv.VMNAME',
        'VM ID' => 'hv.VMID',
        'OCS Asset ID' => 'n.HARDWARE_ID',
        'VM IP' => 'hv.IPADDRESS',
        'VM macaddress' => 'hv.MACADDRESS',
        'VM Status' => 'hv.STATUS',
        'VM State' => 'hv.STATE',
        'VM Version' => 'hv.VERSION',
        'VM Uptime' => 'hv.UPTIME',
        'VM Memory assigned' => 'hv.MEMORYASSIGNED',
        'VM CPU Usage' => 'hv.CPU_USAGE',
    );
    $tab_options['LIEN_LBL']['OCS Asset ID'] = 'index.php?' . PAG_INDEX . '=' . $pages_refs['ms_computer'] . '&head=1&systemid=';
    $tab_options['LIEN_CHAMP']['OCS Asset ID'] = 'guestID';
    $sql = prepare_sql_tab($list_fields);
    $sql['SQL']  .= ", n.HARDWARE_ID as guestID FROM HYPERV hv left join networks n on (hv.MACADDRESS=n.MACADDR and hv.IPADDRESS=n.IPADDRESS) where hv.HARDWARE_ID=$systemid";
}

// columns to include at any time and default columns
$list_col_cant_del = $list_fields;
$default_fields = $list_fields;

array_push($sql['ARG'], $systemid);
$tab_options['ARG_SQL'] = $sql['ARG'];
$tab_options['ARG_SQL_COUNT'] = $systemid;
ajaxtab_entete_fixe($list_fields, $default_fields, $tab_options, $list_col_cant_del);

echo close_form();

if ($ajax) {
    ob_end_clean();
    tab_req($list_fields, $default_fields, $list_col_cant_del, $sql['SQL'], $tab_options);
    ob_start();
}
?>
