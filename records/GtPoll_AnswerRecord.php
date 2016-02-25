<?php
/**
 * GT Poll plugin for Craft CMS
 *
 * Answer Record
 *
 *
 * @author    Gregor Terrill
 * @copyright Copyright (c) 2016 Gregor Terrill
 * @link      http://gregorterrill.com
 * @package   GtPoll
 * @since     1.0.0
 */

namespace Craft;

class GtPoll_AnswerRecord extends BaseRecord
{
    /**
     * Returns the name of the database table the model is associated with (sans table prefix). By convention,
     * tables created by plugins should be prefixed with the plugin name and an underscore.
     * @return string
     */
    public function getTableName()
    {
        return 'gtpoll_answer';
    }

    /**
     * Returns an array of attributes which map back to columns in the database table.
     * @access protected
     * @return array
     */
   protected function defineAttributes()
    {
        return array(
            'answerText' => array(AttributeType::String, 'default' => ''),
            'responses'  => array(AttributeType::Number, 'default' => 0),
            'position'   => array(AttributeType::Number, 'default' => 0),
        );
    }

    /**
     * If your record should have any relationships with other tables, you can specify them with the
     * defineRelations() function
     * @return array
     */
    public function defineRelations()
    {
        return array(
            'poll' => array(static::BELONGS_TO, 'GtPoll_PollRecord', 'required' => true, 'onDelete' => static::CASCADE)
        );
    }

     /**
     * Define table indexes
     * @return array
     */
    public function defineIndexes()
    {
        return array(
            array('columns' => array('pollId'))
        );
    }
}