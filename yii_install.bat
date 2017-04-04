if [ -f "config/db.php" ]
then
	> config/db.php
fi
if [ -f "config/params-local.php" ]
then
	> config/params-local.php
fi
if [ -f "config/web-local.php" ]
then
	> config/web-local.php
fi

echo "<?php

return [
	'class' => 'yii\db\Connection',
	'dsn' => 'mysql:host=localhost;dbname=ban_sach_online_db',
	'username' => 'root',
	'password' => 'root',
	'charset' => 'utf8',
];" >> config/db.php;

echo "<?php

return [
    'allowed_domains' => [
        'http://localhost:3000',
    ],
];" >> config/params-local.php;

echo "<?php

\$config = [
    'components' => [
    ],
];

return \$config;" >> config/web-local.php;