---
titre : Projet de Construction d'Environnements avec Ansible
---

# Membres de l'équipe
- Ismaaili El Mehdi
- Taha Sadouki

# Objectifs
Ce projet vise à automatiser la création de deux environnements distincts (production et staging) en utilisant des playbooks Ansible et son écosystème.

# Architecture cible
On a travailler sur des instances OpenStack qu'on a crées qui sont: production-01, staging-01

# Notre Ecosystem Ansible

Ansible-Project
|
|___files
|   |___nginx
|   |   |___nginx.conf                 
|   |___php_app  
|       |___index.php      
|   
|___group_vars
|   |___all.yml
|   |___dbservers.yml
|   |___production
|   |___webservers.yml
|   |___staging.yml
|
|___host_vars
|   |___vm-cloud-prod-01.yml
|   |___vm-cloud-stag-01.yml
|
|___inventories
|   |___hosts.yml
|
|___roles
|   |___mysql
|   |    |___defaults    
|   |    |   |___main.yml           
|   |    |___tasks
|   |        |___main.yml               
|   |___nginx
|   |    |___defaults    
|   |    |   |___main.yml           
|   |    |___tasks
|   |        |___main.yml
|   |___php
|        |___defaults    
|        |   |___main.yml           
|        |____tasks
|        |    |___main.yml
|        |____templates
|             |___app.ini.j2   
|
|___common.yml
|
|
|___dbservers.yml
|
|
|___handler.yml
|
|
|___main.yml
|
|
|___webservers.yml

# Commandes pour lancer les playbooks
```bash
ansible-playbook webservers.yml -i inventories

ansible-playbook dbservers.yml -i inventories --ask-vault-pass     # pass = 2050

ansible-playbook main.yml -i inventories  --ask-vault-pass     # pass = 2050

ansible-playbook main.yml -i inventories --tags "nginx"

ansible-playbook main.yml -i inventories --tags "php"

ansible-playbook main.yml -i inventories --tags "mysql"    # pass = 2050

ansible-playbook main.yml -i inventories --tags "db"

ansible-playbook main.yml -i inventories --tags "installation"

ansible-playbook main.yml -i inventories --tags "configuration"

ansible-playbook main.yml -i inventories --tags "deployement"
```

## Script de Connexion mysql
````php
# Note: les mot de pass de base de données on chifrés par le vault chez les playbook
<?php
// MySQL server configuration
$db_host = 'localhost'; // Assuming MySQL server is running on the same host
$db_port = '3306'; // Default MySQL port

// Staging database configuration
$stag_db_name = 'db_stag'; // Staging database name
$stag_user = 'user2'; // Staging MySQL user
$stag_password = '46569610mmnn321'; // Staging MySQL password

// Production database configuration
$prod_db_name = 'db_prod'; // Production database name
$prod_user = 'user1'; // Production MySQL user
$prod_password = '46569610mmnn321'; // Production MySQL password

// Connect to Staging database
$stag_link = mysqli_connect($db_host, $stag_user, $stag_password, $stag_db_name, $db_port);

// Check if the connection to Staging database was successful
if (!$stag_link) {
    die('Could not connect to Staging database: ' . mysqli_connect_error());
}

// Connection successful message for Staging database
echo 'Connected successfully to Staging database.<br>';

// Close the Staging database connection
mysqli_close($stag_link);

// Connect to Production database
$prod_link = mysqli_connect($db_host, $prod_user, $prod_password, $prod_db_name, $db_port);

// Check if the connection to Production database was successful
if (!$prod_link) {
    die('Could not connect to Production database: ' . mysqli_connect_error());
}

// Connection successful message for Production database
echo 'Connected successfully to Production database.<br>';

// Echo "Hello world!" after two connection messages
echo 'Hello world!';
?>
````

# Note: les mot de pass de base de données on chifrés par le vault chez les playbook

````yml
# On a les decrypter avec le command --ask-vault-pass autant de lancement des playbook
prod_user: user1

prod_db_name: db_prod

mysql_prod_pass: !vault |
          $ANSIBLE_VAULT;1.2;AES256;devops
          62333035373439373666666431333637343162653838623162333239653337336164643038353465
          3661393931633036336338383266633033396433633438310a333966656165343137663539306332
          32346234663539613039643037343236653233663032376639633835343166353331363531396163
          3838353838396435640a656534323331616435633732326433393765356436323632303162613564
          3036
stag_user: user2

stag_db_name: db_stag

mysql_stag_pass: !vault |
          $ANSIBLE_VAULT;1.2;AES256;devops
          33643835636235323562306166616164323537613334663430306366383361346134326463663233
          3837306339366130353531383464613536653836616334630a376162373533633131626233333865
          34356538643838363932623161303835356561316434353330613464636666316661373032623566
          3934366565313065300a626337613861643762643165336564316262313366626165663733623561
          3231
````
