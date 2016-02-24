<?php
/**
 * GT Poll plugin for Craft CMS
 *
 * Poll Model
 *
 * --snip--
 * Models are containers for data. Just about every time information is passed between services, controllers, and
 * templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 * --snip--
 *
 * @author    Gregor Terrill
 * @copyright Copyright (c) 2016 Gregor Terrill
 * @link      http://gregorterrill.com
 * @package   GtPoll
 * @since     1.0.0
 */

namespace Craft;

class GtPoll_PollModel extends BaseModel
{

    /**
     * Define what is returned when model is converted to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->questionText;
    }

    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'questionText' => array(AttributeType::String, 'default' => ''),
            'active' => AttributeType::Bool,
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime,
        );
    }

}