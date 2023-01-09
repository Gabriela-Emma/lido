# This Docker uses the multi-stage build feature of Docker.
# It kicks of the installation of Nix in a temporary alpine container,
# after which we copy the installation to an empty image that only contains Nix.

FROM alpine:3.8 as NIXER

# Enable HTTPS support in wget.
RUN apk add --no-cache openssl ca-certificates

# Install it in busybox for a start
COPY ./alpine-install.sh ./alpine-install.sh
RUN chmod +x ./alpine-install.sh && ./alpine-install.sh

ENV PATH=/nix/var/nix/profiles/default/bin:/usr/bin:/bin

RUN mkdir -p /config
COPY src/pool/config/build/ /config/

# Give us a basic environment
RUN nix-channel --add \
  https://nixos.org/channels/nixpkgs-unstable nixpkgs && \
  nix-channel --update

RUN nix-env -iA \
  nixpkgs.bashInteractive \
  nixpkgs.cacert \
  nixpkgs.coreutils \
  nixpkgs.gitMinimal \
  nixpkgs.gnutar \
  nixpkgs.gzip \
  nixpkgs.iana-etc \
  nixpkgs.xz \
  && true

# Remove old things
RUN \
  nix-channel --remove nixpkgs && \
  rm -rf /nix/store/*-nixpkgs* && \
  nix-collect-garbage -d

# Fixes missing hashes
RUN nix-store --verify --check-contents

# Fixes root login shell
RUN sed -e "s|/bin/ash|/bin/bash|g" -i /etc/passwd

# Now create the actual image
FROM alpine:3.12.1
LABEL maintainer="darlington@raddcreative.com"

COPY --from=NIXER /etc/group /etc/group
COPY --from=NIXER /etc/passwd /etc/passwd
COPY --from=NIXER /etc/shadow /etc/shadow
COPY --from=NIXER /nix /nix
COPY --from=NIXER /root /root

ENV \
    ENV=/nix/var/nix/profiles/default/etc/profile.d/nix.sh \
    PATH=/nix/var/nix/profiles/default/bin:/nix/var/nix/profiles/default/sbin:/bin:/sbin:/usr/bin:/usr/sbin:/cardano-db-sync/bin:/db-sync-node/bin:/cardano-db-sync/db-sync-node/bin:/home/cardano-db-sync/db-sync-node/bin \
    NIX_SSL_CERT_FILE=/nix/var/nix/profiles/default/etc/ssl/certs/ca-bundle.crt \
    NIX_PATH=/nix/var/nix/profiles/per-user/root/channels

# Install cardano-node
ARG VERSION
RUN echo "Building tags/$VERSION..." \
    && echo tags/$VERSION > /CARDANO_BRANCH \
    && git clone https://github.com/input-output-hk/cardano-db-sync \
    && cd cardano-db-sync \
    && git fetch --all --tags \
    && git tag \
    && git checkout tags/$VERSION \
    && nix-build -A cardano-db-sync -o db-sync-node \
    && rm -rf /nix \
    && rm -rf /etc/shadow \
    && rm -rf .git

RUN ls && ls /* && pwd
