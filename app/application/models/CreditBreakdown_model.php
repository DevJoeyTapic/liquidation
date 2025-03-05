<?php
class CreditBreakdown_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

   public function get_credit_breakdown($user_id) {
        $sql = 'SELECT
                    l.vessel_name,
                    l.voyno,
                    i.currency,
                    l.exrate,
                    ROUND(
                        SUM(
                            CASE 
                                WHEN i.currency = "PHP" THEN i.actual_amount
                                WHEN i.currency = "USD" THEN i.actual_amount * l.exrate
                                ELSE 0
                            END
                        ), 2
                    ) AS due_agent_php,
                    ROUND(
                        SUM(
                            CASE 
                                WHEN i.currency = "PHP" THEN i.actual_amount / l.exrate
                                WHEN i.currency = "USD" THEN i.actual_amount
                                ELSE 0
                            END
                        ), 2
                    ) AS due_agent_usd,
                    ROUND(
                        SUM(
                            CASE 
                                WHEN i.currency = "PHP" THEN i.VARIANCE
                                WHEN i.currency = "USD" THEN i.VARIANCE * l.exrate
                                ELSE 0
                            END
                        ), 2
                    ) AS due_wallem_php,
                    ROUND(
                        SUM(
                            CASE 
                                WHEN i.currency = "PHP" THEN i.VARIANCE / l.exrate
                                WHEN i.currency = "USD" THEN i.VARIANCE
                                ELSE 0
                            END
                        ), 2
                    ) AS due_wallem_usd
                FROM tbl_agent_liquidation_items AS i
                JOIN tbl_agent_liquidation AS l
                    ON i.transno = l.transno
                WHERE i.status = 4
                    AND l.user_id = ?
                GROUP BY l.vessel_name, l.voyno;';
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
   }
   public function get_total_php($user_id) {
        $sql = 'SELECT
                SUM(due_agent_php) AS total_due_agent_php,
                SUM(due_wallem_php) AS total_due_wallem_php
                FROM (
                SELECT
                    l.vessel_name,
                    l.voyno,
                    i.currency,
                    l.exrate,
                    ROUND(
                        SUM(
                            CASE 
                                WHEN i.currency = "PHP" THEN i.actual_amount
                                WHEN i.currency = "USD" THEN i.actual_amount * l.exrate
                                ELSE 0
                            END
                        ), 2
                    ) AS due_agent_php,
                    ROUND(
                        SUM(
                            CASE 
                                WHEN i.currency = "PHP" THEN i.VARIANCE
                                WHEN i.currency = "USD" THEN i.VARIANCE * l.exrate
                                ELSE 0
                            END
                        ), 2
                    ) AS due_wallem_php
                FROM tbl_agent_liquidation_items AS i
                JOIN tbl_agent_liquidation AS l
                    ON i.transno = l.transno
                WHERE i.status = 4
                    AND l.user_id = ?
                GROUP BY l.vessel_name, l.voyno
                ) AS subquery;
                ';
        $query = $this->db->query($sql, array($user_id));
        return $query->row();
   }
   public function get_total_usd($user_id) {
        $sql='SELECT
                SUM(due_agent_usd) AS total_due_agent_usd,
                SUM(due_wallem_usd) AS total_due_wallem_usd
                FROM (
                SELECT
                    l.vessel_name,
                    l.voyno,
                    i.currency,
                    l.exrate,
                    ROUND(
                        SUM(
                            CASE 
                                WHEN i.currency = "PHP" THEN i.actual_amount / l.exrate
                                WHEN i.currency = "USD" THEN i.actual_amount
                                ELSE 0
                            END
                        ), 2
                    ) AS due_agent_usd,
                    ROUND(
                        SUM(
                            CASE 
                                WHEN i.currency = "PHP" THEN i.VARIANCE / l.exrate
                                WHEN i.currency = "USD" THEN i.VARIANCE
                                ELSE 0
                            END
                        ), 2
                    ) AS due_wallem_usd
                FROM tbl_agent_liquidation_items AS i
                JOIN tbl_agent_liquidation AS l
                    ON i.transno = l.transno
                WHERE i.status = 4
                    AND l.user_id = ?
                GROUP BY l.vessel_name, l.voyno
                ) AS subquery;
                ';
        $query = $this->db->query($sql, array($user_id));
        return $query->row();
   }

    
}