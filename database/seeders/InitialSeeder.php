<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Networks;
use App\Models\Package;
use App\Models\NetworkCommissions;
use App\Models\Configuration;
use App\Models\Topups;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            [
                'ntw_name'         => 'ROSHAN',
                'ntw_country_iso'  => 'AF',
                'ntw_rate'         => '5.00',
            ],
            [
                'ntw_name'         => 'ETISALAT',
                'ntw_country_iso'  => 'IR',
                'ntw_rate'         => '6.00',
            ],
            [
                'ntw_name'         => 'MTN',
                'ntw_country_iso'  => 'DZ',
                'ntw_rate'         => '7.00',
            ],
            [
                'ntw_name'         => 'AWCC',
                'ntw_country_iso'  => 'PK',
                'ntw_rate'         => '8.00',
            ],
            [
                'ntw_name'         => 'SALAM',
                'ntw_country_iso'  => 'SD',
                'ntw_rate'         => '9.00',
            ],
        );

        Networks::insert($data);

        $data = [
            [
                'pck_type'           => 'Voice',
                'pck_credit_amount'  => '5',
                'pck_data_amount'    => '5',
                'pck_minutes_amount' => '5',
                'pck_sms_amount'     => '5',
                'pck_price'          => '5',
                'pck_currency_id'    => 'INR',
                'pck_memo'           => 'This is a test package memo',
                'pck_pin_number'     => '5',
                'pck_pin_info'       => 'This is test information',
                'pck_ntw_id'         => '1',
            ],
            [
                'pck_type'           => 'Messages',
                'pck_credit_amount'  => '6',
                'pck_data_amount'    => '6',
                'pck_minutes_amount' => '6',
                'pck_sms_amount'     => '6',
                'pck_price'          => '6',
                'pck_currency_id'    => 'Afg',
                'pck_memo'           => 'This is a test package memo',
                'pck_pin_number'     => '6',
                'pck_pin_info'       => 'This is test information',
                'pck_ntw_id'         => '2',
            ],
            [
                'pck_type'           => 'Call',
                'pck_credit_amount'  => '7',
                'pck_data_amount'    => '7',
                'pck_minutes_amount' => '7',
                'pck_sms_amount'     => '7',
                'pck_price'          => '7',
                'pck_currency_id'    => 'JPY',
                'pck_memo'           => 'This is a test package memo',
                'pck_pin_number'     => '7',
                'pck_pin_info'       => 'This is test information',
                'pck_ntw_id'         => '3',
            ]
        ];

        Package::insert($data);

        $data = array(
            [
                'com_ntw_id'      => '1',
                'com_user_id'     => '1',
                'com_custom_rate' => '6',
            ],
            [
                'com_ntw_id'      => '2',
                'com_user_id'     => '2',
                'com_custom_rate' => '6',
            ],
            [
                'com_ntw_id'      => '3',
                'com_user_id'     => '3',
                'com_custom_rate' => '6',
            ],
            [
                'com_ntw_id'      => '4',
                'com_user_id'     => '4',
                'com_custom_rate' => '7',
            ],
            [
                'com_ntw_id'      => '4',
                'com_user_id'     => '4',
                'com_custom_rate' => '8',
            ],
        );

        NetworkCommissions::insert($data);

        $data = array(
            [
                'name'      => 'API_Link',
                'value'     => 'http://103.143.204.229:8080',
            ]
        );

        Configuration::insert($data);


        $topups = array(
            array('top_phone_number' => '789357846', 'user_id' => '2', 'top_pac_id' => '1', 'top_amount' => '256.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '1', 'top_ussd_output' => 'Failed'),
            array('top_phone_number' => '789357846', 'user_id' => '2', 'top_pac_id' => '1', 'top_amount' => '256.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '1', 'top_ussd_output' => 'TopUp for 93789357846 successfully registered for AFN 5. TID#6461b8b103575'),
            array('top_phone_number' => '789357846', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Failed'),
            array('top_phone_number' => '789357846', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '1', 'top_ussd_output' => 'TopUp for 93789357846 successfully registered for AFN 5. TID#6461cb250e4dc'),
            array('top_phone_number' => '79800481', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Telco not available'),
            array('top_phone_number' => '798000481', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Transaction Amount not in range - Closed ( Amount out of range for Top-up )'),
            array('top_phone_number' => '786151588', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Failed'),
            array('top_phone_number' => '786151588', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '25.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Failed'),
            array('top_phone_number' => '747121258', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Failed'),
            array('top_phone_number' => '789357846', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Failed'),
            array('top_phone_number' => '789443343', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Failed'),
            array('top_phone_number' => '789434343', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Failed'),
            array('top_phone_number' => '789357846', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '1', 'top_ussd_output' => 'TopUp for 93789357846 successfully registered for AFN 5. TID#64630fcfbded4'),
            array('top_phone_number' => '5512719870', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Telco not available'),
            array('top_phone_number' => '786151588', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '1', 'top_ussd_output' => 'TopUp for 93786151588 successfully registered for AFN 5. TID#646360da35a7c'),
            array('top_phone_number' => '798000481', 'user_id' => '2', 'top_pac_id' => NULL, 'top_amount' => '5.00', 'top_currency' => 'AFN', 'top_rate' => '1.00', 'top_status' => '0', 'top_ussd_output' => 'Transaction Amount not in range - Closed ( Amount out of range for Top-up )')
        );


        Topups::insert($topups);
    }
}
