USE liquidation;
SET SQL_SAFE_UPDATES = 0;

INSERT INTO tbl_agent_liquidation(
	user_id,
	trampsys_id,
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
SELECT DISTINCT
	ua.user_id,
	a.id,
    UCASE(re.supplier),
	a.transno,
    UCASE(vm.Vessel_Name),
	a.voyno,
	a.portselect,
	a.exrate,
    a.eta,
    a.etd,
    a.ata,
    a.atd
FROM trampsys.appointment a
JOIN trampsys.vessel_master vm
	ON a.selectves = vm.Vessel_ID
JOIN trampsys.rfp_entry re  -- Added the missing alias
	ON a.transno = re.transno  -- Adjusted JOIN condition to include 're'
JOIN liquidation.user_account AS ua
	ON re.supplier = ua.fullname
LEFT JOIN liquidation.tbl_agent_liquidation 
	ON tbl_agent_liquidation.trampsys_id = a.id
WHERE a.`status` != 6 AND tbl_agent_liquidation.trampsys_id IS NULL;

-- Second INSERT INTO tbl_agent_liquidation_items
INSERT INTO tbl_agent_liquidation_items(
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
	UCASE(re.supplier),
    UCASE(re.user_account),
    re.transno,
    re.item,
    re.parent_id,
    re.currency,
    re.amount,
    im.is_visible,
    re.modepayment,
    re.datereleased
FROM trampsys.rfp_entry re
JOIN trampsys.item_master im
	ON re.item_code = im.item_code
JOIN liquidation.user_account ua
	ON re.supplier = ua.fullname
WHERE re.`status` = 4

