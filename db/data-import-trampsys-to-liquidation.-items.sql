INSERT INTO liquidation.tbl_agent_liquidation_items (
	user_id,
	supplier,
	author,
	transno,
	item,
	rfp_no,
	currency,
	rfp_amount,
	controlled,
	mode_payment,
	date_released
)
SELECT
	ua.user_id,
	re.supplier,
	re.user_account,
	re.transno,
	re.item,
	re.parent_id,
	re.currency,
	re.amount,
	im.is_visible,
	re.modepayment,
	re.datereleased
FROM trampsys_live.rfp_entry AS re
JOIN trampsys_live.item_master AS im
ON re.item_code = im.item_code
JOIN liquidation.user_account AS ua
ON re.supplier = ua.fullname
WHERE STATUS = 4
  AND YEAR(re.dateforapproval) = 2025
ORDER BY re.dateforapproval, re.parent_id, im.is_visible ASC;


	