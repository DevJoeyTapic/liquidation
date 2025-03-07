INSERT INTO liquidation_test.tbl_agents (
	agent_name
)
SELECT
 UCASE(NAME)
FROM trampsys_live.payee
WHERE supercargoes = 1