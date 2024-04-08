$xmlLines = @()

Get-VM | ForEach-Object {
    $vmName = $_.Name

    # append VM details to the array
    $xmlLines += "<HYPERV_VMS>"
    $xmlLines += "<VMNAME>$vmName</VMNAME>"
    $xmlLines += "<STATE>$($_.State)</STATE>"
    $xmlLines += "<CPU_USAGE>$($_.CPUUsage)</CPU_USAGE>"
    $xmlLines += "<MEMORYASSIGNED>$($_.MemoryAssigned)</MEMORYASSIGNED>"
    $xmlLines += "<UPTIME>$($_.Uptime)</UPTIME>"
    $xmlLines += "<STATUS>$($_.Status)</STATUS>"
    $xmlLines += "<VERSION>$($_.Version)</VERSION>"

    # Get-VMProcessor information for each vm
    $vmProcessorInfo = Get-VMProcessor -VMName $vmName -ErrorAction SilentlyContinue
    if ($vmProcessorInfo) {
        $xmlLines += "<CPU_COUNT>$($vmProcessorInfo.Count)</CPU_COUNT>"
        $xmlLines += "<CPU_COMPATIBILITYFORMIGRATIONENABLED>$($vmProcessorInfo.CompatibilityForMigrationEnabled)</CPU_COMPATIBILITYFORMIGRATIONENABLED>"
        $xmlLines += "<CPU_COMPATIBILITYFOROLDEROPERATINGSYSTEMSENABLED>$($vmProcessorInfo.CompatibilityForOlderOperatingSystemsEnabled)</CPU_COMPATIBILITYFOROLDEROPERATINGSYSTEMSENABLED>"
    }

    # Get-VMBios information for each vm
    $vmBiosInfo = Get-VMBios -VMName $vmName -ErrorAction SilentlyContinue
    if ($vmBiosInfo) {
        $startupOrder = $vmBiosInfo.StartupOrder -join ', '
        $xmlLines += "<BIOS_STARTUPORDER>$startupOrder</BIOS_STARTUPORDER>"
        $xmlLines += "<BIOS_NUMLOCKENABLED>$($vmBiosInfo.NumLockEnabled)</BIOS_NUMLOCKENABLED>"
    }

    # Get-VMNetworkAdapter information for each vm
    # TODO : might need to store these in a separate table depending on the number of network adapters
    $vmNetworkAdapterInfo = Get-VMNetworkAdapter -VMName $vmName -ErrorAction SilentlyContinue
    if ($vmNetworkAdapterInfo) {
        foreach ($adapter in $vmNetworkAdapterInfo) {
            $xmlLines += "<HYPERV_NETWORK>"
            $xmlLines += "<NETWORK_NAME>$($adapter.Name)</NETWORK_NAME>"
            $xmlLines += "<NETWORK_ISMANAGEMENTOS>$($adapter.IsManagementOs)</NETWORK_ISMANAGEMENTOS>"
            $xmlLines += "<NETWORK_SWITCHNAME>$($adapter.SwitchName)</NETWORK_SWITCHNAME>"
            $xmlLines += "</HYPERV_NETWORK>"
        }
    }

    $xmlLines += "</HYPERV_VMS>"
}

$xml = $xmlLines -join "`n"

[Console]::WriteLine($xml)

# write to current directory for testing
$xml | Out-File -FilePath .\hyperv.xml -Encoding utf8