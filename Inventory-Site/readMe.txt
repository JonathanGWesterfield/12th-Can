How to run the tets :)
Run in the terminal in directory 12th-Can/Inventory-Site
Run the following commands in the terminal
*Make sure the database is clear as the register group tests would fail if the tests are already registered*

1. php artisan dusk --group=register
2. php artisan dusk --group=site

