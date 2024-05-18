<?php
/**
 * UK postcode validation 1.0.0
 * auto.ukpostcode.php
 * UK postcode validation observer class
 *
 * @author  SAABits Ltd.
 * @copyright Copyright 2024
 */
 

/*
 * Observer class to validate and format UK postcodes in OPC
 */

class zcObserverUkPostcodeValidation extends base
{
    public function __construct()
    {
        $this->attach($this, [
            'NOTIFY_OPC_ADDRESS_VALIDATION',
        ]);
    }
    
    /**
     * NOTIFY_OPC_ADDRESS_VALIDATION
     * Presents us with the address fields:
     *    $address ... (r/o) An associative array containing two keys:
     *            - 'which' ............ contains either 'ship' or 'bill', identifying which address-type is being validated.
     *            - 'address_values' ... contains an array of posted values associated with the to-be-validated address.
     *    $additional_messages ... (r/w) A reference to the, initially empty, $additional_messages associative array.  That array is keyed on the
     *            like-named key within $p1's 'address_values' array, with the associated value being a language-specific message to
     *            display to the customer.  If this array is _not empty_, the address is considered unvalidated.
     *    $additional_address_values ... (r/w) A reference to the, initially empty, $additional_address_values associative array.  That array is keyed on
     *            the like-named key within $p1's 'address_values' array, with the associated value being that to be stored for the
     *            address.
     *
     *
     * Validate the postcode and format it.
     * If validation fails, return an error message in $additional_messages.
     * If validation passes, format the postcode and return it in $additional_address_values['postcode']
     */
    public function updateNotifyOpcAddressValidation( &$class, $eventID, $address, &$additional_messages, &$additional_address_values )
    {
		// Only applies to UK postcodes
		if( $address['address_values']['zone_country_id'] == 222 ) {

            // Format the postcode correctly if possible
            $p = strtoupper( $address['address_values']['postcode'] );
			if( preg_match('/^([A-Z]{1,2}\d{1,2}[A-Z]?)\s*(\d[A-Z]{2})$/', $p, $parts) ) {
            	// Insert a single space between the district and the rest of the postcode
				array_shift( $parts );
				$p = join( ' ', $parts );
				
				// Now apply stricter validation using the postcode validation RegEx found here:
            	// https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/488478/Bulk_Data_Transfer_-_additional_validation_valid_from_12_November_2015.pdf

				if( preg_match('/^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([AZa-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$/', $p) ) {
					// Set the formatted postcode
    				$additional_address_values['postcode'] = $p;
            	} else {
	                $additional_messages[] = UK_POSTCODE_INCORRECT_FORMAT . " " . $address['address_values']['postcode'];
            	}
            } else {
                    $additional_messages[] = UK_POSTCODE_INCORRECT_FORMAT . " " . $address['address_values']['postcode'];
            }
    	}
    }
}
