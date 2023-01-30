FROM registry.lidonation.com/lidonation/lidonation/ubuntu-ghc-cabal-libsodium-cardano:1.35.5

SHELL ["/bin/bash", "-c"]

EXPOSE 8080

# Add scripts
ADD src/pool/scripts/ /scripts/

RUN mkdir -p /config && apt-get update && apt-get install sudo -y

COPY src/pool/config/build/ /config/
COPY src/pool/cntools/ /cntools/

RUN chmod -R +x /scripts/

WORKDIR /scripts


ENV PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/root/.cabal/bin:/root/.ghcup/bin:/root/.local/bin:/scripts:/scripts/functions"

RUN useradd -ms /bin/bash cardano-node \
    && echo "cardano-node ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/cardano-node \
    && chmod 0440 /etc/sudoers.d/cardano-node \
    && chown cardano-node /config

CMD ["/bin/bash", "/entrypoint", "--start"]
