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
    protected $allowAnonymous = array('actionIncrementAnswer');

    public function actionSavePoll()
    {
        $this->requirePostRequest();

        $poll = new GtPoll_PollModel();

        $poll->id = craft()->request->getPost('pollId');
        $poll->questionText = craft()->request->getPost('questionText');
        $poll->active = craft()->request->getPost('active');

        $answers = array();

        $position = 0;

        foreach (craft()->request->getPost('answers') as $answerId => $answerText) {

            $answer = new GtPoll_AnswerModel();
            if ($answerId) {
                // we have to store this key as a string in the template, here we convert it back
                $answer->id = (int)str_replace('answer_', '', $answerId);
            }
            $answer->answerText = $answerText[0];
            $answer->position = $position;
            $answers[] = $answer;

            $position++;
        }
        
        if (craft()->gtPoll->savePoll($poll, $answers)) {
            craft()->userSession->setNotice(Craft::t('Poll saved.'));
            $this->redirect('gtpoll');
        } else {
            craft()->userSession->setError(Craft::t('Couldn’t save poll.'));
        }
    }

    public function actionIncrementAnswer()
    {
        $this->requirePostRequest();

        $pollId = craft()->request->getPost('poll');
        $answerId = craft()->request->getPost('poll_' . $pollId);

        if (craft()->gtPoll->incrementAnswer($answerId)) {
            return true;
        } else {
            return false;
        }
    }

    public function actionReset()
    {
        $pollId = craft()->request->getRequiredParam('pollId');
        craft()->gtPoll->resetAnswers($pollId);
        craft()->userSession->setNotice(Craft::t('Poll responses reset.'));
        $this->redirect('gtpoll');
    }
}