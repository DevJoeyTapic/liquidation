INSERT INTO liquidation_test.tbl_agent_liquidation_items (
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
SELECT
    a.id,
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
FROM trampsys_live.appointment AS a
JOIN trampsys_live.vessel_master AS vm
    ON a.selectves = vm.Vessel_ID
JOIN trampsys_live.rfp_entry AS re
    ON a.transno = re.transno
JOIN trampsys_live.payee AS p
    ON re.supplier = p.name
WHERE a.status != 6 
    AND p.supercargoes = 1
    AND YEAR(a.etd) = 2025
GROUP BY a.transno;
