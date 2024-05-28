$xmlLines = @()

Get-VM | ForEach-Object {
    $vmName = $_.Name
    $vmId = $_.Id

    # append VM details to the array
    $xmlLines += "<HYPERV>"
    $xmlLines += "<VMNAME>$vmName</VMNAME>"
    $xmlLines += "<VMID>$vmId</VMID>"
    $xmlLines += "<STATE>$($_.State)</STATE>"
    $xmlLines += "<CPU_USAGE>$($_.CPUUsage)</CPU_USAGE>"
    $xmlLines += "<MEMORYASSIGNED>$($_.MemoryAssigned)</MEMORYASSIGNED>"
    $xmlLines += "<UPTIME>$($_.Uptime)</UPTIME>"
    $xmlLines += "<STATUS>$($_.Status)</STATUS>"
    $xmlLines += "<VERSION>$($_.Version)</VERSION>"

    # Get-VMNetworkAdapter information for each vm
    $vmNetworkAdapterInfo = Get-VMNetworkAdapter -VMName $vmName -ErrorAction SilentlyContinue
    if ($vmNetworkAdapterInfo) {
        foreach ($adapter in $vmNetworkAdapterInfo) {
            $macAddress = $adapter.MacAddress
            $ipAddresses = $adapter.IPAddresses -join ', '
            $xmlLines += "<MACADDRESS>$macAddress</MACADDRESS>"
            $xmlLines += "<IPADDRESS>$ipAddresses</IPADDRESS>"
        }
    }

    $xmlLines += "</HYPERV>"
}

$xml = $xmlLines -join "`n"

[Console]::WriteLine($xml)

# write to current directory for testing
$xml | Out-File -FilePath .\hyperv.xml -Encoding utf8