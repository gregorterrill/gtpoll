<?php
/**
 * GT Poll plugin for Craft CMS
 *
 * GtPoll Controller
 *
 *
 * @author    Gregor Terrill
 * @copyright Copyright (c) 2016 Gregor Terrill
 * @link      http://gregorterrill.com
 * @package   GtPoll
 * @since     1.0.0
 */

namespace Craft;

class GtPoll_PollController extends BaseController
{
    /**
     * Only increment answer is available to front-end users
     */
    protected $allowAnonymous = array('actionIncrementAnswer');

    /**
     * Increment an answer's response count
     * @return bool
     */
    public function actionIncrementAnswer()
    {
        $this->requirePostRequest();

        // get POST data
        $pollId = craft()->request->getPost('poll');
        $answerId = craft()->request->getPost('poll_' . $pollId);

        // increment the answer's response count
        if (craft()->gtPoll->incrementAnswer($answerId)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Save a poll and it's answers
     */
    public function actionSavePoll()
    {
        $this->requirePostRequest();

        // create a new poll model and populate it from our POST data
        $poll = new GtPoll_PollModel();
        $poll->id = craft()->request->getPost('pollId');
        $poll->questionText = craft()->request->getPost('questionText');
        $poll->active = craft()->request->getPost('active');

        // initialize our array to hold our answer models and zero-based position
        $answers = array();
        $position = 0;

        // for each answer in the POST data...
        foreach (craft()->request->getPost('answers') as $answerId => $answerText) {

            // ...create a new answer model and populate it
            $answer = new GtPoll_AnswerModel();
            if ($answerId) {
                // we have to store this key as a string in the template, here we convert it back
                $answer->id = (int)str_replace('answer_', '', $answerId);
            }
            $answer->answerText = $answerText[0];
            $answer->position = $position;

            // add the answer model to our array and increment position
            $answers[] = $answer;
            $position++;
        }

        // save the poll with our answers and show the user feedback
        if (craft()->gtPoll->savePoll($poll, $answers)) {
            craft()->userSession->setNotice(Craft::t('Poll saved.'));
            $this->redirect('gtpoll');
        } else {
            craft()->userSession->setError(Craft::t('Couldn’t save poll.'));
        }
    }

    /**
     * Reset all of a poll's answers' response counts
     */
    public function actionReset()
    {
        $pollId = craft()->request->getRequiredParam('pollId');
        craft()->gtPoll->resetAnswers($pollId);
        craft()->userSession->setNotice(Craft::t('Poll responses reset.'));
        $this->redirect('gtpoll');
    }
}