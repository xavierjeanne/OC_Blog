<?php
namespace Framework\Validator;

/**
 * validation class, retrieve message of error validation
 */
class ValidationError
{

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $key;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $rule;

    /**
     * Undocumented variable
     *
     * @var array
     * */
    private $attributes;

    private $messages = [
        'required' => 'Le champ %s  est requis',
        'empty' => 'Le champ %s ne peut être vide',
        'minLength' => 'Le champ %s doit contenir plus de %d caractères',
        'maxLength' => 'Le champ %s doit contenir moins de %d caractères',
        'betweenLength' => 'Le champ %s doit contenir entre %d et %d caractères',
        'datetime' => 'Le champ %s doit être au format %d',
        'exists' => 'Le champ %s n\'existe pas dans la table %s',
        'unique' => 'Le champ %s  doit être unique'
    ];

    public function __construct(string $key, string $rule, array $attributes = [])
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }


    /**
     * return text error
     *
     * @return string
     */
    public function __toString()
    {
        //store key messages of rule and attributes in params
        $params = array_merge([$this->messages[$this->rule], $this->key], $this->attributes);
        //return messages error coresponding to  rule for key
        return (string) call_user_func_array('sprintf', $params);
    }
}
