Important
=========

Run configuration
-----------------

To run tests in test/Run directory please edit config.php file with your Smsapi account credentials

'api_login' => "your_login"
'api_password' => "your_password"

and your mobile number:

'number_test' => "your_mobile"

To run tests with templates you need to add template in SMSAPI administration panel and add it to configuration file:

'sms_template_name' => 'template_name_from_administration_panel'

Otherwise test with sms template will be skipped.
