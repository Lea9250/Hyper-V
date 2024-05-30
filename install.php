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
                          `VMNAME` VARCHAR(255) NOT NULL,
                          `VMID` VARCHAR(255) NOT NULL,
                          `STATE` VARCHAR(255) NOT NULL,
                          `CPU_USAGE` INT(11) NOT NULL,
                          `MEMORYASSIGNED` INT(11) NOT NULL,
                          `UPTIME` INT(11) NOT NULL,
                          `STATUS` VARCHAR(255) NOT NULL,
                          `VERSION` VARCHAR(255) NOT NULL,
                          `MACADDRESS` VARCHAR(255) NOT NULL,
                          `IPADDRESS` VARCHAR(255) NOT NULL,
                          PRIMARY KEY  (`ID`,`HARDWARE_ID`)
                            ) ENGINE=INNODB ;");

}

/**
 * This function is called on removal and is used to destroy database schema for the plugin
 */
function extension_delete_hyperV() {
    $commonObject = new ExtensionCommon;
    $commonObject -> sqlQuery("DROP TABLE `HYPERV`");
}

/**
 * This function is called on plugin upgrade
 */
function extension_upgrade_hyperV() {

}