#! /bin/bash

#cli commands with BashRc
#alias ll="ls -alF"
#alias doroot="sudo su"
#alias goex="cd /app/excell/web/code/"
#alias jb="/opt/jetbrains-toolbox-1.22.10970/jetbrains-toolbox"
#alias haprox="sudo nano /etc/haproxy/haproxy.cfg"
#alias loginEzProd="ssh -i '/home/mkwann7/Dropbox/My Life/Work/Acertus/_SshKeys/micah.acertus.ssh.key' micah.zak@34.69.128.50"
#alias loginMaxrQalv="ssh -i '/home/mkwann7/Dropbox/My Life/Work/ZakGraphix/SSHKeys/Micah.Private.ppk' micah@34.132.153.28"
#alias loginMaxrQalv="ssh -i '/home/mkwann7/Dropbox/My Life/Work/ZakGraphix/SSHKeys/Micah.Private.ppk' micah@3.136.112.42"

echo "Restarting Kubernetes."

project_path="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
export KUBECONFIG="${project_path}/../kube.config"

kubectl apply --validate=true --dry-run=client -f ./.kubernetes/
kubectl apply --validate=true -f ./.kubernetes/

kubectl -n circle-ci-k8s-dev rollout restart deployment/development-circle-deploy-dev