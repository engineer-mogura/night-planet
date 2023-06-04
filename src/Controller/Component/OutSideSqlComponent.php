<?php

namespace App\Controller\Component;

use Cake\Log\Log;
use Cake\Controller\Component;

class OutSideSqlComponent extends Component
{
    /**
     * 店舗レビューを返す
     *
     * @return string
     */
    public function getReview()
    {
        $sql = 'SELECT 
                        r2.cost_star
                        , r2.atmosphere_star
                        , r2.customer_star
                        , r2.staff_star
                        , r2.cleanliness_star
                        , (r2.cost_star + r2.atmosphere_star + r2.customer_star
                        + r2.staff_star + r2.cleanliness_star) / 5 as total_review
                FROM
                    (SELECT
                        (r1.cost_1 * 1 + r1.cost_2 * 2 + r1.cost_3 * 3
                        + r1.cost_4 * 4 + r1.cost_5 * 5)
                        / (r1.cost_1 + r1.cost_2 + r1.cost_3 + r1.cost_4 + r1.cost_5) as cost_star
                        , (r1.atmosphere_1 * 1 + r1.atmosphere_2 * 2 + r1.atmosphere_3 * 3
                        + r1.atmosphere_4 * 4 + r1.atmosphere_5 * 5)
                        / (r1.atmosphere_1 + r1.atmosphere_2 + r1.atmosphere_3
                        + r1.atmosphere_4 + r1.atmosphere_5) as atmosphere_star
                        , (r1.customer_1 * 1 + r1.customer_2 * 2 + r1.customer_3 * 3
                        + r1.customer_4 * 4 + r1.customer_5 * 5)
                        / (r1.customer_1 + r1.customer_2 + r1.customer_3
                        + r1.customer_4 + r1.customer_5) as customer_star
                        , (r1.staff_1 * 1 + r1.staff_2 * 2 + r1.staff_3 * 3
                        + r1.staff_4 * 4 + r1.staff_5 * 5)
                        / (r1.staff_1 + r1.staff_2 + r1.staff_3
                        + r1.staff_4 + r1.staff_5) as staff_star
                        , (r1.cleanliness_1 * 1 + r1.cleanliness_2 * 2 + r1.cleanliness_3 * 3
                        + r1.cleanliness_4 * 4 + r1.cleanliness_5 * 5)
                        / (r1.cleanliness_1 + r1.cleanliness_2 + r1.cleanliness_3
                        + r1.cleanliness_4 + r1.cleanliness_5) as cleanliness_star


                    FROM( 
                        SELECT
                            COUNT(cost = 1 OR NULL) AS cost_1,
                            COUNT(cost = 2 OR NULL) AS cost_2,
                            COUNT(cost = 3 OR NULL) AS cost_3,
                            COUNT(cost = 4 OR NULL) AS cost_4,
                            COUNT(cost = 5 OR NULL) AS cost_5,
                            COUNT(atmosphere = 1 OR NULL) AS atmosphere_1,
                            COUNT(atmosphere = 2 OR NULL) AS atmosphere_2,
                            COUNT(atmosphere = 3 OR NULL) AS atmosphere_3,
                            COUNT(atmosphere = 4 OR NULL) AS atmosphere_4,
                            COUNT(atmosphere = 5 OR NULL) AS atmosphere_5,
                            COUNT(customer = 1 OR NULL) AS customer_1,
                            COUNT(customer = 2 OR NULL) AS customer_2,
                            COUNT(customer = 3 OR NULL) AS customer_3,
                            COUNT(customer = 4 OR NULL) AS customer_4,
                            COUNT(customer = 5 OR NULL) AS customer_5,
                            COUNT(staff = 1 OR NULL) AS staff_1,
                            COUNT(staff = 2 OR NULL) AS staff_2,
                            COUNT(staff = 3 OR NULL) AS staff_3,
                            COUNT(staff = 4 OR NULL) AS staff_4,
                            COUNT(staff = 5 OR NULL) AS staff_5,
                            COUNT(cleanliness = 1 OR NULL) AS cleanliness_1,
                            COUNT(cleanliness = 2 OR NULL) AS cleanliness_2,
                            COUNT(cleanliness = 3 OR NULL) AS cleanliness_3,
                            COUNT(cleanliness = 4 OR NULL) AS cleanliness_4,
                            COUNT(cleanliness = 5 OR NULL) AS cleanliness_5
                        FROM
                            reviews reviews
                        WHERE
                            shop_id = ?
                        ) r1
                    ) r2
                ';
        return $sql;
    }
}