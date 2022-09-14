#! /bin/bash

echo "Restarting Kubernetes."

project_path="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
export KUBECONFIG="${project_path}/../kube.config"

kubectl apply --validate=true --dry-run=client -f ./.kubernetes/
kubectl apply --validate=true -f ./.kubernetes/

kubectl -n circle-ci-k8s-dev rollout restart deployment/development-circle-deploy-dev