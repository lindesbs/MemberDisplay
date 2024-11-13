<?php

namespace lindesbs\MemberDisplay\ContaoClasses;

use ReflectionClass;
use ReflectionProperty;
class ContaoDCA
{
    private const TYPE_MAPPING = [
        'string' => ['inputType' => 'text', 'sql' => "varchar(255) NOT NULL default ''"],
        'int' => ['inputType' => 'text', 'sql' => "int(10) unsigned NOT NULL default '0'"],
        'float' => ['inputType' => 'text', 'sql' => "decimal(10,2) NOT NULL default '0.00'"],
        'bool' => ['inputType' => 'checkbox', 'sql' => "char(1) NOT NULL default ''"],
        'array' => ['inputType' => 'listWizard', 'sql' => "blob NULL"],
        'datetime' => ['inputType' => 'text', 'sql' => "varchar(10) NOT NULL default ''"],
        'text' => ['inputType' => 'textarea', 'sql' => "text NULL"],
    ];

    public static function generate(string $entityClass): array
    {
        if (!class_exists($entityClass)) {
            throw new \InvalidArgumentException("Class {$entityClass} does not exist");
        }

        $reflection = new ReflectionClass($entityClass);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
        $docComment = $reflection->getDocComment();

        $fields = [];
        $paletteItems = [];
        $currentDivider = null;

        foreach ($properties as $property) {
            $propertyDoc = $property->getDocComment();
            $divider= self::extractDivider($propertyDoc);

            if ($divider !== null) {
                if (!empty($paletteItems)) {
                    $paletteItems[] = ';';
                }
                $paletteItems[] = '{' . $divider . '_legend},';
                $currentDivider = $divider;
            }

            $type = self::getPropertyType($property);
            $mapping = self::getTypeMapping($type);
            $propertyName = $property->getName();

            $fields[$propertyName] = [
                'label' => self::generateLabel($propertyName),
                'inputType' => $mapping['inputType'],
                'eval' => self::generateEval($type),
                'sql' => $mapping['sql']
            ];

            $paletteItems[] = $propertyName;
        }

        return [
            'fields' => $fields,
            'palettes' => [
                'default' => implode(',', $paletteItems)
            ]
        ];
    }

    private static function extractDivider(?string $docComment): ?string
    {
        if ($docComment === null) {
            return null;
        }

        if (preg_match('/--(divider::([^-]+))--/', $docComment, $matches)) {
            return trim($matches[2]);
        }

        return null;
    }

    private static function getPropertyType(ReflectionProperty $property): string
    {
        $type = $property->getType();
        if ($type === null) {
            return 'string';
        }

        return $type->getName();
    }

    private static function getTypeMapping(string $type): array
    {
        return self::TYPE_MAPPING[$type] ?? self::TYPE_MAPPING['string'];
    }

    private static function generateLabel(string $propertyName): array
    {
        $label = ucfirst(str_replace('_', ' ', $propertyName));
        return [$label, $label];
    }

    private static function generateEval(string $type): array
    {
        $eval = [
            'mandatory' => false,
            'tl_class' => 'w50'
        ];

        switch ($type) {
            case 'bool':
                $eval['tl_class'] = 'w50 m12';
                break;
            case 'text':
                $eval['tl_class'] = 'clr';
                $eval['rte'] = 'tinyMCE';
                break;
            case 'array':
                $eval['tl_class'] = 'clr';
                break;
            case 'datetime':
                $eval['rgxp'] = 'datim';
                $eval['datepicker'] = true;
                break;
        }

        return $eval;
    }
}
