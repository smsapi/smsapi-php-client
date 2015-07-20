<?php

namespace SMSApi\Exception;

use Exception;

class ContactsException extends SmsapiException
{
    private $error;
    private $errors;
    private $shortMessage;

    public function __construct(array $data, Exception $exception = null)
    {
        $output = json_decode($data['output'], true);
        $this->error = $output['error'];
        $this->errors = $output['errors'];
        $this->shortMessage = $output['message'];
        $message = '';

        foreach ($this->errors as $k => $element) {
            if ($k) {
                $message .= '; ';
            }

            $message .=
                '[' . $element['error'] . '] ' . $element['message']
                . ' (path: ' . ($element['path'] ?: 'null')
                . ', value: ' . ($element['value'] ?: 'null') . ')';
        }

        parent::__construct(
            '[' . $output['error'] . '] '
            . $output['message']
            . ($message ? ': ' . $message : ''),
            $data['code'],
            $exception
        );
    }

    public function getShortMessage()
    {
        return $this->error;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
