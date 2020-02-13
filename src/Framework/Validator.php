<?php
namespace App\Framework;

use Framework\Database\Table;
use Framework\Validator\ValidationError;

class Validator
{
    /**
     * Undocumented variable
     *
     * @var array
     */
    private $params;

    /**
     * Undocumented function
     *
     * @param array[]
     */
    private $errors = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * check required field
     *
     * @param  mixed $keys
     *
     * @return self
     */
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


    /**
     * check if field is good length
     *
     * @param  mixed $key
     * @param  mixed $min
     * @param  mixed $max
     *
     * @return self
     */
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
    /**
     * check field is not empty
     *
     * @param string ...$keys
     * @return self
     */
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

    /**
     * dateTime check
     *
     * @param  mixed $key
     * @param  mixed $format
     *
     * @return self
     */
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

    /**
     * check is register exist
     *
     * @param [type] $id
     * @param string $table
     * @return self
     */
    public function exists(string $key, string $table, \PDO $pdo): self
    {
        $id = $this->getValue($key);
        $query = $pdo->prepare("SELECT id FROM $table WHERE id=?");
        $query->execute([$id]);
        //if register not exists
        if ($query->fetchColumn() === false) {
            $this->addError($key, 'exists', [$table]);
        }
        return $this;
    }

    /**
     * check if key is unique
     *
     * @param string $key
     * @param string $table
     * @param \PDO $pdo
     * @param integer|null $exclude
     * @return self
     */
    public function unique(string $key, string $table, \PDO $pdo, ?int $exclude = null): self
    {
        $value = $this->getValue($key);
        $query = "SELECT id FROM $table WHERE $key=?";
        $params = [$value];
        //if exist exlude value (use for edition of a register allready in database)
        if ($exclude !== null) {
            $query .= " AND id != ?";
            $params[] = $exclude;
        }
        $query = $pdo->prepare($query);
        $query->execute([$params]);
        //if register  exists
        if ($query->fetchColumn() !== false) {
            $this->addError($key, 'unique', [$value]);
        }
        return $this;
    }

    /**
     * check is form soumission is valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Get errors function
     * @var ValidationError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * add error
     *
     * @param string $key
     * @param string $rule
     * @param array $attributes
     * @return void
     */
    private function addError(string $key, string $rule, array $attributes = []): void
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }

    /**
     * get value
     *
     * @param string $value
     */
    private function getValue(string $key)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }
        return null;
    }
}
