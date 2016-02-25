<?php
/**
 * GT Poll plugin for Craft CMS
 *
 * GtPoll_Poll FieldType
 *
 *
 * @author    Gregor Terrill
 * @copyright Copyright (c) 2016 Gregor Terrill
 * @link      http://gregorterrill.com
 * @package   GtPoll
 * @since     1.0.0
 */

namespace Craft;

class GtPoll_PollFieldType extends BaseFieldType
{
    /**
     * Returns the name of the fieldtype.
     * @return mixed
     */
    public function getName()
    {
        return Craft::t('Poll');
    }

    /**
     * Returns the content attribute config.
     * @return mixed
     */
    public function defineContentAttribute()
    {
        return AttributeType::Mixed;
    }

    /**
     * Returns the field's input HTML.
     *
     * @param string $name
     * @param mixed  $value
     * @return string
     */
    public function getInputHtml($name, $value)
    {
        if (!$value) {
            $value = new GtPoll_PollModel();
        }

        $id = craft()->templates->formatInputId($name);
        $namespacedId = craft()->templates->namespaceInputId($id);

        //variables to pass to the template
        $variables = array(
            'id' => $id,
            'name' => $name,
            'namespaceId' => $namespacedId,
            'values' => $value
        );

        return craft()->templates->render('gtpoll/fields/GtPoll_PollFieldType.twig', $variables);
    }

    /**
     * Prep the field value to be saved in the database
     * @param mixed $value 
     * @return int
     */
    public function prepValueFromPost($value)
    {
        $value = (int)str_replace('poll_', '', $value);
        return $value;
    }

}