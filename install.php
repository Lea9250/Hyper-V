<?php

/**
 * This function is called on installation and is used to create database schema for the plugin
 */
function extension_install_hyperV() {
    $commonObject = new ExtensionCommon;

    $commonObject -> sqlQuery("DROP TABLE `HYPERV`");

    
    $commonObject -> sqlQuery("CREATE TABLE `HYPERV` (
                          `ID` INT(11) NOT NULL AUTO_INCREMENT,
                          `HARDWARE_ID` INT(11) NOT NULL,
                          PRIMARY KEY  (`ID`,`HARDWARE_ID`)
                            ) ENGINE=INNODB ;");

    // TODO : hyper v dummy data for now
    $commonObject -> sqlQuery("CREATE TABLE `HYPERV_VMS` (
                          `ID` INT(11) NOT NULL AUTO_INCREMENT,
                          `HOST_HARDWARE_ID` INT(11) NOT NULL,
                          `HARDWARE_ID` INT(11) NOT NULL,
                          `VMNAME` VARCHAR(255) NOT NULL,
                          `STATE` VARCHAR(255) NOT NULL,
                          `CPU_USAGE` VARCHAR(255) NOT NULL,
                          `MEMORYASSIGNED` VARCHAR(255) NOT NULL,
                          `UPTIME` VARCHAR(255) NOT NULL,
                          `STATUS` VARCHAR(255) NOT NULL,
                          `VERSION` VARCHAR(255) NOT NULL,
                          `CPU_COUNT` INT(11) NOT NULL,
                          `CPU_COMPATIBILITYFORMIGRATIONENABLED` VARCHAR(255) NOT NULL,
                          `CPU_COMPATIBILITYFOROLDEROPERATINGSYSTEMSENABLED` VARCHAR(255) NOT NULL,
                          `BIOS_STARTUPORDER` VARCHAR(255) NOT NULL,
                          `BIOS_NUMLOCKENABLED` VARCHAR(255) NOT NULL,
                          `NETWORK_NAME` VARCHAR(255) NOT NULL,
                          `NETWORK_ISMANAGEMENTOS` VARCHAR(255) NOT NULL,
                          `NETWORK_SWITCHNAME` VARCHAR(255) NOT NULL,
                          PRIMARY KEY  (`ID`,`HARDWARE_ID`)
                            ) ENGINE=INNODB ;");

}

/**
 * This function is called on removal and is used to destroy database schema for the plugin
 */
function extension_delete_hyperV() {
    $commonObject = new ExtensionCommon;
    $commonObject -> sqlQuery("DROP TABLE `HYPERV`");
    $commonObject -> sqlQuery("DROP TABLE `HYPERV_VMS`");
}

/**
 * This function is called on plugin upgrade
 */
function extension_upgrade_hyperV() {

}