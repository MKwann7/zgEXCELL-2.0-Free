#! /bin/bash

clear
reset

VERSION=2.0.0
OS=linux  # or "darwin" for OSX, "windows" for Windows.
ARCH=amd64  # or "386" for 32-bit OSs, "arm64" for ARM 64.

curl -fsSL "https://github.com/GoogleCloudPlatform/docker-credential-gcr/releases/download/v${VERSION}/docker-credential-gcr_${OS}_${ARCH}-${VERSION}.tar.gz" \
| tar xz --to-stdout ./docker-credential-gcr \
> /usr/local/bin/docker-credential-gcr && chmod +x /usr/local/bin/docker-credential-gcr


docker-credential-gcr configure-docker