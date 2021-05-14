TBD

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

Container Registry

https://gitlab.com/ar-do/cntproject/container_registry
