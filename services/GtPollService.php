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

        // make sure the model is valid
        if ($poll->validate()) {

            // if the poll id already exists, we're updating an existing record...
            if ($poll->id) {
                $pollRecord = GtPoll_PollRecord::model()->findById($poll->id);
                $newPoll = false;

                if (!$pollRecord) {
                    throw new Exception(Craft::t('No poll exists with the ID “{id}”', array('id' => $poll->id)));
                }
            // ...otherwise we'll create a new one
            } else {
                $pollRecord = new GtPoll_PollRecord();
            }

            // set the text and status of the poll
            $pollRecord->questionText = $poll->questionText;
            $pollRecord->active = $poll->active;

            // save the record, so we can save our answers with the relationship
            if ($pollRecord->save()) {

                // for each answer...
                foreach ($answers as $answer) {

                    // make sure the model is valid
                    if ($answer->validate()) {
                    
                        // ...if the answer already exists, and this is an existing poll, we'll update it
                        if ($answer->id && !$newPoll) {
                            $answerRecord = GtPoll_AnswerRecord::model()->findById($answer->id);
                        // ...otherwise we'll create a new answer
                        } else {
                            $answerRecord = new GtPoll_AnswerRecord();
                        }

                        // set the answer text, position, and poll, then save it
                        $answerRecord->position = $answer->position;
                        $answerRecord->answerText = $answer->answerText;
                        $answerRecord->pollId = $pollRecord->id;

                        $answerRecord->save();
                    }
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Returns all polls
     * @param bool $activeOnly
     * @return array
     */
    public function getPolls($activeOnly)
    {
        // get records from DB
        if ($activeOnly) {
            $pollRecords = GtPoll_PollRecord::model()->findAllByAttributes(array('active' => 1));
        } else {
            $pollRecords = GtPoll_PollRecord::model()->findAll();
        }

         // create an array we'll use to store the poll models
        $polls = array();

        // if we have records...
        if ($pollRecords) {
            // ...create a model for each, populate it, and add it to the array
            foreach ($pollRecords as $pollRecord) {
                $pollModel = new GtPoll_PollModel();
                $pollModel = GtPoll_PollModel::populateModel($pollRecord);
                $polls[] = $pollModel;            
            }
        }

        // return the array of populated poll models
        return $polls;
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
        
        // if the record exists, populate model from record
        if ($pollRecord) {            
            $pollModel = GtPoll_PollModel::populateModel($pollRecord);
        }

        // return the populated poll model
        return $pollModel;
    }

    /**
     * Returns all answers for a poll
     * @param int $pollId
     * @return array
     */
    public function getAnswers($pollId)
    {
        // get records from DB
        $answerRecords = GtPoll_AnswerRecord::model()->findAllByAttributes(
            array('pollId' => $pollId), 
            array('order' => 'position asc')
        );

        // create an array we'll use to store the answer models
        $answers = array();

        // if we have records...
        if ($answerRecords) {
            // ...create a model for each, populate it, and add it to the array
            foreach ($answerRecords as $answerRecord) {
                $answerModel = new GtPoll_AnswerModel();
                $answerModel = GtPoll_AnswerModel::populateModel($answerRecord);
                $answers[] = $answerModel;            
            }
        }

        // return the array of populated answer models
        return $answers;
    }

    /**
     * Returns response total for a poll
     * @param int $pollId
     * @return int
     */
    public function getResponses($pollId)
    {
        $responses = 0;

        // get all answer records from DB that match this poll
        $answerRecords = GtPoll_AnswerRecord::model()->findAllByAttributes(array('pollId' => $pollId));

        // if we have records...
        if ($answerRecords) {
            //...loop through each and sum their response counts
            foreach ($answerRecords as $answerRecord) {
                $responses += $answerRecord->responses;
            }
        }

        // return the sum of all responses
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

        // if the record exists...
        if ($answerRecord) {
            //...increment the responses and save
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
        // get all answer records from DB that match this poll
        $answerRecords = GtPoll_AnswerRecord::model()->findAllByAttributes(array('pollId' => $pollId));

        // if we have records...
        if ($answerRecords) {
            // ...loop through all the records and clear their responses
            foreach ($answerRecords as $answerRecord) {
                $answerRecord->setAttribute('responses', 0);
                $answerRecord->save();
            }
        }
    }

}