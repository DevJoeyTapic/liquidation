INSERT INTO liquidation.tbl_agent_liquidation (
    trampsys_id,
    user_id,
    supplier,
    transno,
    vessel_name,
    voyno,
    PORT,
    exrate,
    eta,
    etd,
    ata,
    atd
)
SELECT
    a.id,
    ua.user_id,
    UCASE(re.supplier),
    a.transno,
    vm.vessel_name,
    a.voyno,
    a.portselect,
    a.exrate,
    a.eta,
    a.etd,
    a.ata,
    a.atd
FROM trampsys.appointment AS a
JOIN trampsys.vessel_master AS vm
    ON a.selectves = vm.Vessel_ID
JOIN trampsys.rfp_entry AS re
    ON a.transno = re.transno
JOIN trampsys.payee AS p
    ON re.supplier = p.name
JOIN liquidation.user_account AS ua
ON re.supplier = ua.fullname
WHERE a.status != 6 
    AND p.supercargoes = 1
    AND YEAR(a.etd) = 2025
GROUP BY a.transno;
-- -----------------------------------------------
--
-- -----------------------------------------------
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
FROM trampsys.rfp_entry AS re
JOIN trampsys.item_master AS im
ON re.item_code = im.item_code
JOIN liquidation.user_account AS ua
ON re.supplier = ua.fullname
WHERE STATUS = 4
  AND YEAR(re.dateforapproval) = 2025
ORDER BY re.dateforapproval, re.parent_id, im.is_visible ASC;
	

