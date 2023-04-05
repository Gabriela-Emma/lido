FROM registry.lidonation.com/lidonation/lidonation/ubuntu-ghc-cabal-libsodium-cardano:1.35.7

SHELL ["/bin/bash", "-c"]

# Expose ports
## cardano-node, EKG, Prometheus
EXPOSE 3010 3011 3012 12788 12798 6000

# Add scripts
RUN mkdir -p /config && apt-get update && apt-get install sqlite3 sudo -y
COPY src/pool/config/build/ /config/
COPY src/pool/cntools/ /cntools/

ADD src/pool/scripts/ /scripts/

RUN chmod -R +x /scripts/

RUN useradd -ms /bin/bash cardano-node \
    && echo "cardano-node ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/cardano-node \
    && chmod 0440 /etc/sudoers.d/cardano-node \
    && chown cardano-node /config

RUN cp /root/.cabal/bin/cardano-node /usr/local/bin/ \
    && cp /root/.cabal/bin/cardano-cli /usr/local/bin/


RUN mkdir -p /data /ipc && chown -R cardano-node /data /ipc

USER cardano-node

ENV PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/root/.cabal/bin:/root/.ghcup/bin:/root/.local/bin:/scripts:/scripts/functions"

CMD ["/bin/bash", "entrypoint", "--start"]
