# Setting up a new Account

## I. Terminals Manager
1. Create the account on the terminals manager (http://terminals.condorpos.ph)
2. Take note of the generated account code (e.g XXX0000) and account security key. It will be used to setup the subdomain and database name for the account.


## II. CPanel - Subdomain
1. Add the subdomain in Cpanel.
	Naming pattern:
	<Account Code>.cims-tna.condorpos.ph
		e.g. XXX0000.cims-tna.condorpos.ph
	Set the document root to public_html/cims-tna

## III. CPanel - Database
1. Add the database in CPanel.
	Naming pattern:
	cposph_cims-tna_<account code> e.g cposph_cims-tna_XXX0000
3. Restore default data
	mysql -h localhost -u cposph_cims-tna -p cposph_cims-tna_XXX0000 < /home/cposph/public_html/cims-tna/_resources/cims-tna.default.20160809.sql
	cposph_cims-tna/6fB!y-IJSrM&
	
IV. Configure App
	1. Add the datasource entry on the application config (public_html/cims-tna/config/datasources.php)
	Sample entry:
	'shard_XXX0000' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'host' => 'localhost',
			'username' => 'cposph_cims-tna',
			'password' => '***********',
			'database' => 'cposph_cims-tna_XXX0000',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
		],
	2. Configure system settings.
		- Set Account Security Key

## Notes:
mysqldump -h localhost -u cposph_cims-tna -p cposph_cims-tna_dev_012 | zip > /home/cposph/public_html/cims-tna/_resources/cims-tna.default.20160809.sql.zip

