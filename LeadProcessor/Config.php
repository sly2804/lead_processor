<?php

namespace LeadProcessor;

/**
 * Config
 */
class Config
{
    const PROCESSORS_DIRECTORY = __NAMESPACE__ . '\\Processors\\';
    const CATEGORIES_STATUS = [
        'Buy auto' => false,
        'Buy house' => true,
        'Get loan' => true,
        'Cleaning' => true,
        'Learning' => true,
        'Car wash' => true,
        'Repair smth' => true,
        'Barbershop' => true,
        'Pizza' => true,
        'Car insurance' => true,
        'Life insurance' => true
    ];

    /**
     * return categories with current active status
     * @return array
     */
    public static function getCategories() : array
    {
        return self::CATEGORIES_STATUS;
    }

    /**
     * return categories with their handlers
     * @return array
     */
    public static function getConfigCategories() : array
    {
        $config = [];
        foreach (self::CATEGORIES_STATUS as $category => $status) {
            $config[$category] = self::PROCESSORS_DIRECTORY . str_replace(' ', '', mb_convert_case($category,MB_CASE_TITLE)) . 'Processor';
        }
        return $config;
    }
}
