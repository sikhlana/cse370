<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Model;

class MovieFeedback extends Model
{
    public function getFeedbackById($feedbackId)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM movie_feedback
            WHERE feeedback_id = ?', $feedbackId
        );
    }

    public function getFeedbackAvgForMovie($movieId)
    {
        return $this->_getDb()->fetchOne(
            'SELECT AVG(rating)
            FROM movie_feedback
            WHERE movie_id = ?', $movieId
        );
    }

    public function getAllFeedbackForMovie($movieId)
    {
        return $this->fetchAllKeyed(
            'SELECT movie_feedback.*, user.username
            FROM movie_feedback
            INNER JOIN user
              ON (user.user_id = movie_feedback.user_id)
            WHERE movie_feedback.movie_id = ?', 'feedback_id', $movieId
        );
    }

    public function canPostFeedback($userId, $movieId)
    {
        $hasPurchased = $this->_getDb()->fetchOne(
            'SELECT COUNT(*)
            FROM invoice
            INNER JOIN ticket
              ON (ticket.order_id = invoice.order_id)
            INNER JOIN showtime
              ON (ticket.showtime_id = showtime.showtime_id AND showtime.movie_id = ?)
            WHERE invoice.user_id = ?', array($movieId, $userId)
        );

        if (!$hasPurchased)
        {
            return false;
        }

        return !$this->_getDb()->fetchOne(
            'SELECT COUNT(*)
            FROM movie_feedback
            WHERE user_id = ?
            AND movie_id = ?', array($userId, $movieId)
        );
    }

    public function insert(array $feedback)
    {
        $stmt = $this->_getDb()->query(
            'INSERT INTO movie_feedback
            (movie_id, user_id, comment, rating)
            VALUES
            (?, ?, ?, ?)', array($feedback['movie_id'], $feedback['user_id'], $feedback['comment'], $feedback['rating'])
        );

        if ($stmt->rowCount())
        {
            return $this->getFeedbackById($this->_getDb()->lastInsertId());
        }

        return false;
    }

    public function prepareFeedback(array $feedback)
    {
        $parts = explode('@', $feedback['username'], 2);
        $feedback['obfuscatedUsername'] = $parts[0];

        return $feedback;
    }

    public function prepareFeedbacks(array $feedbacks)
    {
        foreach ($feedbacks as &$feedback)
        {
            $feedback = $this->prepareFeedback($feedback);
        }

        return $feedbacks;
    }
}