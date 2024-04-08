###############################################################################
## OCSINVENTORY-NG
## Copyleft Léa DROGUET 2024
## Web : http://www.ocsinventory-ng.org
##
## This code is open source and may be copied and modified as long as the source
## code is always made freely available.
## Please refer to the General Public Licence http://www.gnu.org/ or Licence.txt
################################################################################

package Apache::Ocsinventory::Plugins::hyperv::Map;
 
use strict;
 
use Apache::Ocsinventory::Map;
$DATA_MAP{hyperv} = {
   mask => 0,
   multi => 1,
   auto => 1,
   delOnReplace => 1,
   sortBy => 'ID',
   writeDiff => 0,
   cache => 0,
   fields => {
      ID => {},
      HARDWARE_ID => {},
   }
};

$DATA_MAP{hyperv_vms} = {
   mask => 0,
   multi => 1,
   auto => 1,
   delOnReplace => 1,
   sortBy => 'ID',
   writeDiff => 0,
   cache => 0,
   fields => {
      ID => {},
      HOST_HARDWARE_ID => {},
      HARDWARE_ID => {},
      VMNAME => {},
      STATE => {},
      CPU_USAGE => {},
      MEMORYASSIGNED => {},
      UPTIME => {},
      STATUS => {},
      VERSION => {},
      CPU_COUNT => {},
      CPU_COMPATIBILITYFORMIGRATIONENABLED => {},
      CPU_COMPATIBILITYFOROLDEROPERATINGSYSTEMSENABLED => {},
      BIOS_STARTUPORDER => {},
      BIOS_NUMLOCKENABLED => {},
      NETWORK_NAME => {},
      NETWORK_ISMANAGEMENTOS => {},
      NETWORK_SWITCHNAME => {},
   }
};
1;
