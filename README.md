# zencart-uk-postcode-validation

UK Postcode Validation plug-in for Zen Cart
-------------------------------------------
A common problem with users entering UK addresses is that the postcode is often entered incorrectly or partially. The standard
Zen Cart postcode vlaidation on the address forms only checks for minimum length and applies the same minimum length to all
postcodes regardless of country. All UK postal and courier services require accurate postcodes so encouraging the user to
correct mistakes in the postcode can save a lot of work and delay in fulfilling the order.

The UK Postcode Validation plug-in carries out validation of UK postcodes entered in Zen Cart address forms. It checks only the
format of the postcode. It cannot detect if the user has entered the wrong postcode if it is correctly (or nearly correctly)
formatted.

It works with:
  - Address book address entry and editing
  - Account registration
  - The standard 3-page checkout flow
  - The "One Page Checkout" plug-in

As the name suggests, it only works with UK addresses. Non-UK addresses are not checked beyond the standard Zen Cart validation.
When the user enters a UK address and submits the form, the format of the postcode is checked and corrected if possible,
according to UK Post Office postcode formatting rules. For example, if the user enters "tq12ab" it is reformatted to "TQ1 2AB".
If the format cannot be corrected (e.g. "tq12") then form submission will be refused and the user prompted to correct the error.

UK Postcode Validation has been tested with Zen Cart 1.58a and Zen Cart 2.00, running on PHP 8.1 to PHP 8.3.
It will probably run fine on earlier versions of PHP but they have not been tested.

Plug-in installation
--------------------
This plug-in does not overwrite any core files. One template file is overridden.

1. Create a backup of your web-site, including the database.

2. Rename the following folder according to your website:
/uk_postcode_validation/includes/templates/YOUR_TEMPLATE/

3. Upload the contents of the uk_postcode_validation folder into your Zen Cart installation. The upload should add the following 3 files to your website:

/includes/templates/YOUR_TEMPLATE/jscript/zen_jscript_form_check.php
/includes/languages/english/extra_definitions/lang.uk_postcode_extra_definitions.php
/includes/classes/observers/auto.uk_postcode_validation.php (only required if One Page Checkout is installed)

Uninstallation
--------------
Simply delete the three files that were uploaded during installation.
