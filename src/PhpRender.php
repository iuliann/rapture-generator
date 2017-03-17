<?php

namespace Rapture\Generator;

/**
 * PHP render class
 *
 * @package Rapture\Generator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class PhpRender
{
    /**
     * Render class
     *
     * @param PhpClass $class PhpClass object to render
     * @param bool $openTags Whether to return open-tag too
     * @param string $tab Tab replacement - default is 4 spaces
     *
     * @return string
     */
    public static function renderClass(PhpClass $class, $openTags = true, $tab = '    ')
    {
        $template = '{{open-tag}}

{{namespace}}

{{uses}}

{{comment}}
{{final}} {{abstract}} {{class}} {{name}} {{extends}}  {{implements}}
{
{{traits}}
{{constants}}
{{properties}}
{{methods}}
}
';

        $uses = array_map(
            function ($value) {
                return 'use ' . $value[0] . ($value[1] !== null ? ' as ' . $value[1] : '') . ";\n";
            },
            $class->getUses()
        );

        $traits = array_map(
            function ($value) {
                return "\tuse {$value};\n";
            },
            $class->getTraits()
        );

        $constants = '';
        foreach ($class->getConstants() as $name => $value) {
            $value = var_export($value, true);
            $constants .= "\tconst {$name} = {$value};\n";
        }

        $properties = '';
        foreach ($class->getProperties() as $property) {
            $properties .= self::renderProperty($property) . "\n";
        }

        $methods = '';
        foreach ($class->getMethods() as $method) {
            $methods .= self::renderMethod($method, $tab) . "\n\n";
        }

        $replace = [
            "{{open-tag}}\n" => $openTags ? "<?php\n" : '',
            '{{namespace}}' => $class->getNamespace() ? 'namespace ' . $class->getNamespace() . ';' : '',
            '{{comment}}' => self::renderComment($class->getComment(), ''),
            '{{final}} ' => $class->isFinal() ? 'final ' : '',
            '{{abstract}} ' => $class->isAbstract() ? 'abstract ' : '',
            '{{class}} ' => $class->isTrait() ? 'trait ' : 'class ',
            '{{name}}' => $class->getName(),
            '{{extends}} ' => $class->getExtends() ? 'extends ' . $class->getExtends() : '',
            '{{implements}}' => $class->getImplements() ? 'implements ' . implode(', ', $class->getImplements()) : '',
            '{{uses}}' => implode('', $uses),
            '{{traits}}' => implode('', $traits),
            '{{constants}}' => $constants,
            '{{properties}}' => $properties,
            '{{methods}}' => rtrim($methods),
            "\t" => $tab
        ];

        return preg_replace("#\n{3,}#m", "\n\n", str_replace(array_keys($replace), $replace, $template));
    }

    /**
     * Render PhpMethod
     *
     * @param PhpMethod $method PhpMethod object
     * @param string $tab Tab replacement - default is four spaces
     *
     * @return string
     */
    public static function renderMethod(PhpMethod $method, $tab = '    ')
    {
        $template = "\t{{visibility}} {{static}}function {{name}}({{params}}){{return}}\n\t{\n{{body}}\n\t}";

        $params = [];
        foreach ($method->getParams() as $name => $param) {
            list($typeHint, $default) = $param + [null, null];
            $params[] = ($typeHint ? "{$typeHint} $" : '$') . $name . ($default ? " = {$default}" : '');
        }

        $body = '';
        $lines = explode("\n", $method->getBody());
        foreach ($lines as $line) {
            $body .= strlen($line)
                ? $tab . $tab . $line . "\n"
                : "\n";
        }

        $replace = [
            "{{visibility}}"=> $method->getVisibility(),
            "{{static}}" => $method->isStatic() ? 'static ' : '',
            "{{return}}" => $method->getReturn() ? ":{$method->getReturn()}" : '',
            "{{name}}" => $method->getName(),
            "{{params}}" => implode(', ', $params),
            "{{body}}" => rtrim($body),
            "\t" => $tab
        ];

        $comment = self::renderComment($method->getComment(), $tab);

        return "\n"
        . ($comment ? $comment . "\n" : '')
        . preg_replace("#\n{3,}#m", "\n\n", str_replace(array_keys($replace), $replace, $template));
    }

    /**
     * Render class property
     *
     * @param PhpProperty $property PhpProperty object
     *
     * @return string
     */
    public static function renderProperty(PhpProperty $property)
    {
        $template = "\t{{visibility}} {{static}}{{name}}{{value}};\n";

        $replace = [
            '{{visibility}}' => $property->getVisibility(),
            '{{static}}' => $property->isStatic() ? 'static ' : '',
            '{{name}}' => '$' . $property->getName(),
            '{{value}}' => strlen($property->getValue()) ? ' = ' . $property->getValue() : ''
        ];

        return self::renderComment($property->getComment())
        . "\n"
        . preg_replace("#\n{3,}#m", "\n\n", str_replace(array_keys($replace), $replace, $template));
    }

    /**
     * Render comment
     *
     * @param PhpComment $comment PhpComment object
     * @param string $prefix Prefix for each line before *
     *
     * @return string
     */
    public static function renderComment(PhpComment $comment = null, $prefix = "\t")
    {
        if ($comment === null || $comment->isEmpty()) {
            return '';
        }

        switch ($comment->getType()) {
            case PhpComment::SINGLE_LINE:
                return $prefix . '// ' . $comment->getAsSingleLine();
            case PhpComment::MULTI_LINE:
                $lines = $comment->getLines();
                foreach ($lines as $index => $line) {
                    $lines[$index] = $prefix . ' * ' . $line;
                }
                return $prefix . "/*\n" . implode("\n", $lines) . "\n{$prefix}" . ' */';
            default:
                $lines = $comment->getLines();
                foreach ($lines as $index => $line) {
                    $lines[$index] = $prefix . ' * ' . $line;
                }
                return $prefix . "/**\n" . implode("\n", $lines) . "\n{$prefix}" . ' */';
        }
    }
}
