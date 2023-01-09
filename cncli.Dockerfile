FROM registry.raddcreative.io/lidonation/lidonation/ubuntu-ghc-cabal-libsodium-cardano:1.35.0

SHELL ["/bin/bash", "-c"]


# Expose ports
## cardano-node, EKG, Prometheus
EXPOSE 3010 3011 3012 12788 12798 6000

# Add scripts
RUN mkdir -p /config && apt-get update && apt-get install sqlite3 sudo jq -y
COPY src/pool/config/build/ /config/
COPY src/pool/cntools/ /cntools/

ADD src/pool/scripts/ /root/scripts/

RUN chmod -R +x /root/scripts/

RUN cp /root/.cabal/bin/cardano-node /usr/local/bin/ \
    && cp /root/.cabal/bin/cardano-cli /usr/local/bin/ \
    && curl -sLJ https://github.com/cardano-community/cncli/releases/download/v5.0.2/cncli-5.0.2-x86_64-unknown-linux-gnu.tar.gz -o /tmp/cncli-5.0.2-x86_64-unknown-linux-gnu.tar.gz \
    && tar xzvf /tmp/cncli-5.0.2-x86_64-unknown-linux-gnu.tar.gz -C /usr/local/bin/

RUN useradd -ms /bin/bash -d /home/cardano-node/ cardano-node \
    && echo "cardano-node ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/cardano-node \
    && chmod 0440 /etc/sudoers.d/cardano-node \
    && chown cardano-node /config

ENV PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/root/.cabal/bin:/root/.ghcup/bin:/root/.local/bin:/scripts:/scripts/functions"

CMD ["/usr/local/bin/cncli", "sync", "--host", "127.0.0.1", "--port", "3010", "--db", "/root/scripts/cncli.db"]
