<?php
/**
 * GT Poll plugin for Craft CMS
 *
 * GT Poll Variable
 *
 * --snip--
 * Craft allows plugins to provide their own template variables, accessible from the {{ craft }} global variable
 * (e.g. {{ craft.pluginName }}).
 *
 * https://craftcms.com/docs/plugins/variables
 * --snip--
 *
 * @author    Gregor Terrill
 * @copyright Copyright (c) 2016 Gregor Terrill
 * @link      http://gregorterrill.com
 * @package   GtPoll
 * @since     1.0.0
 */

namespace Craft;

class GtPollVariable
{
    /**
     * Get the name of the plugin
     */
    public function getPluginName()
    {
        return craft()->plugins->getPlugin('gtPoll')->getName();
    }

    /**
     * Return all active polls
     */
    public function getActivePolls()
    {
        return craft()->gtPoll->getPolls(true);
    }

    /**
     * Return all polls, including inactive ones
     */
    public function getPolls()
    {
        return craft()->gtPoll->getPolls(false);
    }

    /**
     * Return a poll
     */
    public function getPoll($pollId)
    {
        return craft()->gtPoll->getPoll($pollId);
    }

    /**
     * Return list of answers for a poll
     */
    public function getAnswers($pollId)
    {
        return craft()->gtPoll->getAnswers($pollId);
    }

    /**
     * Return total responses for a poll
     */
    public function getResponses($pollId)
    {
        return craft()->gtPoll->getResponses($pollId);
    }
}