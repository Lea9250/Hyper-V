# Plugin hyperV

<p align="center">
  <img src="https://cdn.ocsinventory-ng.org/common/banners/banner660px.png" height=300 width=660 alt="Banner">
</p>

<h1 align="center">Plugin hyperV</h1>
<p align="center">
  <b>Some Links:</b><br>
  <a href="http://ask.ocsinventory-ng.org">Ask question</a> |
  <a href="https://www.ocsinventory-ng.org/?utm_source=github-ocs">Website</a> |
  <a href="https://www.ocsinventory-ng.org/en/#ocs-pro-en">OCS Professional</a> |
  <a href="https://wiki.ocsinventory-ng.org/10.Plugin-engine/Using-plugins-installer/">Plugin Install</a>
</p>

## Description

Hyper-V inventory plugin. 

Plugin's agent script must be installed on a server with Hyper-V capabilities enabled.

This plugin adds two pages to the OCS Inventory web interface :
- Hyper-V Inventory : List all Hyper-V VMs with references to host inventory and VM inventory.
- Hyper-V details : Displays either a link to the host inventory or the VMs inventories depending on the asset type. Available under computer details, `Miscellaneous` tab.

Commands are executed on the Hyper-V host :
- `Get-VM` : List all VMs.
- `Get-VMNetworkAdapter` : List all network adapters for a VM.

Reconciliation with an existing asset within OCS is done using the VM IP address and MAC address.