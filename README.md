Changes 

/var/rayku/vendor/doctrine/dbal/lib/Doctrine/DBAL/Schema
 - Added `return true` to line 112 in order to fix duplicate table error generated when 
   running doctrine:schema:update

apachectl -k graceful
 - When "RuntimeException: Gd not installed" error occurs