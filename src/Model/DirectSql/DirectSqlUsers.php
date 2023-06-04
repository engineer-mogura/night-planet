<?php

namespace App\Model\DirectSql;

use PDO;
use PDOException;
use Cake\ORM\Table;

/**
 *
 */
class DirectSqlUsers extends DirectSql {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    public function shopFavos(int $user_id) {

        $stmt = $this::$conn->prepare(
            'SELECT
                shop_likes.id AS shop_likes_id
                , shop_likes.shop_id AS shop_likes_shop_id
                , shop_likes.user_id AS shop_likes_user_id
                , shop_likes.created AS shop_likes_created
                , JOIN1.*
            FROM
            ( 
                SELECT
                    shops.id AS id
                    , shops.name AS name
                    , shops.area AS area
                    , shops.genre AS genre
                    , shops.dir AS dir
                    , shops.addr21 AS addr21
                    , shops.strt21 AS strt21
                    , shops.created AS created
                    , count(shop_likes.shop_id) AS total 
                FROM
                    shops 
                    INNER JOIN shop_likes 
                        ON shops.id = shop_likes.shop_id 
                WHERE
                    shops.id IN ( 
                        SELECT DISTINCT
                            shops.id AS id 
                        FROM
                            users 
                            INNER JOIN shop_likes 
                                ON shop_likes.user_id = :user_id1 
                            INNER JOIN shops 
                                ON shops.id = shop_likes.shop_id 
                        WHERE
                            shops.status = 1 
                            AND shops.delete_flag = 0 
                            AND users.id = :user_id2 
                    ) 
                GROUP BY
                    shop_likes.shop_id
            ) JOIN1
            INNER JOIN shop_likes
                ON shop_likes.shop_id = JOIN1.id
                AND shop_likes.user_id = :user_id3 
            ORDER BY
                shop_likes.created DESC 
            LIMIT
                :limit_num
            OFFSET
                :offset_num
            '
        );

        $stmt->bindValue('user_id1', $user_id, PDO::PARAM_INT);
        $stmt->bindValue('user_id2', $user_id, PDO::PARAM_INT);
        $stmt->bindValue('user_id3', $user_id, PDO::PARAM_INT);
        //$stmt->execute();
        return $stmt;
    }
}
