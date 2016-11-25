<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Model;

class MovieWishlist extends Model
{
    public function getWishlistForUserDisplay($userId)
    {
        return $this->fetchAllKeyed(
            'SELECT movie.*, movie_wishlist.*
            FROM movie
            INNER JOIN movie_wishlist
              ON (movie_wishlist.movie_id = movie.movie_id)
            WHERE user_id = ?
            AND is_notified = 0', 'movie_id', $userId
        );
    }

    public function hasMovieInWishlist($userId, $movieId)
    {
        return $this->_getDb()->fetchOne(
            'SELECT COUNT(*)
            FROM movie_wishlist
            WHERE movie_id = ?
            AND user_id = ?', array($movieId, $userId)
        );
    }

    public function addMovieToWishlist($userId, $movieId)
    {
        $stmt = $this->_getDb()->query(
            'INSERT IGNORE INTO movie_wishlist
            (movie_id, user_id, is_notified)
            VALUES
            (?, ?, 0)', array($movieId, $userId)
        );

        return $stmt->rowCount() ? true : false;
    }

    public function deleteWishlist($movieId)
    {
        $this->_getDb()->query(
            'DELETE FROM movie_wishlist
            WHERE movie_id = ?', $movieId
        );
    }
}