## Installation

### Kubernetes Umgebung aufsetzen

Zuerst müssen wir unsere Kubernetes Umgebung aufsetzten. Das Deployment haben wir anhand eines Cloud-Init Scriptes gemacht.


```
#cloud-config
users:
  - name: ubuntu
    sudo: ALL=(ALL) NOPASSWD:ALL
    groups: users, admin
    home: /home/ubuntu
    shell: /bin/bash
    lock_passwd: false
    plain_text_passwd: 'password'        
# login ssh and console with password
ssh_pwauth: true
disable_root: false    
packages:
  - unzip
runcmd:
  - sudo snap install microk8s --classic --channel=1.19
  - sudo usermod -a -G microk8s ubuntu
  - sudo microk8s enable dns ingress 
  - sudo mkdir -p /home/ubuntu/.kube
  - sudo microk8s config >/home/ubuntu/.kube/config
  - sudo chown -f -R ubuntu /home/ubuntu/.kube
  - sudo snap install kubectl --classic 
  - sh -c "echo 'deb http://download.opensuse.org/repositories/devel:/kubic:/libcontainers:/stable/xUbuntu_18.04/ /' | sudo tee /etc/apt/sources.list.d/devel:kubic:libcontainers:stable.list"
  - wget -nv https://download.opensuse.org/repositories/devel:kubic:libcontainers:stable/xUbuntu_18.04/Release.key -O /tmp/Release.key
  - sudo apt-key add - </tmp/Release.key
  - sudo apt-get update -qq
  - sudo apt-get -qq -y install buildah 
  - sudo mkdir /data
  - sudo chmod 777 /data
  - sudo apt-get install -y nfs-common
  - sudo mount -t nfs 10.0.41.8:/data/storage /data 
  - sudo microk8s kubectl apply -f https://raw.githubusercontent.com/ar-do/cntproject/main/persistentvolume.yaml
  - sudo microk8s kubectl apply -f https://raw.githubusercontent.com/mc-b/ar-do/cntproject/main/persistentvolumeclaim.yaml
  - sudo apt-get -qq -y install fuse-overlayfs
 ```
 
 ### MySQL Server aufsetzten
 
 Unsere Applikation verwendet ebenfalls eine Datenbank. Aus diesem Anlass müssen wir den Server aufsetzen.
 
 Das initiale Deployment geht am besten über ein Cloud-Init script:
 
 ```
 #cloud-config
users:
  - name: ubuntu
    sudo: ALL=(ALL) NOPASSWD:ALL
    groups: users, admin
    home: /home/ubuntu
    shell: /bin/bash
    lock_passwd: false
    plain_text_passwd: 'password'        
# login ssh and console with password
ssh_pwauth: true
disable_root: false    
packages:
  - unzip
runcmd:
- sudo apt-get install mysql-server
```
#### MySQL Server konfigurieren

Als nächstes muss der MySQL Server noch konfiguriert werden. Am einfachsten geht das mit folgendem Script

```
sudo mysql_secure_installation
```
Dieses Skript führt durch eine Reihe von Aufforderungen, in denen verschiedene Änderungen an den Sicherheitseinstellungen der MySQL-Einrichtung vorgenommen werden können.

```
Output
Securing the MySQL server deployment.

Connecting to MySQL using a blank password.

VALIDATE PASSWORD COMPONENT can be used to test passwords
and improve security. It checks the strength of password
and allows the users to set only those passwords which are
secure enough. Would you like to setup VALIDATE PASSWORD component?

Press y|Y for Yes, any other key for No: Y

There are three levels of password validation policy:

LOW    Length >= 8
MEDIUM Length >= 8, numeric, mixed case, and special characters
STRONG Length >= 8, numeric, mixed case, special characters and dictionary                  file

Please enter 0 = LOW, 1 = MEDIUM and 2 = STRONG:
0
```

Hier kein Password für den Root User setzten.

```
Output
Please set the password for root here.


New password:

Re-enter new password:
```
```
Output
Estimated strength of the password: 100
Do you wish to continue with the password provided?(Press y|Y for Yes, any other key for No) : Y
```

Weiter müssen wir noch die Datenbank inklusive der benötigten Tabelle erstellen.

MySQL Server als Root starten

```
sudo mysql -u root
```
Tabellen erstellen

```
CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_Id` int(11) NOT NULL,
  `post_Id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `content` text NOT NULL,
  `upvote` int(11) NOT NULL,
  `downvote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

```
```
CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `upvote` smallint(6) DEFAULT NULL,
  `downvote` smallint(6) DEFAULT NULL,
  `saved` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```
Indizes für die Tabelle `comments`
```
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);
```
 Indizes für die Tabelle `posts`
```
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);
```

AUTO_INCREMENT für Tabelle `comments`
```
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
```
AUTO_INCREMENT für Tabelle `posts`
```
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;
```

### Ingress aufsetzten
tbd
### Deployment

Container Image für Kubernetes aufbereiten

```
kubectl create deployment cntproject --image=registry.gitlab.com/ar-do/cntproject/cntproject
kubectl expose deployment/cntproject --port 80 --type="LoadBalancer"
kubectl apply -f https://raw.githubusercontent.com/ar-do/cntproject/main/ingress.yaml
```

Die Applikation läuft anschliessend auf folgender URL

http://10.2.39.3/cntproject/

![image](https://user-images.githubusercontent.com/79870123/118462490-03b45e00-b6ff-11eb-91c4-84329aff5da4.png)


### Architektur
tbd

Container Registry

https://gitlab.com/ar-do/cntproject/container_registry
