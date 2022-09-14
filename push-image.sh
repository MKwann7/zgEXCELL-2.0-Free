#!/bin/bash

# gcloud credential helper
# Download the Google SDK: https://cloud.google.com/sdk/docs/install-sdk
# Example (x86_64): https://dl.google.com/dl/cloudsdk/channels/rapid/downloads/google-cloud-cli-381.0.0-linux-x86_64.tar.gz
# Example (ARM):    https://dl.google.com/dl/cloudsdk/channels/rapid/downloads/google-cloud-cli-381.0.0-linux-arm.tar.gz
# or run in terminal (x86_64):  curl -O https://dl.google.com/dl/cloudsdk/channels/rapid/downloads/google-cloud-cli-381.0.0-linux-x86_64.tar.gz
# or run in terminal (ARM):     curl -O https://dl.google.com/dl/cloudsdk/channels/rapid/downloads/google-cloud-cli-381.0.0-linux-arm.tar.gz

# Extract SDK to a preferred location: ~/google-cloud-sdk or /app/programs/google-cloud-sdk
# tar -xf google-cloud-cli-381.0.0-linux-x86.tar.gz

# Run the installation Shell script
# ./google-cloud-sdk/install.sh

# Initialize Google Cloud
# ./google-cloud-sdk/bin/gcloud init

# Login Via a Web Browser
# "To continue, you must log in. Would you like to log in (Y/n)? Y"

# Pick cloud project to use:
# [1] [my-project-1]
# [2] [my-project-2]
# ...
# Please enter your numeric choice:

#docker rmi -f excell_app gcr.io/pristine-coda-320122/excell_app

echo "Building new maxr_app image."
./image.sh

echo "Tagging and pushing maxr_app to gcr.io/pristine-coda-320122."

docker tag excell_app:latest gcr.io/pristine-coda-320122/maxr_app:v1
docker push gcr.io/pristine-coda-320122/maxr_app:v1