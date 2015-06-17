Magento StatusPage.io Module
============================

Integrates Magento with [StatusPage.io](https://www.statuspage.io/).

![screenshot](http://i.imgur.com/A4zmLkw.png)

This module will send metrics using StatusPage.io API.  The current metrics are:

* Orders

Installation
------------

1. Copy the contents of `src/` to your Magento installation
2. Clear Magento caches
3. Log out/in to admin
4. Add your credentials in **System > Configuration > Services > StatusPage.io**

## Installation with Modman

    cd /path/to/magento/
    modman init
    modman clone https://github.com/steverobbins/Magento-StatusPageIo.git

## Installation with Composer

    composer require steverobbins/magento-statuspageio --dev

Uninstallation
--------------

* Remove `app/etc/modules/Steverobbins_Statuspageio.xml` and `app/code/community/Steverobbins/Statuspageio/`
* Run the following queries
```
DROP TABLE steverobbins_statuspageio_event;
DELETE FROM core_resource WHERE code = "steverobbins_statuspageio_setup";
DELETE FROM core_config_data WHERE path LIKE "steverobbins_statuspageio_setup/%";
```

Support
-------

Please submit any issues or feature requests to the [issue tracker](https://github.com/steverobbins/Magento-StatusPageIo/issues).

License
-------

[Creative Commons Attribution 3.0 Unported License](http://creativecommons.org/licenses/by/3.0/deed.en_US)
