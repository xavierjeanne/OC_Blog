<?php

namespace Framework\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('field', [$this, 'field'], ['is_safe' => ['html'], 'needs_context' => true])
        ];
    }

    /**
     * create field
     *
     * @param  mixed $key
     * @param  mixed $value
     * @param  mixed $label
     * @param  mixed $options
     *
     * @return void
     */
    public function field($context, string $key, $value, ?string $label = null, array $options = [])
    {
        //get type if exist, else type=text
        $type = $options['type'] ?? 'text';
        //define errorHtml
        $error = $this->getErrorHtml($context, $key);
        //define class for div
        $class = 'form-group';
        //convert value to string for datetime for example
        $value = $this->convertValue($value);
        //define $attributes
        $attributes = [
            'class' => trim('form-control ' . ($options['class'] ?? '')),
            'name' => $key,
            'id' => $key
        ];
        if ($error) {
            $class .= ' has-danger';
            $attributes['class'] = ' form-control is-invalid';
        }
        if ($type === 'textarea') {
            $input = $this->textarea($value, $attributes);
        }
        //if  options['options], field of type select
        elseif (array_key_exists('options', $options)) {
            $input = $this->select($value, $options['options'], $attributes);
        } else {
            $input = $this->input($value, $attributes);
        }
        return "<div class=\"" .  $class . "\"><label for=\"$key\">$label</label>$input $error</div>";
    }

    private function getErrorHtml($context, $key)
    {
        //get context and error
        $error = $context['errors'][$key] ?? false;
        if ($error) {
            return  "<small class=\"invalid-feedback\">$error</small>";
        }
        return "";
    }

    /**
     * textarea input
     *
     * @param  mixed $key
     * @param  mixed $value
     * @param  mixed $attributes
     *
     * @return string
     */
    private function textarea(?string $value, array $attributes): string
    {
        return "<textarea " . $this->getHtmlFromArray($attributes) . " >$value</textarea>";
    }

    /**
     * select input
     *
     * @param string|null $value
     * @param array $options
     * @param array $attributes
     * @return void
     */
    private function select(?string $value, array $options, array $attributes)
    {
        //generate htmloption with list options
        $htmlOptions = array_reduce(array_keys($options), function (string $html, string $key) use ($options, $value) {
            $params = ['value' => $key, 'selected' => $key === $value];
            return $html . '<option ' . $this->getHtmlFromArray($params) . '>' . $options[$key] . '</option>';
        }, "");
        return "<select " . $this->getHtmlFromArray($attributes) . ">$htmlOptions</select>";
    }

    /**
     * input
     *
     * @param  mixed $key
     * @param  mixed $value
     * @param  mixed $attributes
     *
     * @return string
     */
    private function input(?string $value, array $attributes): string
    {
        return "<input type=\"text\"  " . $this->getHtmlFromArray($attributes) . " value=\"$value\"/>";
    }

    /**
     * getHtmlFromArray
     *
     * @param  mixed $attributes
     *
     * @return void
     */
    private function getHtmlFromArray(array $attributes)
    {
        $htmlParts = [];
        foreach ($attributes as $key => $value) {
            //if value is a boolean,return just key(use for selected options)
            if ($value === true) {
                $htmlParts[] =  $key;
            } elseif ($value !== false) {
                $htmlParts[] = "$key=\"$value\"";
            }
        }
        return implode(' ', $htmlParts);
    }

    /**
     * convertValue
     *
     * @param  mixed $value
     *
     * @return string
     */
    private function convertValue($value): string
    {
        //if value is datetime, return a format Y-m-d h:i:s
        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        return (string) $value;
    }
}
