<?php

namespace Framework\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('field', [$this, 'field'], ['is_safe' => ['html'], 'needs_context' => true])
        ];
    }

    public function field($context, string $key, $value, ?string $label = null, array $options = []): string
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
            'id' => $key,
        ];
        $invalid =  "<div class=\"invalid-feedback\">Ce champ est obligatoire.</div>";

        if (isset($options['required'])) {
            $attributes['required'] = $options['required'];
        }

        if (isset($options['pattern'])) {
            $attributes['pattern'] = $options['pattern'];
            $invalid = "<div class=\"invalid-feedback\">Merci de renseigner un email valide.</div>";
        }

        if ($error) {
            $class .= ' has-danger';
            $attributes['class'] = ' form-control is-invalid';
            $invalid = "";
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

        return "<div class=\"" .  $class . "\">
                    <label for=\"$key\">$label</label>
                    $input $error
                    $invalid
                </div>";
    }

    private function getErrorHtml($context, $key):string
    {
        //get context and error
        $error = $context['errors'][$key] ?? false;

        if ($error) {
            return  "<small class=\"invalid-feedback\">$error</small>";
        }

        return "";
    }

    private function textarea(?string $value, array $attributes): string
    {
        return "<textarea " . $this->getHtmlFromArray($attributes) . " >$value</textarea>";
    }

    private function select(?string $value, array $options, array $attributes):string
    {
        //generate htmloption with list options
        $htmlOptions = array_reduce(array_keys($options), function (string $html, string $key) use ($options, $value) {
            $params = ['value' => $key, 'selected' => $key === $value];
            return $html . '<option ' . $this->getHtmlFromArray($params) . '>' . $options[$key] . '</option>';
        }, "");

        return "<select " . $this->getHtmlFromArray($attributes) . ">$htmlOptions</select>";
    }

    private function input(?string $value, array $attributes): string
    {
        return "<input type=\"text\"  " . $this->getHtmlFromArray($attributes) . " value=\"$value\"/>";
    }

    private function getHtmlFromArray(array $attributes):string
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

    private function convertValue($value): string
    {
        //if value is datetime, return a format Y-m-d h:i:s
        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        
        return (string) $value;
    }
}
