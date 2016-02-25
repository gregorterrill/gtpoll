<?php
/**
 * GT Poll plugin for Craft CMS
 *
 * GtPoll Service
 *
 *
 * @author    Gregor Terrill
 * @copyright Copyright (c) 2016 Gregor Terrill
 * @link      http://gregorterrill.com
 * @package   GtPoll
 * @since     1.0.0
 */

namespace Craft;

class GtPollService extends BaseApplicationComponent
{

    /**
     * Save a poll
     * @param GtPoll_PollModel $poll
     * @param array $answers
     * @return bool
     */
    public function savePoll(GtPoll_PollModel $poll, array $answers)
    {
        $newPoll = true;

        if ($poll->validate()) {

            if ($poll->id) {
                $pollRecord = GtPoll_PollRecord::model()->findById($poll->id);
                $newPoll = false;

                if (!$pollRecord) {
                    throw new Exception(Craft::t('No poll exists with the ID “{id}”', array('id' => $poll->id)));
                }
            } else {
                $pollRecord = new GtPoll_PollRecord();
            }

            $pollRecord->questionText = $poll->questionText;
            $pollRecord->active = $poll->active;

            if ($pollRecord->save()) {

                //update all the answers
                foreach ($answers as $answer) {
                    
                    if ($answer->id && !$newPoll) {
                        $answerRecord = GtPoll_AnswerRecord::model()->findById($answer->id);
                    } else {
                        $answerRecord = new GtPoll_AnswerRecord();
                    }
                    $answerRecord->position = $answer->position;
                    $answerRecord->answerText = $answer->answerText;
                    $answerRecord->pollId = $pollRecord->id;

                    $answerRecord->save();
                }
                return true;
            }
        }

        return false;
    }

    /**
     * Returns all polls
     * @param bool $activeOnly
     * @return GtPoll_PollModel
     */
    public function getPolls($activeOnly)
    {
        // get record from DB
        if ($activeOnly) {
            $pollRecords = GtPoll_PollRecord::model()->findAllByAttributes(array('active' => 1));
        } else {
            $pollRecords = GtPoll_PollRecord::model()->findAll();
        }       

        return $pollRecords;
    }

    /**
     * Returns single poll
     * @param int $pollId
     * @return GtPoll_PollModel
     */
    public function getPoll($pollId)
    {
        // create new model
        $pollModel = new GtPoll_PollModel();

        // get record from DB
        $pollRecord = GtPoll_PollRecord::model()->findById($pollId);
        
        if ($pollRecord)
        {
            // populate model from record
            $pollModel = GtPoll_PollModel::populateModel($pollRecord);
        }

        return $pollModel;
    }

    /**
     * Returns all answers for a poll
     * @param int $pollId
     * @return array
     */
    public function getAnswers($pollId)
    {
        // get record from DB
        $answerRecords = GtPoll_AnswerRecord::model()->findAllByAttributes(
            array('pollId' => $pollId), 
            array('order' => 'position asc')
        );

        $answers = array();

        if ($answerRecords) {
        
            foreach ($answerRecords as $answerRecord)
            {                
                $answers[] = $answerRecord;            
            }
        }

        return $answers;
    }

    /**
     * Returns response total for a poll
     * @param int $pollId
     * @return int
     */
    public function getResponses($pollId)
    {
        // get record from DB
        $answerRecords = GtPoll_AnswerRecord::model()->findAllByAttributes(array('pollId' => $pollId));

        $responses = 0;

        if ($answerRecords) {
        
            foreach ($answerRecords as $answerRecord)
            {
                $responses += $answerRecord->responses;
            }
        }

        return $responses;
    }

    /**
     * Increment answer response count
     * @param int $answerId
     */
    public function incrementAnswer($answerId)
    {
         // get record from DB
        $answerRecord = GtPoll_AnswerRecord::model()->findById($answerId);

        // if exists then increment responses
        if ($answerRecord)
        {
            $answerRecord->setAttribute('responses', $answerRecord->getAttribute('responses') + 1);
            $answerRecord->save();
        }
    }

    /**
     * Reset all the answer response counts for a given poll
     * @param int $pollId
     */
    public function resetAnswers($pollId)
    {
         // get records from DB
        $answerRecords = GtPoll_AnswerRecord::model()->findAllByAttributes(array('pollId' => $pollId));

        foreach ($answerRecords as $answerRecord) {
            // if exists then clear responses
            if ($answerRecord)
            {
                $answerRecord->setAttribute('responses', 0);
                $answerRecord->save();
            }
        }
    }

}