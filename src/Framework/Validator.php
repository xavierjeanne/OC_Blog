<?php

namespace App\Framework;

use Framework\Validator\ValidationError;

class Validator
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var array[]
     */
    private $errors = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function required(string ...$keys): self
    {
        //for every keys in required
        foreach ($keys as $key) {
            //get the value of key
            $value = $this->getValue($key);

            //if value is null, store error for that key
            if (is_null($value)) {
                $this->addError($key, 'required');
            }
        }

        //return this object in order to execute other methode
        return $this;
    }

    public function length(string $key, ?int $min, ?int $max = null): self
    {
        $value = $this->getValue($key);
        //number of charecter
        $length = mb_strlen($value);

        //if min and max exist and length is not valid
        if (!is_null($min) && !is_null($max) && ($length < $min || $length > $max)) {
            //add error
            $this->addError($key, 'betweenLength', [$min, $max]);

            //return this object in order to execute other methode
            return $this;
        }

        //if min  exist and length is< $min
        if (!is_null($min) && $length < $min) {
            //add error
            $this->addError($key, 'minLength', [$min]);

            //return this object in order to execute other methode
            return $this;
        }
        //if max  exist and length is> $max
        if (!is_null($max) && $length > $max) {
            //add error
            $this->addError($key, 'maxLength', [$max]);

            return $this;
        }

        //return this object in order to execute other methode
        return $this;
    }

    public function notEmpty(string ...$keys): self
    {
        //for every keys in required
        foreach ($keys as $key) {
            //get the value of key
            $value = $this->getValue($key);

            //if value is null or empty, store error for that key
            if (is_null($value) || empty($value)) {
                $this->addError($key, 'empty');
            }
        }

        //return this object in order to execute other methode
        return $this;
    }

    public function dateTime(string $key, string $format = "Y-m-d H:i:s"): self
    {
        $value = $this->getValue($key);
        //define date format
        $date = \DateTime::createFromFormat($format, $value);
        //get error from datetime
        $errors = \DateTime::getLastErrors();

        if ($errors['error_count'] > 0 || $errors['warning_count'] > 0 || $date === false) {
            $this->addError($key, 'datetime', [$format]);
        }

        //return this object in order to execute other methode
        return $this;
    }

    public function email(string $key): self
    {
        $value = $this->getValue($key);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($key, 'email');
        }

        //return this object in order to execute other methode
        return $this;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function addError(string $key, string $rule, array $attributes = []): void
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }

    private function getValue(string $key)
    {

        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }

        return null;
    }
}
