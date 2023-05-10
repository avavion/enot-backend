<?php

namespace App\Services;

class Validator
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MAX  = 'max';
    public const RULE_MIN  = 'min';
    public const RULE_SAME  = 'same';

    private static array $CALLBACK_RULES = [
        self::RULE_EMAIL => 'validateEmail',
        self::RULE_MAX => 'validateMax',
        self::RULE_MIN => 'validateMin',
        self::RULE_SAME => 'validateSame',
        self::RULE_REQUIRED => 'validateRequired',
    ];

    private static array $RULES_ERRORS = [
        self::RULE_REQUIRED => "This field is required",
        self::RULE_EMAIL => "This field must be valid email address",
        self::RULE_MAX => "Max length of this field must be {max}",
        self::RULE_MIN => "Min length of this field must be {min}",
        self::RULE_SAME => "This field must be the same as {same}",
    ];

    private array $errors;
    private array $data;
    private array $rules;

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->errors = [];

        $this->validate($this->rules);
    }

    private function validateRequired(string|null $value): bool
    {
        return isset($value) && strlen(trim($value));
    }

    private function validateEmail()
    {
        return false;
    }

    private function validateMax()
    {
        return false;
    }

    private function validateMin()
    {
        return false;
    }

    private function validateSame()
    {
        return false;
    }

    private function appendErrorMessage(string $property, string $rule, array $params = []): void
    {
        $message = self::$RULES_ERRORS[$rule];

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $message = str_replace("{{$key}}", $value, $message);
            }
        }

        $this->appendError($property, $message);
    }

    private function appendError(string $property, string $message): void
    {
        $this->errors[$property][] = $message;
    }

    public function getErrorMessages()
    {
        return $this->errors;
    }

    private function separateKeyFromValue()
    {
    }

    // private function prepare(array $rules)
    // {
    //     return array_map(function ($value) {
    //         if (is_string($value)) {
    //             $ruleList = explode('|', $value);

    //             $values = [];

    //             foreach ($ruleList as $rule) {
    //                 if (str_contains($rule, ':')) {
    //                     $exploded = explode(':', $rule);

    //                     $values[$exploded[0]] = $exploded[1];

    //                     continue;
    //                 }

    //                 $values[] = $rule;
    //             }

    //             return $values;
    //         }

    //         return $value;
    //     }, $rules);
    // }

    public function validate(array $list)
    {
        // $list = $this->prepare($list);

        foreach ($list as $property => $rules) {
            $validateValue = $this->$list[$property];

            foreach ($rules as $rule) {
                $name = $rule;
                $params = [];

                if (is_array($rule)) {
                    [$name, $params] = $rule;
                }

                $callback = self::$CALLBACK_RULES[$name];

                if (!$this->$callback($validateValue, $params)) {
                    $this->appendErrorMessage($property, $name, $params);
                }
            }
        }
    }

    public function validated()
    {
        return empty($this->getErrorMessages());
    }
}
