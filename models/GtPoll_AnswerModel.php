<?php
/**
 * GT Poll plugin for Craft CMS
 *
 * Answer Model
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

class GtPoll_AnswerModel extends BaseModel
{

    /**
     * Define what is returned when model is converted to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->answerText . ' (' . (string)$this->responses . ' responses)';
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
            'pollId' => AttributeType::Number,
            'answerText' => array(AttributeType::String, 'default' => ''),
            'responses' => AttributeType::Number,
            'position' => AttributeType::Number,
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime,
        );
    }

}